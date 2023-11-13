<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 * <\App\Models\Receiver>
 */
class ReceiverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'phone' => fake()->name(),
            'email' => 'john_doe@gmail.com',
            'country' => 'CA',
            'account_number' => fake()->iban(),
            'branch_number' => Str::random(10),
            'banking_info' => fake()->text(600)
        ];
    }
}
