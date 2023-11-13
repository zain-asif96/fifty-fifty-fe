<?php

namespace Tests\Feature\Transaction;

use App\Http\Controllers\VerificationController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CodeVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_not_access_verify_page_without_passing_personal_info_step()
    {
        $response = $this->get('/verify-contacts');

        $response->assertStatus(302); // redirect
    }

    public function test_user_can_access_verify_page_if_has_personal_info()
    {
        $fake_ip = $this->setFakeIp();

        $response = $this->withSession(["current_user_{$fake_ip}" => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john_doe@yahoo.com',
            'phone' => '123456789'
        ]])->get('/verify-contacts');

        $response->assertStatus(200);
    }

    protected function setFakeIp(): string
    {
        $fake_ip = '192.168.1.1';

        $this->serverVariables = ['REMOTE_ADDR' => $fake_ip];

        return $fake_ip;
    }


    public function test_code_validation_rules()
    {
        $response = $this->post('/api/verify-user', [
            'code' => '123a'
        ]);

        $response->assertInValid('code');
    }
}
