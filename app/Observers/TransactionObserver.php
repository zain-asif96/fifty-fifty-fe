<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;

class TransactionObserver
{
    public bool $afterCommit = true;

    /**
     * Handle the Transaction "created" event.
     *
     * @param Transaction $transaction
     * @return void
     */

    public function created(Transaction $transaction): void
    {
        $transaction->update(['hashed_id' => Crypt::encryptString($transaction->id)]);
    }

}
