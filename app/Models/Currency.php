<?php

namespace App\Models;

use App\Classes\CurrencyExchange;
use App\Classes\GeoLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;

class Currency extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static array $majorCurrencies = [
        'USD',
        'EUR',
        'GBP',
        'CAD'
    ];

    const WORLD_BANK_RATE_SOURCE = 'world_bank';
    const SPECIAL_RATE_SOURCE = 'special';

    public static function updateRates($newRates){
        collect($newRates['data'])->each( function ($currency){
            self::where('code', $currency['code'])
                ->update(['rate' => $currency['value']]);
        });

        Setting::ratesUpdated();
    }

    public static function PopularRates($baseCurrency = ""): array
    {
        if(!$baseCurrency){
            $geoDetails = GeoLocation::getCurrentUserLocationDetails();
            $baseCurrency = $geoDetails['country']['currency']['code'];
        }

        $rates = [];

        collect(self::$majorCurrencies)->each( function ($code, $index) use(&$rates, $baseCurrency) {
            $rates[$index] = CurrencyExchange::localConvert($baseCurrency, $code)[$code];
            $rates[$index]['code_iso_2'] = Currency::where('code', $code)->first()->country->code_iso_2;
        });

        return $rates;
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'currency_id');
    }

}
