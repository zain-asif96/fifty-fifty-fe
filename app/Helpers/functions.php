<?php

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

function stepNotCompletedResponse($message, $url): FoundationResponse
{
    request()->session()->flash('message', [
        'content' => $message,
        'type' => 'error'
    ]);

    return Inertia::location($url);
}

function getCountriesWithCurrencies(): array
{
    return include('CurrenciesCountries.php');
}

function getCountriesCodes(): array
{
    return include('CountryCodes.php');
}

function getIso3CodeByIso2($iso2Code): string
{
    $countries = getCountriesCodes();
    return $countries[$iso2Code];
}


function getIso2CodeByIso3($iso3Code): string
{
    $countries = getCountriesCodes();
    return $countries[$iso3Code];
}


function getCurrencyByCountryCode($countryCode): string
{
    $countriesWithCurrencies = getCountriesWithCurrencies();

    return $countriesWithCurrencies[$countryCode];
}
