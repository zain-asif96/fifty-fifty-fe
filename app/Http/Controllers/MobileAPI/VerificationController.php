<?php

namespace App\Http\Controllers\MobileAPI;

use App\Classes\Twilio;
use App\Classes\UniqueNumberGenerator;
use App\Http\Requests\CodeVerificationRequest;
use App\Http\Requests\UserInfoRequest;
use App\Mail\EmailCodeGenerated;
use App\Models\OneTimeCode;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationController
{
    public function info(UserInfoRequest $userInfoRequest): array
    {
        $verificationCode = UniqueNumberGenerator::generate();

        Mail::to($userInfoRequest->email)->queue(new EmailCodeGenerated($verificationCode));

        if (app()->environment() === 'production') Twilio::sendVerificationCode($userInfoRequest->phone);

        Log::info($verificationCode);

        // we need to save this one time code to the user email and phone.
        OneTimeCode::create([
            'email' => $userInfoRequest->email,
            'phone' => $userInfoRequest->phone,
            'code' => $verificationCode
        ]);

        return [
            'status' => 'success',
            'user' => $userInfoRequest->toArray()
        ];
    }

    public function verify(CodeVerificationRequest $request):array
    {
        $status = 'invalid';

        $user = $request->user;

        $code = $request->code;

        $savedCodeModel = OneTimeCode::where([
            ['email', $user['email']],
            ['is_used', false]
        ])->first();

        if(!$savedCodeModel){
            $status = 'inValid';
        } else {
            $savedCode = $savedCodeModel->code;

            if ($code === $savedCode){
                $status = 'valid';
                $savedCodeModel->update(['is_used' => true]);
            };
        }

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
                        'transaction_id' => $transactionId ?? null,
                        'auth_method' => User::MOBILE_AUTH
                    ]
                ])
            );
            $token = $user->createToken($request->device_name)->plainTextToken;

            $device = $user->mobileDevices()->updateOrCreate(
                ['name' => $request->device_name],
                [
                    'token' => $token,
                    'fcm_token' => $request->fcm_token,
                    'device_id' => $request->device_id
                ]
            );

            if($transactionId){
                $this->putPostOnHold($transactionId);
            }
        }

        return ['status' => $status, 'transaction_id' => $transactionId ?? '', 'user' => $user ?? [], 'device' => $device ?? []];
    }

    protected function isPhoneCodeValid($phoneNumber, $code): bool
    {
        app()->environment() !== 'production'
            ? $isValid = true
            : $isValid = Twilio::checkVerificationCode($phoneNumber, $code);

        return $isValid;
    }

    protected function putPostOnHold($transaction_id): void
    {
        Post::where('transaction_id', $transaction_id)->first()->putOnHoldSelected();
    }
}
