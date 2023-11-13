<?php

namespace Tests\Feature\Cards;

use App\Models\Bank;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unauth_user_can_not_access_checkout_page(): void
    {
        $response = $this->get(route('checkout.page'));

        $response->assertStatus(302); // redirect to user info page.
    }

    public function test_auth_user_can_not_access_checkout_page_without_valid_payment_reference_identification()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('checkout.page'));

        $response->assertStatus(404); // payment intent not found.
    }

    public function test_user_can_access_checkout_page_with_valid_payment_reference_and_country()
    {
        $user = User::factory()->create();

        $paymentIntent = $user->paymentIntents()->create([
            'stripe_payment_intent_id' => '123456_id_reference_value',
            'amount' => 66,
            'currency' => 'cad'
        ]);

        $country = Country::factory()->create();
        Bank::factory()->create(['country_id' => $country->id]);

        $route = route('receiver.info.page', [
            'country' => $country->code,
            'payment-reference-identification' => $paymentIntent->stripe_payment_intent_id
        ]);

        $response = $this->actingAs($user)->get($route);

        $response->assertStatus(200);
    }
}
