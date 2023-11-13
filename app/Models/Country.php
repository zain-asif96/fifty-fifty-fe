<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['currency'];

    public static function isSupportingSending($countryCode): bool
    {
        $country = Country::where('code', $countryCode)
            ->orWhere('code_iso_2', $countryCode)
            ->first();

        if (!$country) return false;

        return $country->can_send === 'Y';
    }

    public static function receivingCountries()
    {
        return Country::select('id', 'label', 'code', 'code_iso_2', 'currency_id')->where('can_receive', 'Y')->get();
    }

    public static function supportedCountries()
    {
        return Country::select('id', 'label', 'code', 'code_iso_2', 'currency_id', 'can_send', 'can_receive')
            ->where('can_receive', 'Y')
            ->orWhere('can_send', 'Y')
            ->get();
    }

    public static function getCountryByCode($countryCode): Country|null
    {
        return Country::where('code', $countryCode)
            ->orWhere('code_iso_2', $countryCode)
            ->first();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function banks(): HasMany
    {
        return $this->hasMany(Bank::class);
    }
}
