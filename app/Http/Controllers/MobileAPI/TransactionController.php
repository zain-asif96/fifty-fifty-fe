<?php

namespace App\Http\Controllers\MobileAPI;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController
{


    public function track(Request $request){
        $transaction = Transaction::with('oppositeTransaction.user', 'user:id,first_name')->where('id', $request->transaction_id)->first();

        if(!$transaction){
            abort(404, 'No transaction found');
        }

        return $transaction;
    }
}
