<?php

namespace App\Http\Controllers;

use App\Classes\GeoLocation;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Constraint\Count;

class DashboardController extends Controller
{
    public function welcome(): Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'receivingCountries' => Country::receivingCountries(),
            'supportedCountries' => Country::supportedCountries(),
            'posts' => Post::getAvailablePosts(3, true),
            'rates' => Currency::PopularRates()
        ]);
    }

    public function services(): Response
    {
        return Inertia::render('Services/Index', [
            'supportedCountries' => Country::supportedCountries()
        ]);
    }

    public function dashboard(): RedirectResponse|Response
    {
        if (auth()->user()->auth_method === User::AUTO_AUTH_METHOD) {
            Auth::logout();
            return redirect(route('login'));
        }

        return Inertia::render('Dashboard');
    }
}
