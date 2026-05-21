<?php
/*
 * HLStatsX Community Edition - Laravel Rebase
 * A modern Laravel 13 rewrite of the HLStatsX:CE web frontend, preserving the original MySQL schema.
 *
 * A long lineage of open-source stats for Half-Life & Source engine games:
 *   HLstats (Simon Garner, 2001) -> HLstatsX (Tobias Oetzel, 2005)
 *   -> HLstatsX:CE (Nicholas Hastings, 2008) -> This rebase (Royal-Multi-Gamers, 2026)
 *
 * Perl daemon sourced from SnipeZilla/HLSTATS-2.
 *
 * Copyright (C) 2025-2026 Royal-Multi-Gamers
 * Licensed under the GNU General Public License v2.0
 * https://www.gnu.org/licenses/gpl-2.0.html
 *
 * https://github.com/Royal-Multi-Gamers/hlstatsx-community-edition
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminToolsController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('name')->get();
        return view('admin.tools.index', compact('games'));
    }

    public function optimizeDb()
    {
        $tables = [
            'hlstats_Players', 'hlstats_Events_Frags', 'hlstats_Events_Chat',
            'hlstats_Events_Connects', 'hlstats_Events_Disconnects',
            'hlstats_Events_Suicides', 'hlstats_Events_TeamBonuses',
            'hlstats_Events_PlayerActions', 'hlstats_Events_PlayerPlayerActions',
            'hlstats_PlayerWeapons', 'hlstats_Awards', 'hlstats_Clans',
        ];
        foreach ($tables as $table) {
            DB::statement("OPTIMIZE TABLE `{$table}`");
        }
        return redirect()->route('admin.tools.index')->with('success', 'Database optimized (' . count($tables) . ' tables).');
    }

    public function resetGame(Request $request)
    {
        $data = $request->validate([
            'game'    => ['required', 'string', 'exists:hlstats_Games,code'],
            'confirm' => ['required', 'in:RESET'],
        ]);

        $game = $data['game'];

        // Reset player stats for this game
        DB::table('hlstats_Players')
            ->where('game', $game)
            ->update([
                'skill'          => 1000,
                'kills'          => 0,
                'deaths'         => 0,
                'suicides'       => 0,
                'headshots'      => 0,
                'shots'          => 0,
                'hits'           => 0,
                'teamkills'      => 0,
                'kill_streak'    => 0,
                'death_streak'   => 0,
                'connection_time'=> 0,
            ]);

        // Delete events for this game's servers
        $serverIds = DB::table('hlstats_Servers')
            ->where('game', $game)
            ->pluck('serverId');

        foreach (['hlstats_Events_Frags', 'hlstats_Events_Chat', 'hlstats_Events_Connects',
                  'hlstats_Events_Disconnects', 'hlstats_Events_Suicides',
                  'hlstats_Events_PlayerActions', 'hlstats_Events_PlayerPlayerActions',
                  'hlstats_Events_TeamBonuses'] as $table) {
            DB::table($table)->whereIn('serverId', $serverIds)->delete();
        }

        return redirect()->route('admin.tools.index')->with('success', "Stats for game [{$game}] have been reset.");
    }

    public function deletePlayers(Request $request)
    {
        $data = $request->validate([
            'game'    => ['required', 'string', 'exists:hlstats_Games,code'],
            'confirm' => ['required', 'in:DELETE'],
        ]);

        $deleted = DB::table('hlstats_Players')
            ->where('game', $data['game'])
            ->where('kills', 0)
            ->where('deaths', 0)
            ->delete();

        return redirect()->route('admin.tools.index')->with('success', "Deleted {$deleted} inactive players from game [{$data['game']}].");
    }
}
