<?php

namespace Tests\Feature\Transaction;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleTransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_not_handle_a_transaction_if_not_providing_transaction_id(): void
    {
        $response = $this->get(route('opposite.sender.user.info'));

        $response->assertStatus(404);
    }

    public function test_user_can_not_handle_a_transaction_if_the_corresponding_post_is_not_available(): void
    {
        $post = Post::factory()->create(['status' => Post::ON_HOLD]);
        $route = route('opposite.sender.user.info', [
            'source' => $post->transaction_id
        ]);

        $response = $this->get($route);

        $response->assertStatus(404);
    }

    public function test_user_can_handle_a_transaction_if_the_corresponding_post_is_available(): void
    {
        $post = Post::factory()->create(['status' => Post::AVAILABLE]);

        $route = route('opposite.sender.user.info', [
            'source' => $post->transaction->hashed_id
        ]);

        $response = $this->get($route);

        $response->assertStatus(200);
    }


    public function test_user_can_con_handle_a_transaction_with_not_hashed_id(): void
    {
        $post = Post::factory()->create(['status' => Post::AVAILABLE]);

        $route = route('opposite.sender.user.info', [
            'source' => $post->transaction->id
        ]);

        $response = $this->get($route);

        $response->assertStatus(404);
    }
}
