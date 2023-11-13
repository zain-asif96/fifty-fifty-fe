<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackTransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_view_track_transaction_page()
    {
        $response = $this->get('/track-transaction');

        $response->assertStatus(200);
    }

    public function test_user_can_track_a_transaction_by_id()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get('/track-transaction?transaction=' . $transaction->id);

        $response->assertStatus(200)
            ->assertSee($transaction->id);
    }

    public function test_user_can_not_access_track_page_with_invalid_trans_id()
    {
        $response = $this->get('/track-transaction?transaction=123456');

        $response->assertSessionHas('message.type', 'error');
        $response->assertSessionHas('message.content', 'Transaction not found!');
    }
}
