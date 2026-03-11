<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Set the locale from session if it exists
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
        }

        // Allow locale switching via query parameter (?locale=ar)
        if ($request->has('locale')) {
            $locale = $request->query('locale');
            session(['locale' => $locale]);
            App::setLocale($locale);
        }

        return $next($request);
    }
}
