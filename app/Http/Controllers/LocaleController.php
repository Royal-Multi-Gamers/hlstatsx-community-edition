<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        $allowed = ['en', 'fr'];

        if (in_array($locale, $allowed)) {
            session(['locale' => $locale]);
        }

        return back();
    }
}
