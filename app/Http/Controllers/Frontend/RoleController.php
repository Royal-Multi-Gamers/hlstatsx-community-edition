<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $game     = $request->query('game', '');
        $realgame = $game
            ? (DB::table('hlstats_Games')->where('code', $game)->value('realgame') ?? $game)
            : $game;

        $roles = DB::table('hlstats_Roles')
            ->when($game, fn($q) => $q->where('game', $game))
            ->orderBy('name')
            ->get();

        return view('frontend.roles.index', compact('roles', 'game', 'realgame'));
    }

    public function show(Request $request, string $code)
    {
        $game     = $request->query('game', '');
        $realgame = $game
            ? (DB::table('hlstats_Games')->where('code', $game)->value('realgame') ?? $game)
            : $game;

        $role = DB::table('hlstats_Roles')
            ->where('code', $code)
            ->when($game, fn($q) => $q->where('game', $game))
            ->first();
        abort_if(!$role, 404);

        // Players who have played this role the most (via Events_PlayerRoles if exists, otherwise show stats)
        $players = DB::table('hlstats_Players as p')
            ->where('p.game', $game ?: $role->game)
            ->where('p.hideranking', 0)
            ->orderByDesc('p.skill')
            ->limit(50)
            ->get(['p.playerId', 'p.lastName', 'p.flag', 'p.kills', 'p.skill']);

        return view('frontend.roles.show', compact('role', 'players', 'game', 'realgame'));
    }
}
