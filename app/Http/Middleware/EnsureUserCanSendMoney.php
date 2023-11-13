<?php

namespace App\Http\Middleware;

use App\Classes\GeoLocation;
use App\Models\Country;
use Closure;
use Illuminate\Http\Request;

class EnsureUserCanSendMoney
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locationDetails = GeoLocation::getCurrentUserLocationDetails();

        if (!Country::isSupportingSending($locationDetails['country_code'])) {
            return redirect(route('available.posts.page'));
        }

        return $next($request);
    }
}
