<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ban;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function index(Request $request)
    {
        $game = $request->query('game', '');

        $bans = Ban::with(['player'])
            ->when($game, fn($q) => $q->whereHas('player', fn($pq) => $pq->where('game', $game)))
            ->orderByDesc('created')
            ->paginate(50);

        return view('frontend.bans.index', compact('bans', 'game'));
    }
}
