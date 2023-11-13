<?php

namespace App\Http\Controllers;

use App\Classes\CurrencyExchange;
use App\Models\Country;
use App\Models\Receiver;
use App\Http\Requests\StoreReceiverRequest;
use App\Models\PaymentIntent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class ReceiverController extends Controller
{


    public function receiverInfoPage(): Response|FoundationResponse
    {
        $user = auth()->user();

        $paymentIntent = $this->getLocalPaymentIntent();

        if (!$paymentIntent || !(request('country') && request('country') !== 'null')) {
            abort(404);
        }

        $latestReceivers = $user->receivers()->latest()->get();

        if ($user->handlingTransaction()) {
            $user->handled_transaction = $user->getHandledTransaction();
        }

        $receiverCountry = Country::getCountryByCode(request('country'));

        return Inertia::render('Transaction/ReceiverInformation',
            [
                'user' => $user,
                'latestReceivers' => $latestReceivers,
                'banks' => $receiverCountry->banks
            ]
        );
    }

    protected function getLocalPaymentIntent()
    {
        $user = auth()->user();

        return $user->paymentIntents()
            ->where('stripe_payment_intent_id', request('payment-reference-identification'))
            ->orWhere('id', request('payment-reference-identification'))
            ->first();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReceiverRequest $request
     * @param User $user
     * @return Model
     */
    public function store(StoreReceiverRequest $request, User $user): Model
    {
        $receiver = $user->receivers()->create($request->toArray());

        $paymentIntent = PaymentIntent::where('stripe_payment_intent_id', request('paymentIntentId'))
            ->orWhere('id', request('paymentIntentId'))
            ->first();

        $this->addReceiverToPaymentIntent($receiver, $paymentIntent);

        $receiver['payment-reference-identification'] = $paymentIntent->stripe_payment_intent_id ?? $paymentIntent->id;

        return $receiver;
    }

    protected function addReceiverToPaymentIntent($receiver, $paymentIntent)
    {
        $receiverCurrency = CurrencyExchange::getCurrencyByCountryCode($receiver->country);

        $convertData = CurrencyExchange::convertCurrencies($paymentIntent->currency, $receiverCurrency);

        if ($convertData !== null) {
            $amountInReceiverCurrency = $convertData[$receiverCurrency]['value'] * $paymentIntent->amount;
        }

        $paymentIntent->update(
            [
                'receiver_id' => $receiver->id,
                'amount_in_receiver_currency' => $amountInReceiverCurrency ?? 0
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreReceiverRequest $request
     * @param Receiver $receiver
     * @return bool
     */
    public function update(StoreReceiverRequest $request, Receiver $receiver): array
    {
        if ($receiver->update($request->toArray())) {
            $this->addReceiverToPaymentIntent($receiver);

            return [
                'status' => 'success'
            ];
        }

        return [
            'status' => 'error'
        ];
    }


    public function getInternationalBanks(Request $request): array
    {
        $receiverCountry = Country::getCountryByCode(request('country'));

        return [
            'status' => 'success',
            'banks' => $receiverCountry->banks
        ];

    }
}
