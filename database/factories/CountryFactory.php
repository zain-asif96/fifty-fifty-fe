<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'label' => 'Canada',
            'code' => 'CAN',
            'currency_id' => Currency::factory()->create()->id,
            'can_send' => 'Y',
            'can_receive' => 'Y',
        ];
    }
}
