<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        $allowed = collect(glob(lang_path('*.json')))
            ->map(fn($f) => pathinfo($f, PATHINFO_FILENAME))
            ->values()
            ->all();

        if (in_array($locale, $allowed)) {
            session(['locale' => $locale]);
        }

        return back();
    }
}
