<?php

namespace App\Http\Controllers;

use App\Classes\Notify;
use App\Classes\Stripe;
use App\Http\Requests\PaymentInformationRequest;
use App\Models\PaymentIntent;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class PaymentsController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function collectPaymentInformation(PaymentInformationRequest $request): array
    {
        $user = auth()->user();

        if ($user->handlingTransaction()) {
            return $this->setLocalPaymentIntent($user);
        }

        return $this->setStripePaymentIntent($request, $user);
    }

    public function collectPaymentInformationForAPI(PaymentInformationRequest $request): array
    {
        $user = auth()->user();

        if ($user->handlingTransaction()) {
            return $this->setLocalPaymentIntent($user);
        }

        return $this->setStripePaymentIntent($request, $user, false);
    }

    protected function setLocalPaymentIntent($user): array
    {
        $handledTransaction = $user->getHandledTransaction();

        $paymentIntent = $user->paymentIntents()->create([
            'amount' => $handledTransaction->paymentIntent->amount_in_receiver_currency,
            'currency' => getCurrencyByCountryCode($handledTransaction->receiver->country),
            'status' => 'local',
        ]);

        return ['status' => 'success', 'paymentIntent' => $paymentIntent];
    }

    protected function setStripePaymentIntent($request, $user, $auto = true): array
    {

        $paymentIntent = Stripe::createPaymentIntent($request, $auto);
        if (!$paymentIntent->id) return ['status' => 'error'];


        $user->paymentIntents()->create([
            'stripe_payment_intent_id' => $paymentIntent ? $paymentIntent->id : '',
            'amount' => $paymentIntent->amount,
            'currency' => $paymentIntent->currency,
            'status' => $paymentIntent->status,
        ]);

        return ['status' => 'success', 'paymentIntent' => $paymentIntent];
    }

    protected function makePayment(Request $request){
        $request->validate([
            'card_number' => 'required',
            'card_exp_month' => 'required',
            'card_exp_year' => 'required',
            'card_cvc' => 'required',
        ]);

        // payment intent:
        $user = auth()->user();

        $paymentIntent = $user->paymentIntents()
            ->where('stripe_payment_intent_id', request('payment-reference-identification'))
            ->orWhere('id', request('payment-reference-identification'))
            ->first();

        // create payment method:
        $paymentMethod = Stripe::createPaymentMethod($request->toArray());

        // confirm the payment hold on the created method:
        $paymentIntent = Stripe::confirmPayment($paymentIntent->stripe_payment_intent_id, [
            'payment_method' => $paymentMethod->id
        ]);

        if ($paymentIntent->status === 'requires_capture') {

            $this->updateLocalPaymentIntent($paymentIntent);

            $transaction = $this->initializeTransaction($paymentIntent);

            Post::createTransactionPost($transaction->fresh());

            Notify::transactionUpdated($transaction->user, $transaction, "Hi {$transaction->user->first_name}, Your transaction has been initialized.");
        }

        $paymentIntent['transaction_id'] = $transaction->id;

        return $paymentIntent;
    }


    protected function updateLocalPaymentIntent($stripePaymentIntent)
    {
        $localPaymentIntent = PaymentIntent::where('stripe_payment_intent_id', $stripePaymentIntent->id)->first();

        $localPaymentIntent->update(['status' => 'requires_capture']);
    }

    protected function initializeTransaction($stripePaymentIntent)
    {
        $user = auth()->user();

        $localPaymentIntent = PaymentIntent::where('stripe_payment_intent_id', $stripePaymentIntent->id)
            ->first();

        $transaction = $user->transactions()->create([
            'payment_intent_id' => $localPaymentIntent->id,
            'receiver_id' => $localPaymentIntent->receiver_id,
            'status' => Transaction::PAIRING_PENDING,
            'payment_status' => Transaction::PAYMENT_ON_HOLD
        ]);

        $user->update(['transaction_id' => $transaction->id]);

        return $transaction;
    }
}
