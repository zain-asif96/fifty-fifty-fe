<?php

namespace Database\Factories;

use App\Models\PaymentIntent;
use App\Models\Receiver;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        $paymentIntent = PaymentIntent::factory()->create([
            'user_id' => $user->id
        ]);
        $receiver = Receiver::factory()->create([
            'user_id' => $user->id
        ]);

        return [
            'user_id' => $user->id,
            'receiver_id' => $receiver->id,
            'payment_intent_id' => $paymentIntent->id,
            'status' => Transaction::TRANSACTION_INITIALIZED,
            'payment_status' => Transaction::PAYMENT_ON_HOLD,
        ];
    }
}
