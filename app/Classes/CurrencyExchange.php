<?php

namespace App\Classes;

use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class CurrencyExchange
{
    public static function convertCurrencies($base, $requiredCurrency): array|null
    {
        if(!Setting::hasNewRates()){
            $newRates =  self::getLatestRates();
            Currency::updateRates($newRates);
            return self::localConvert($base, $requiredCurrency);
        }

        return self::localConvert($base, $requiredCurrency);
    }

    public static function getCurrencyByCountryCode($countryCode): string
    {
        $countries = getCountriesWithCurrencies();

        return $countries[$countryCode];
    }

    public static function getLatestRates(){
        $response = Http::get(config('services.currency_exchange.endpoint'), [
            'apikey' => config('services.currency_exchange.api_key')
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public static function localConvert($base, $requiredCurrency): array
    {
        $baseCurrency = Currency::where('code', $base)->first();
        $reqCurrency = Currency::where('code', $requiredCurrency)->first();

        $baseValue = $baseCurrency->rate;
        $reqValue = $reqCurrency->rate_source === Currency::WORLD_BANK_RATE_SOURCE ? $reqCurrency->rate : $reqCurrency->special_rate;

        $value = $reqValue / $baseValue;

        return [ "$requiredCurrency" => [
            "code" => "$requiredCurrency",
            "value" => $value
        ]];
    }

    public static function apiConvert($base, $requiredCurrency){
         $response = Http::get(config('services.currency_exchange.endpoint'), [
            'apikey' => config('services.currency_exchange.api_key'),
            'base_currency' => strtoupper($base),
            'currencies' => strtoupper($requiredCurrency)
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }
}
