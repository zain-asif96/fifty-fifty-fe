<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Country;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class BankController extends Controller
{
    public function getListOfBanksByCountry(Request $request, Country $country = null): array
    {
        return [
            'banks' => $country->banks()->whereNotNull('country_id')->get()
        ];
    }

    public function index(Request $request){
        if($request->has('country')){
            $countryCode = $request->get('country');

            $country = Country::getCountryByCode($countryCode);

            return $country->banks()->whereNotNull('country_id')->get();
        }

        return  Bank::whereNotNull('country_id')->get();
    }
}
