<?php

namespace App\Http\Controllers;

use App\Classes\GeoLocation;
use App\Classes\Twilio;
use App\Classes\UniqueNumberGenerator;
use App\Http\Requests\GetBankRequest;
use App\Http\Requests\UserInfoRequest;
use App\Mail\EmailCodeGenerated;
use App\Models\Commission;
use App\Models\Country;
use App\Models\Receiver;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use App\Http\Requests\PaymentInformationRequest;

class UsersController extends Controller
{

    public function userInfoPage()
    {
        $locationDetails = GeoLocation::getCurrentUserLocationDetails();
        $commissions = Commission::all();

        if (!Country::isSupportingSending($locationDetails['country_code'])) {
            return redirect(route('available.posts.page'));
        }
        $receivingCountries = Country::receivingCountries();
        return Inertia::render('Transaction/UserInfo', compact('receivingCountries', 'commissions'));
    }

    #[ArrayShape(['status' => "string", 'user' => "\App\Http\Requests\UserInfoRequest"])]
    public function validateUserInfo(UserInfoRequest $userInfoRequest): array
    {
        if ($userInfoRequest->flag === 'send_now'){
            Receiver::create([
                'user_id' => auth()->id() ?? User::latest()->first()->id,
                'bank_id' => $userInfoRequest->receiver_bank_id,
                'first_name' => $userInfoRequest->receiver_first_name,
                'last_name' => $userInfoRequest->receiver_last_name,
                'email' => $userInfoRequest->receiver_email,
                'phone' => $userInfoRequest->receiver_phone,
                'country' => $userInfoRequest->receiver_country,
                'account_number' => $userInfoRequest->receiver_account_number,
                'branch_number' => $userInfoRequest->receiver_branch_number,
                'banking_info' => $userInfoRequest->receiver_banking_info,
                'type'=> $userInfoRequest->type,
            ]);
        }

        $verificationCode = UniqueNumberGenerator::generate();

        Cache::put("{$userInfoRequest->ip()}_email_code", $verificationCode, now()->addMinutes(10));

        Mail::to($userInfoRequest->email)->queue(new EmailCodeGenerated($verificationCode));

        if (app()->environment() === 'production') Twilio::sendVerificationCode($userInfoRequest->phone);

        Log::info($verificationCode);

        User::putUserIntoSession($userInfoRequest->toArray());
        return [
            'status' => 'success',
            'user' => $userInfoRequest
        ];
    }

    public function getInternationalBanks(GetBankRequest $request): array
    {
        $countryCode = $request->country_code;
        $banks = Country::getCountryByCode($countryCode);
        return [
            'status' => 'success',
            'banks' => $banks->banks
        ];
    }

}
