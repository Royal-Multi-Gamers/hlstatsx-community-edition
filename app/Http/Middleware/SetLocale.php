<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            // User made an explicit choice — honour it
            $locale = session('locale');
        } else {
            // Auto-detect from Accept-Language header
            $preferred = $request->getPreferredLanguage(['en', 'fr']);
            $locale    = $preferred ?? config('app.locale', 'en');
        }

        if (!in_array($locale, ['en', 'fr'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
