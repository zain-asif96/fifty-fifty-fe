<?php

namespace App\Http\Controllers;

use App\Classes\Twilio;
use App\Classes\UniqueNumberGenerator;
use App\Http\Requests\CodeVerificationRequest;
use App\Mail\EmailCodeGenerated;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifyUserPage(): Response|FoundationResponse
    {

        $user = User::getUserFromSession();
        // $transactionInfo = User::getReceiverFromSession();
        if (!$user) {
            $message = 'Please enter your personal information.';
            return stepNotCompletedResponse($message, '/user-info');
        }

        if (isset($user['transactionId']) && (request('source') !== $user['transactionId'])) {
            $message = 'Invalid source, please choose correct post';
            return stepNotCompletedResponse($message, '/handle-transaction?source=' . $user['transactionId']);
        }

        $user['email'] = '**********' . substr($user['email'], 10, strlen($user['email']) - 10);
        $user['phone'] = '*****' . substr($user['phone'], 7, strlen($user['email']) - 7);
        return Inertia::render('Transaction/VerifyContacts', ['user' => $user]);
    }


    #[ArrayShape(['status' => "mixed|string", 'user' => "mixed"])]
    public function verifyUser(CodeVerificationRequest $request): array
    {
        $status = 'invalid';

        $user = User::getUserFromSession();

        $code = $request->code;

        $cachedCode = Cache::get("{$request->ip()}_email_code");

        if ($code === $cachedCode) $status = 'valid';

        $transactionId = null;

        if (isset($user['transactionId'])) {
            $transactionId = Crypt::decryptString($user['transactionId']);
        }

        if ($status === 'valid' || $this->isPhoneCodeValid($user['phone'], $code)) {
            $status = 'valid';

            $user = User::updateOrCreate(
                ['email' => $user['email']],
                Arr::collapse([$user,
                    [
                        'ip_address' => request()->ip(),
                        'email_verified_at' => Carbon::now(),
                        'transaction_id' => $transactionId,
                        'auth_method' => User::AUTO_AUTH_METHOD
                    ]
                ])
            );

            if($transactionId){
                $this->putPostOnHold($transactionId);
            }

            Auth::loginUsingId($user->id);
        }

        return ['status' => $status, 'user' => $user ?? []];
    }

    protected function isPhoneCodeValid($phoneNumber, $code): bool
    {
        app()->environment() !== 'production'
            ? $isValid = true
            : $isValid = Twilio::checkVerificationCode($phoneNumber, $code);

        return $isValid;
    }

    public function resendEmailCode(): array
    {
        $user = User::getUserFromSession();

        if (!$user) {
            return [
                'status' => 'redirect',
                'redirect_url' => '/user-info'
            ];
        }

        $cachedCode = Cache::get(request()->ip() . "_email_code");

        if (!$cachedCode) {
            $cachedCode = UniqueNumberGenerator::generate();
            Cache::put(request()->ip() . "_email_code", $cachedCode, now()->addMinutes(10));
        }

        Mail::to($user['email'])->send(new EmailCodeGenerated($cachedCode));

        return [
            'status' => 'success',
        ];
    }

    protected function putPostOnHold($transaction_id)
    {
        Post::where('transaction_id', $transaction_id)->first()->putOnHoldSelected();
    }
}
