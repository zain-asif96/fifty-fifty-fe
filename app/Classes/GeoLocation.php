<?php

namespace App\Classes;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class GeoLocation
{

    /**
     * PHPDoc
     *
     * @return array|null [ip, country_code, country_name,...]
     *
     */
    public static function getCurrentUserLocationDetails(): ?array
    {
        $sessionKey = request()->ip() . '_geo_location_details';
        // dd(session()->has($sessionKey));
        if (session()->has($sessionKey)) {
            return session()->get($sessionKey);
        }
        $response = Http::get(config('services.geo_location.endpoint'), [
            'key' => config('services.geo_location.api_key'),
            'ip' => request()->ip() === '127.0.0.1' ? '103.11.3.255' : request()->ip()
            // MX: '132.247.0.0 // CA: 45.44.122.61 // SW: 105.17.176.0 // NG: 129.18.255.255 //PAK: 103.11.3.255
        ]);
        if ($response->successful()) {
            $responseArray = $response->json();

            if (!isset($responseArray['country_code'])) {
                return self::sampleResponse();
            }

            if (app()->environment() !== 'testing') {
                $userCountry = Country::getCountryByCode($responseArray['country_code']);
                $responseArray['country'] = $userCountry;
            }

            $responseArray['userCanSend'] = Country::where('code_iso_2', $responseArray['country_code'])->first()->can_send === 'Y';

            session()->put($sessionKey, $responseArray);
            return $responseArray;
        }

        return null;
    }

    protected static function sampleResponse(): array
    {
        return [
            "ip" => "8.8.8.8",
            "country_code" => "US",
            "country_name" => "United States of America",
            "region_name" => "California",
            "city_name" => "Mountain View",
            "latitude" => 37.405992,
            "longitude" => -122.078515,
            "zip_code" => "94043",
            "time_zone" => "-07:00",
            "asn" => "15169",
            "as" => "Google LLC",
            "is_proxy" => false
        ];
    }

}
