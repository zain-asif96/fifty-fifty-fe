<?php

namespace App\Classes;

use App\Interfaces\PhoneVerification;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Api\V2010\Account\MessageInstance;
use Twilio\Rest\Client;

class Twilio implements PhoneVerification
{
    /**
     * @var Repository|Application|mixed|string
     */
    private static mixed $sid;

    /**
     * @var Repository|Application|mixed|string
     */
    private static mixed $token;

    /**
     * @var Repository|Application|mixed|string
     */
    private static mixed $serviceId;

    /**
     * @var Repository|Application|mixed|string
     */
    private static mixed $SMSServiceId;

    /**
     * @var Repository|Application|mixed|string
     */
    private static mixed $fromPhone;

    public static function init()
    {
        self::$sid = config('services.twilio.sid');
        self::$token = config('services.twilio.token');
        self::$serviceId = config('services.twilio.service_id');
        self::$SMSServiceId = config('services.twilio.SMSService_id');
        self::$fromPhone = config('services.twilio.from_phone');
    }

    public static function sendVerificationCode($phoneNumber): string
    {
        $twilio = self::getTwillioClient();

        $verification = $twilio->verify->v2->services(self::$serviceId)
            ->verifications
            ->create($phoneNumber, "sms");

        return $verification->sid;
    }

    private static function getTwillioClient()
    {
        return new Client(self::$sid, self::$token);
    }


    public static function checkVerificationCode($phoneNumber, $code): bool
    {
        $twilio = self::getTwillioClient();

        $verification_check = $twilio->verify->v2->services(self::$serviceId)
            ->verificationChecks
            ->create([
                    "to" => $phoneNumber,
                    "code" => $code
                ]
            );

        Log::info($verification_check->status);

        return $verification_check->status === 'approved';
    }

    public static function validatePhoneNumber($phoneNumber): bool
    {
        $twilio = self::getTwillioClient();

        $phone_number = $twilio
            ->lookups
            ->v2
            ->phoneNumbers($phoneNumber)
            ->fetch();

        return $phone_number->valid;
    }

    public static function sendNotificationMessage($to, $message): MessageInstance
    {
        $twilio = self::getTwillioClient();

        return $twilio->messages
            ->create($to,
                array(
                    "from" => self::$fromPhone,
                    "body" => $message
                )
            );
    }

}

Twilio::init();
