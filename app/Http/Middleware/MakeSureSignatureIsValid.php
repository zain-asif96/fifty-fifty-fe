<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MakeSureSignatureIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($this->checkSignatureHeader($request)){
            return $next($request);
        }

        abort(403, "Unauthorized");
    }

    private function checkSignatureHeader($request): bool
    {
        // check request header:
        return $request->header('signature') &&
            !empty($request->header('signature')) &&
            $request->header('signature') === env('SECRET_APP_SIGNATURE');
    }
}
