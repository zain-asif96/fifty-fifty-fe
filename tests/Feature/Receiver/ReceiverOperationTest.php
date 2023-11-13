<?php

namespace Tests\Feature\Receiver;

use App\Models\Bank;
use App\Models\Country;
use App\Models\Receiver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiverOperationTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_not_access_receiver_information_page_without_valid_payment_reference()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/receiver-info?payment-reference-identification=non-valid-value');

        $response->assertStatus(404);
    }

    public function test_user_can_access_receiver_information_page_with_valid_payment_reference_and_country()
    {
        $user = User::factory()->create();

        $paymentIntent = $user->paymentIntents()->create([
            'stripe_payment_intent_id' => '123456_id_reference_value',
            'amount' => 66,
            'currency' => 'cad',
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

    public function test_user_can_not_make_receiver_without_verification()
    {
        $user = User::factory()->create();

        $receiver = Receiver::factory()->create(['user_id' => $user->id]);

        $response = $this->post("/api/{$user->id}/receiver", $receiver->toArray());

        $response->assertStatus(403);
    }

    public function test_user_can_create_a_receiver_if_verified()
    {
        $user = User::factory()->create();

        $paymentIntent = $user->paymentIntents()->create([
            'stripe_payment_intent_id' => '123456_id_reference_value',
            'amount' => 66,
            'currency' => 'cad',
        ]);

        $receiver = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '+123456789',
            'email' => 'john_doe@gmail.com',
            'country' => 'CA',
            'bank_id' => Bank::factory()->create()->id,
            'account_number' => '123456',
            'branch_number' => '003',
            'banking_info' => 'Please send money using interact',
            'paymentIntentId' => $paymentIntent->stripe_payment_intent_id,
        ];


        $response = $this->actingAs($user)->post("/api/{$user->id}/receiver", $receiver);

        $response->assertStatus(201);

        $this->assertDatabaseHas('receivers', ['email' => $receiver['email']]);
    }

    public function test_user_can_update_a_receiver_if_verified()
    {
        $user = User::factory()->create();

        $receiver = Receiver::factory()->create(['user_id' => $user->id, 'bank_id' => Bank::factory()->create()->id]);

        $paymentIntent = $user->paymentIntents()->create([
            'stripe_payment_intent_id' => '123456_id_reference_value',
            'amount' => 66,
            'currency' => 'cad',
        ]);

        $newFirstNameValue = 'UPDATED';

        $receiver->first_name = $newFirstNameValue;

        $receiver->paymentIntentId = $paymentIntent->stripe_payment_intent_id;

        $response = $this->actingAs($user)->put("/api/receiver/{$receiver->id}", $receiver->toArray());

        $response->assertStatus(200);

        $this->assertDatabaseHas('receivers', [
            'email' => $receiver->email,
            'first_name' => $newFirstNameValue
        ]);

        $this->assertTrue((bool)$response);
    }

}
