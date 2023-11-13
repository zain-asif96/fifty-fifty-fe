<?php

namespace App\Interfaces;

interface PhoneVerification
{
    public static function sendVerificationCode($phoneNumber): string;

    public static function checkVerificationCode($phoneNumber, $code): bool;
}
