<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Countries\StoreCountryRequest;
use App\Http\Requests\Admin\Countries\UpdateCountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
    public function supportedCountries(){
        return Country::supportedCountries();
    }
}
