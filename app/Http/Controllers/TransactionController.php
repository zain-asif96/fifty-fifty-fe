<?php

namespace App\Http\Controllers;

use App\Classes\Notify;
use App\Classes\Stripe;
use App\Models\Country;
use App\Models\Post;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class TransactionController extends Controller
{
    public function transactionInfoPage()
    {
        $user = auth()->user();

        if (!$user->email_verified_at) {
            $message = 'Please verify your contact information before making payment.';
            return stepNotCompletedResponse($message, '/verify-contacts');
        }

        if ($user->handlingTransaction()) {
            $user->handled_transaction = $user->getHandledTransaction();
        }

        return Inertia::render('Transaction/TransactionInfo', ['user' => $user, 'receivingCountries' => Country::receivingCountries()]);
    }

    public function trackTransactionPage(Request $request): Response
    {
        $transaction = Transaction::with('oppositeTransaction.user', 'user:id,first_name')
            ->where('id', $request->transaction)
            ->first();

        if (isset($request->transaction) && !$transaction) {
            request()
                ->session()
                ->flash('message', [
                    'content' => 'Transaction not found!',
                    'type' => 'error',
                ]);
        }

        return Inertia::render('Transaction/TimeLine', [
            'transaction' => $transaction,
        ]);
    }

    public function confirmPaymentToReceiver(Request $request): array
    {
        $transactionId = $request->transactionId;

        $transaction = Transaction::where('id', $transactionId)->first();

        if (!$transaction) {
            return ['status' => 'error'];
        }

        $transaction->update([
            'status' => Transaction::PAYMENT_TO_RECEIVER_CONFIRMED,
            'payment_to_receiver_confirmed_at' => Carbon::now(),
        ]);

        $transaction->oppositeTransaction()->update([
            'status' => Transaction::PAYMENT_TO_OPPOSITE_RECEIVER_CONFIRMED,
            'payment_to_opposite_receiver_confirmed_at' => Carbon::now(),
        ]);

        $transaction->load('oppositeTransaction');

        // When you receive confirmation form the opposite side:
        if ($transaction->oppositeTransaction->type === Transaction::TYPE_DIRECT) {
            $this->collectFeesAndReleaseHold($transaction->oppositeTransaction);

            Notify::transactionUpdated($transaction->oppositeTransaction->user, $transaction->oppositeTransaction, "Hi {$transaction->oppositeTransaction->user->first_name}, Your payment has been confirmed, money has been released to your card. Thank you for using 50-50!");

            $transaction->update([
                'status' => Transaction::TRANSACTION_COMPLETED,
                'transaction_completed_at' => Carbon::now(),
            ]);
        } else {
            Notify::transactionUpdated($transaction->oppositeTransaction->user, $transaction->oppositeTransaction, "Hi {$transaction->oppositeTransaction->user->first_name}, Your payment has been confirmed, payment to receiver is pending");
        }

        return ['status' => 'success', 'transaction' => $transaction];
    }

    protected function collectFeesAndReleaseHold($transaction)
    {
        $localPaymentIntent = $transaction->paymentIntent;
        $paymentIntent = Stripe::collectFeesAndReleaseHold($localPaymentIntent->stripe_payment_intent_id);
        if ($paymentIntent->status === 'succeeded') {
            $transaction->update([
                'status' => Transaction::TRANSACTION_COMPLETED,
                'transaction_completed_at' => Carbon::now(),
                'payment_status' => Transaction::PAYMENT_FEES_CAPTURED,
            ]);

            $localPaymentIntent->update([
                'status' => 'succeeded',
            ]);

            $transaction->post()->update([
                'status' => Post::COMPLETED,
            ]);
        }
    }
}
