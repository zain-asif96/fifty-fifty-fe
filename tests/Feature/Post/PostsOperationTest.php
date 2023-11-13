<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostsOperationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_anyone_can_show_public_posts_filtered_by_country(): void
    {
        $this->setMexicanFakeIp();

        Post::factory(3)->create([
            'country_code' => 'MX'
        ]);

        $response = $this->get('/api/posts');

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json->has(3));
    }


    protected function setMexicanFakeIp(): string
    {
        $fake_ip = '132.247.0.0'; // Mexican IP Address

        $this->serverVariables = ['REMOTE_ADDR' => $fake_ip];

        return $fake_ip;
    }
}
