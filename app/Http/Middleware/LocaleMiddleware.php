<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            \Illuminate\Support\Facades\Log::info('LocaleMiddleware: Setting locale to ' . $locale);
            App::setLocale($locale);
        } else {
            \Illuminate\Support\Facades\Log::info('LocaleMiddleware: No locale in session');
        }

        return $next($request);
    }
}
