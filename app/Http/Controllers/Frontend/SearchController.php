<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query   = $request->query('q');
        $game    = $request->query('game');
        $results = collect();

        if ($query) {
            $results = Player::ranked()
                ->where('lastName', 'like', '%' . $query . '%')
                ->when($game, fn($q) => $q->where('game', $game))
                ->orderByDesc('skill')
                ->limit(50)
                ->get();
        }

        return view('frontend.search', compact('results', 'query', 'game'));
    }
}
