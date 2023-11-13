<?php

namespace Tests\Feature\Transaction;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // Transaction info page
    public function test_user_can_access_transaction_page_after_beign_authenticated_and_verified()
    {
        $user = User::factory(['email_verified_at' => now()])->create();

        $response = $this->actingAs($user)->get(route('transaction.info.page'));

        $response->assertStatus(200);
    }

    public function test_user_can_not_access_transaction_page_if_not_authenticated()
    {
        $response = $this->get(route('transaction.info.page'));

        $response->assertStatus(302);
    }

    public function test_user_can_not_access_transaction_page_without_being_verified()
    {
        $user = User::factory(['email_verified_at' => null])->create();

        $response = $this->actingAs($user)->get(route('transaction.info.page'));

        $response->assertStatus(302);
    }

    public function test_user_can_not_submit_invalid_values_for_transaction_info()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('collect.payment.information'), [
            'amount' => 'not-numeric',
            'currency' => '' // empty
        ]);

        $response->assertInValid(['amount', 'currency']);
    }

    public function test_user_can_submit_transaction_info_and_create_stripe_payment_intent()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('collect.payment.information'), [
            'amount' => 100,
            'currency' => 'CAD',
            'country' => 'EG'
        ]);

        $this->assertNotEmpty($response->json('paymentIntent.id'));

        $response
            ->assertValid(['amount', 'currency'])
            ->assertJson([
                'status' => 'success',
            ]);
    }
}
