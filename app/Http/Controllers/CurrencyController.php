<?php

namespace App\Http\Controllers;

use App\Classes\CurrencyExchange;
use App\Models\Currency;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function convertCurrency(Request $request): ?array
    {
        $baseCurrency = $request->baseCurrency;
        $requiredCurrency = $request->requiredCurrency;

        return CurrencyExchange::convertCurrencies($baseCurrency, $requiredCurrency);
    }

    public function popular(Request $request){
        $main = Setting::first()->main ? Setting::first()->main : ['fetched_at' => Carbon::now()];

        return [
            'last_updated_at_human' => Carbon::create($main['fetched_at'])->diffForHumans(),
            'last_updated_at' => Carbon::create($main['fetched_at']),
            'currencies' => Currency::PopularRates($request->has('base_currency') ? $request->base_currency : null)
        ];
    }
}
