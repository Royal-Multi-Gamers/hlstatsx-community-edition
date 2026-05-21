<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowed = Cache::remember('available_locales', 86400, fn() =>
            collect(glob(lang_path('*.json')))
                ->map(fn($f) => pathinfo($f, PATHINFO_FILENAME))
                ->all()
        );

        if (session()->has('locale')) {
            // User made an explicit choice — honour it
            $locale = session('locale');
        } else {
            // Auto-detect from Accept-Language header
            $preferred = $request->getPreferredLanguage($allowed);
            $locale    = $preferred ?? config('app.locale', 'en');
        }

        if (!in_array($locale, $allowed)) {
            $locale = config('app.locale', 'en');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
