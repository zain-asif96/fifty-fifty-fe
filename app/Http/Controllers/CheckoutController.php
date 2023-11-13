<?php

namespace App\Http\Controllers;

use App\Classes\Notify;
use App\Classes\Stripe;
use App\Models\PaymentIntent;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class CheckoutController extends Controller
{

    public function checkoutPage(): Response|FoundationResponse
    {
        $paymentIntent = $this->getLocalPaymentIntent();

        if (!$paymentIntent || $paymentIntent->status === 'requires_capture') {
            abort(404);
        }

        $user = auth()->user();

        if ($user->handlingTransaction()) {

            $user->handled_transaction = $user->getHandledTransaction();
            $stripePaymentIntent = null;
            $stripeConfig = [];

        } else {
            $stripePaymentIntent = Stripe::retrievePaymentIntent($paymentIntent->stripe_payment_intent_id);

            $stripeConfig = [
                'public_key' => config('services.stripe.public_key'),
                'redirect_url' => config('services.stripe.redirect_url'),
            ];
        }


        return Inertia::render('Transaction/Checkout', ['user' => $user, 'paymentIntent' => $stripePaymentIntent, 'stripeConfig' => $stripeConfig]);
    }

    protected function getLocalPaymentIntent()
    {
        $user = auth()->user();

        return $user->paymentIntents()
            ->where('stripe_payment_intent_id', request('payment-reference-identification'))
            ->orWhere('id', request('payment-reference-identification'))
            ->first();
    }

    /**
     * Request redirected from stripe will have 2 props
     *
     * @param Request $request
     * @return Response|FoundationResponse
     * @throws ApiErrorException
     */
    public function cardAuthorized(Request $request): Response|FoundationResponse
    {
        if (!$request->payment_intent) {
            abort(404);
        }

        $stripePaymentIntent = Stripe::retrievePaymentIntent($request->payment_intent);

        $oldTransaction = $this->getOldTransaction($stripePaymentIntent);

        if ($oldTransaction) {
            return Inertia::render('Transaction/TimeLine', ['transaction' => $oldTransaction]);
        }

        if ($stripePaymentIntent->status === 'requires_capture') {

            $this->updateLocalPaymentIntent($stripePaymentIntent);

            $transaction = $this->initializeTransaction($stripePaymentIntent);

            Post::createTransactionPost($transaction->fresh());

            Notify::transactionUpdated($transaction->user, $transaction, "Hi {$transaction->user->first_name}, Your transaction has been initialized.");

            return Inertia::render('Transaction/TimeLine', ['transaction' => $transaction->fresh()->load('oppositeTransaction', 'user')]);
        }

        return stepNotCompletedResponse('Something went wrong with the payment', '/transaction-info');
    }

    protected function getOldTransaction($stripePaymentIntent)
    {
        $localPaymentIntent = PaymentIntent::where('stripe_payment_intent_id', $stripePaymentIntent->id)->first();

        if (!$localPaymentIntent) {
            return false;
        }
        return Transaction::with('oppositeTransaction', 'user:id,first_name')->where('payment_intent_id', $localPaymentIntent->id)->first();
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

        return $user->transactions()->create([
            'payment_intent_id' => $localPaymentIntent->id,
            'receiver_id' => $localPaymentIntent->receiver_id,
            'status' => Transaction::PAIRING_PENDING,
            'payment_status' => Transaction::PAYMENT_ON_HOLD
        ]);
    }

    public function transactionCompleted(Request $request){
        $transactionId= $request->get('transactionId');
        $data = [
        'transactionId'=>$transactionId,
    ];
        return Inertia::render('Transaction/CompleteTransaction',['transactionId'=>$transactionId]);
    }
}
