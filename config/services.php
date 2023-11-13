<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'twilio' => [
        'sid' => env('TWILIO_ACCOUNT_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        'service_id' => env('TWILIO_SERVICE_ID'),
        'SMSService_id' => env('TWILIO_SMS_SERVICE_SID'),
        'from_phone' => env('TWILIO_FROM'),
    ],

    'stripe' => [
        'secret_key' => env('STRIPE_SECRET_KEY'),
        'public_key' => env('STRIPE_PUBLIC_KEY'),
        'redirect_url' => env('STRIPE_REDIRECT_URL'),
    ],

    'geo_location' => [
        'api_key' => env('IP_GEO_LOCATION_API_KEY'),
        'endpoint' => env('IP_GEO_LOCATION_API_ENDPOINT'),
    ],

    'currency_exchange' => [
        'api_key' => env('CURRENCY_EXCHANGE_API_KEY'),
        'endpoint' => env('CURRENCY_EXCHANGE_API_ENDPOINT'),
    ],

    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN'),
        'chat_id' => env('TELEGRAM_CHAT_ID'),
    ],

    'moneris' => [
        'merchant_id' => env('MONERIS_MERCHANT_ID') ?? 'monca07926',
        'merchant_key' => env('MONERIS_MERCHANT_KEY') ?? 'oVxLG8KP1gTFf66wkFXZ',
        'test_mode' => env('MONERIS_TEST_MODE', true),
    ],
];
