<?php

namespace App\Http\Controllers;

use App\Classes\CurrencyExchange;
use App\Classes\Notify;
use App\Models\Country;
use App\Models\PaymentIntent;
use App\Models\Post;
use App\Models\Receiver;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Omnipay\Omnipay;


class MonerisPaymentController extends Controller
{
//    public function payment(Request $request)
//    {
//        // Create a gateway instance
//        $gateway = Omnipay::create('Moneris');
//        $gateway->setMerchantId('monca07926');
//        $gateway->setMerchantKey('oVxLG8KP1gTFf66wkFXZ');
//        $gateway->setTestMode(true);
//
//        // Set the parameters for the purchase request
//        $parameters = [
//            'orderNumber' => '12sds345', // Replace '12345' with your actual order number or identifier
//            'amount' => '100.00',
//            'paymentMethod' => 'card', // Specify the payment method as 'card'
//            'card' => [
//                'number' => '4242424242424242',
//                'expiryMonth' => '12',
//                'expiryYear' => '23',
//                'cvv' => '123',
//                'cvd_info' => true, // Enable CVV/CVD information
//            ],
//        ];
//
//        // Try sending the purchase request
//        try {
//            $response = $gateway->purchase($parameters)->send();
//
//            // Check the response
//            if ($response->isSuccessful()) {
//                dd($response);
//                // Payment successful
//                $transactionId = $response->getTransactionReference();
//                dd('success', $transactionId);
//            } else {
//                // Payment failed
//                $errorMessage = $response->getMessage();
//                dd('error', $errorMessage);
//            }
//        } catch (\Exception $e) {
//            // Handle any exceptions or errors
//            dd('exception', $e->getMessage());
//        }
//    }





    /*moneris payment*/
    public function payment(Request $request)
    {
        /*Validate the request input*/
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'card_number' => 'required|string|numeric|digits_between:12,19',
            // 'expiry_month' => 'required|string|digits:2|numeric|min:1|max:12',
            'expiry_month' => 'required|string|numeric|min:1|max:12',
            // 'expiry_year' => 'required|string|digits:2|numeric',
            'expiry_year' => 'required|string|digits:4|numeric',
            'cvv' => 'required|string|numeric|digits_between:3,4',
        ]);

        try {
            /*Create a gateway instance using dependency injection*/
            $gateway = Omnipay::create('Moneris');
            $gateway->setMerchantId(config('services.moneris.merchant_id') ?? 'monca07926');
            $gateway->setMerchantKey(config('services.moneris.merchant_key') ?? 'oVxLG8KP1gTFf66wkFXZ');
            $gateway->setTestMode(config('services.moneris.test_mode') ?? true);

            /*Set the parameters for the purchase request*/
            $parameters = [
                'orderNumber' => 'ORD'.time() . rand(1000, 9999),
                'amount' => $validatedData['amount'],
                'paymentMethod' => 'card', // Specify the payment method as 'card'
                'card' => [
                    'number' => $validatedData['card_number'],
                    'expiryMonth' => $validatedData['expiry_month'],
                    'expiryYear' => $validatedData['expiry_year'],
                    'cvv' => $validatedData['cvv'],
                    'cvd_info' => true, // Enable CVV/CVD information
                ],
            ];

            /*Send the purchase request*/
            // dd($parameters);
            Log::info('Request: ' . print_r($parameters, true));
            $response = $gateway->purchase($parameters)->send();
            Log::info('Response: ' . $response->getData());
            /*Check the response - success or fail*/
            if ($response->isSuccessful()) {
                $transactionId = $response->getTransactionReference();
                $sessionData = User::getUserFromSession();
                DB::beginTransaction();

                // Create or update user
                $user = User::updateOrCreate(
                    ['email' => $sessionData['email']],
                    [
                        'first_name' => $sessionData['first_name'],
                        'last_name' => $sessionData['last_name'],
                        'country' => $sessionData['country'],
                        'password' => Hash::make('password'),
                    ]
                );

                // Generate random stripe payment intent ID
                $stripePaymentIntentId = rand(100000, 999999);

                $receiverCountry = Country::where('code', $sessionData['receiver_country'])
                    ->orWhere('code_iso_2', $sessionData['receiver_country'])
                    ->first();

                $requiredCurrency = $receiverCountry->currency->code;

                if (!$requiredCurrency) {
                    throw new \Exception('No currency found with the given code.');
                }
                $baseCurrency = $sessionData['currency'];
                $amount_in_receiver_currency[] = CurrencyExchange::convertCurrencies($baseCurrency, $requiredCurrency);
                $currencyValue = $amount_in_receiver_currency[0][$requiredCurrency]['value'] * $sessionData['amount'];
                // Store Payment Intent Data
                $paymentIntentData = [
                    'user_id' => $user->id,
                    'stripe_payment_intent_id' => $stripePaymentIntentId,
                    'amount' => $sessionData['amount'] * 100,
                    'amount_in_receiver_currency' => $currencyValue * 100 ?? 1,
                    'currency' => $sessionData['currency'],
                    'status' => Post::AVAILABLE,
                ];

                // Create Payment Intent and associate with user
                $paymentIntent = $user->paymentIntents()->create($paymentIntentData);

                $receiverId = Receiver::where('email', $sessionData['receiver_email'])
                                        ->where('phone', $sessionData['receiver_phone'])
                                        ->first()->id;

                // Store Transaction Data
                $transactionData = [
                    'receiver_id' => $receiverId ?? 1,
                    'payment_intent_id' => $paymentIntent->id,
                    'type' => 'direct',
                    'status' => Transaction::PAIRING_PENDING,
                    'payment_status' => Transaction::PAYMENT_ON_HOLD,
                ];

                // Create Transaction and associate with user
                $transaction = $user->transactions()->create($transactionData);

                // Store Post data
                $postData = [
                    'transaction_id' => $transaction->id,
                    'country_code' => $sessionData['country'],
                    'status' => Post::AVAILABLE,
                ];

                // Create Post
                $post = Post::create($postData);

                $data = [
                    'payment_intent_id' => $paymentIntent->id,
                    'country' => $sessionData['country'],
//                    'transactionId' => $transactionId,
                    'transactionId' => $transaction->id,
                ];

                /*Send Email*/
                Notify::transactionUpdated($user, $transaction, "Hi {$transaction->user->first_name}, Your transaction has been initialized.");

                DB::commit();

                return response()->json(['status' => 'success', 'data' => $data]);
            } else {
                /*Payment failed*/
                $errorMessage = $response->getMessage();
                Log::error('Payment failed. Error Message: ' . $errorMessage);
                return response()->json(['status' => 'error', 'message' => $errorMessage], 422);
            }
        } catch (\Exception $e) {
            Log::error('Payment exception: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Payment exception: ' . $e->getMessage()], 500);
        }
    }

}
