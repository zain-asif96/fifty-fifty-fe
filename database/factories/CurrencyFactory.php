<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['code' => "string", 'name' => "string", 'rate' => "float", "country_id" => "integer"])]
    public function definition(): array
    {
        return [
            'code' => fake()->currencyCode(),
            'name' => fake()->currencyCode(),
            'rate' => fake()->randomFloat(2, 0, 30)
        ];
    }
}
