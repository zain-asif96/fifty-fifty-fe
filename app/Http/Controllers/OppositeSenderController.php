<?php

namespace App\Http\Controllers;

use App\Classes\Notify;
use App\Http\Requests\TransactionPaymentProofRequest;
use App\Models\Post;
use App\Models\Transaction;
use App\Notifications\TransactionStatusUpdated;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class OppositeSenderController extends Controller
{
    public function handleTransactionPage(): Response|FoundationResponse
    {
        // check for transaction source.
        $transactionHashedId = request('source');

        try {
            $transactionId = Crypt::decryptString($transactionHashedId);
        } catch (DecryptException $e) {
            abort(404);
        }

        Post::where([
            ['transaction_id', $transactionId],
            ['status', Post::AVAILABLE]
        ])->firstOrFail();

        if (!$transactionId) {
            return stepNotCompletedResponse('Please choose an active post to complete', route('welcome'));
        }

        return Inertia::render('OppositeSender/UserInfo', [
            'transactionId' => $transactionHashedId
        ]);
    }

    #[ArrayShape(['status' => "string", 'transaction' => "mixed"])]
    public function uploadPaymentProofForDirectTransaction(TransactionPaymentProofRequest $request): array
    {
        // $request->transaction_id : this is the Direct transaction id.
        $path = $this->uploadFileAndGetPath($request);

        $transaction = Transaction::where('id', $request->transaction_id)->first();

        $this->savePaymentProofToPaymentIntent($transaction->paymentIntent(), $path);

        $transaction->update([
            'status' => Transaction::PAYMENT_TO_OPPOSITE_RECEIVER_COMPLETE
        ]);

        $transaction->oppositeTransaction()->update([
            'status' => Transaction::PAYMENT_TO_RECEIVER_COMPLETE
        ]);

        Notify::transactionUpdated(
            $transaction->oppositeTransaction->user,
            $transaction->oppositeTransaction,
            "Hi {$transaction->oppositeTransaction->user->first_name}, Payment to receiver complete, please confirm receiving by viewing payment proof on our website."
        );

        return [
            'status' => 'success',
            'transaction' => $transaction
        ];
    }

    protected function uploadFileAndGetPath($request)
    {
        // TODO: we set the name of the file to clear it later after 30 days maybe.
        return $request->file('payment_proof_file')->store('public/payment_proofs');
    }

    protected function savePaymentProofToPaymentIntent($paymentIntent, $path)
    {
        $paymentIntent->update([
            'payment_proof' => str_replace('public', 'storage', $path)
        ]);
    }

    public function uploadPaymentProof(TransactionPaymentProofRequest $request): array
    {
        // $request->transaction_id : this is the Direct transaction id which has been made already.
        $directTransaction = Transaction::where('id', $request->transaction_id)->first();

        $path = $this->uploadFileAndGetPath($request);

        $paymentIntent = $this->getPaymentIntent($request); // Payment intent of the opposite transaction.


        if (!$paymentIntent) {
            return [
                'status' => 'error',
                'message' => 'Invalid payment reference identification'
            ];
        }

        $oppositeTransaction = $this->createOppositeTransaction($request, $paymentIntent);

        $this->savePaymentProofToPaymentIntent($paymentIntent, $path);

        $this->linkOppositeTransactionWithDirect($directTransaction, $oppositeTransaction);

        Notify::transactionUpdated(
            $directTransaction->user,
            $directTransaction,
            "Hi {$directTransaction->user->first_name}, Payment to receiver is complete, please confirm receiving by viewing the proof on our website."
        );

        Notify::transactionUpdated(
            $oppositeTransaction->user,
            $oppositeTransaction,
            "Hi {$oppositeTransaction->user->first_name}, Your transaction has been initialized, payment confirmation pending."
        );

        return [
            'status' => 'success',
            'transaction' => $oppositeTransaction
        ];

    }

    protected function getPaymentIntent($request)
    {
        return auth()->user()->paymentIntents()->where('id', $request->payment_intent_id)->first();
    }

    protected function createOppositeTransaction($request, $paymentIntent)
    {
        return auth()->user()->transactions()->create([
            'type' => Transaction::TYPE_OPPOSITE,
            'status' => Transaction::PAIRING_COMPLETE,
            'opposite_transaction_id' => $request->transaction_id,
            'receiver_id' => $paymentIntent->receiver_id,
            'payment_intent_id' => $paymentIntent->id,
            'payment_status' => Transaction::PAYMENT_NOT_REQUIRED,
        ]);
    }

    protected function linkOppositeTransactionWithDirect($transaction, $oppositeTransaction)
    {
        $transaction->update([
            'opposite_transaction_id' => $oppositeTransaction->id,
            'status' => Transaction::PAYMENT_TO_RECEIVER_COMPLETE,
            'payment_to_receiver_completed_at' => Carbon::now(),
        ]);
    }

}
