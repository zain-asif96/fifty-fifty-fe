<?php

namespace App\Classes;

use App\Events\TransactionUpdated;
use App\Notifications\TransactionStatusUpdated;
use Illuminate\Support\Facades\Log;

class Notify
{
    public static function transactionUpdated($user, $transaction, $text): void
    {
        try {
            $user->notify(new TransactionStatusUpdated($transaction, $text));
        } catch (\Exception $exception) {
            Log::error('An error happened while sending mail - transaction initialized:' . $exception->getMessage());
        }

        self::broadcastUpdates($transaction->id);
    }

    protected static function broadcastUpdates($transactionId): void
    {
        broadcast(new TransactionUpdated($transactionId))->toOthers();
    }
}
