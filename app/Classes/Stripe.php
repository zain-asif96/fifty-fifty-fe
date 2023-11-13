<?php

namespace App\Classes;

use App\Interfaces\PaymentGateway;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\StripeClient;

class Stripe implements PaymentGateway
{
    /**
     * @throws ApiErrorException
     */
    public static function createPaymentIntent($paymentInfo, $automaticAllowed = true): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        return $stripe->paymentIntents->create(
            [
                'amount' => $paymentInfo->amount * 100,
                'currency' => $paymentInfo->currency,
                'automatic_payment_methods' => ['enabled' => $automaticAllowed],
                'capture_method' => 'manual'
            ]
        );

    }

    /**
     * @throws ApiErrorException
     */
    public static function retrievePaymentIntent($paymentIntentId): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        return $stripe->paymentIntents->retrieve($paymentIntentId);
    }


    /**
     * @throws ApiErrorException
     */
    public static function collectFeesAndReleaseHold($paymentIntentId): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        return $stripe->paymentIntents->capture($paymentIntentId, [
            'amount_to_capture' => 100 // One Dollar, add to env better approach.
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public static function createPaymentMethod(array $cardDetails): PaymentMethod
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        return $stripe->paymentMethods->create([
            "type" => "card",
            "card" => [
                "number" => $cardDetails["card_number"],
                "exp_month" => $cardDetails["card_exp_month"],
                "exp_year" => $cardDetails["card_exp_year"],
                "cvc" => $cardDetails["card_cvc"],
            ]
        ]);
    }

    public static function confirmPayment($paymentMethodId, $params): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        return $stripe->paymentIntents->confirm($paymentMethodId, $params);
    }
}
