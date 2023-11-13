<?php

namespace Tests\Feature\Transaction;

use App\Mail\EmailCodeGenerated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UserInfoValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_money_page_can_be_rendered_only_for_supported_countries()
    {
        $response = $this->get(route('user.info.page'));

        $response->assertStatus(302); // redirect
    }

    public function test_user_should_submit_valid_data()
    {
        $response = $this->post('/api/validate-info', [
            'first_name' => 'John',
            'last_name' => '', // empty
            'phone' => '+123456789',
            'email' => 'not_valid_email',
        ]);

        $response->assertValid('first_name');
        $response->assertInvalid(['last_name', 'email']);
    }

    public function test_status_success_after_personal_info_validation_passed()
    {
        $fake_ip = $this->setFakeIp();

        $response = $this->sendValidPersonalInfoRequest();

        $response->assertSessionHas('current_user_' . $fake_ip);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);
    }

    protected function setFakeIp($ip = '192.168.1.1'): string
    {
        // MX: '132.247.0.0 // CA: 45.44.122.61
        $this->serverVariables = ['REMOTE_ADDR' => $ip];

        return $ip;
    }

    protected function sendValidPersonalInfoRequest(): TestResponse
    {
        return $this->post('/api/validate-info', [
            'first_name' => 'John',
            'last_name' => 'John Doe',
            'country' => 'CA',
            'phone' => '123456789',
            'email' => 'John_doe@gmail.com',
        ]);
    }

    public function test_mail_queued_after_personal_info_validation_passed()
    {
        Mail::fake();

        $response = $this->sendValidPersonalInfoRequest();

        Mail::assertQueued(EmailCodeGenerated::class);

        $response->assertStatus(200);
    }

    public function test_a_unique_code_is_generated_and_cached_by_ip()
    {
        $fake_ip = $this->setFakeIp();

        $response = $this->sendValidPersonalInfoRequest();

        $response->assertStatus(200);

        $this->assertDatabaseHas('cache', [
            'key' => "fiftyfiftytesting_cache_" . $fake_ip . "_email_code",
        ]);
    }
}
