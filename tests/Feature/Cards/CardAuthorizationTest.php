<?php

namespace Tests\Feature\Cards;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardAuthorizationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_unauth_user_can_not_access_authorized_card_page(): void
    {
        $response = $this->get(route('card.authorized.page'));

        $response->assertStatus(302); // redirect to user info page.
    }

}
