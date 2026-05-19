<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Server;
use App\Services\StatsService;
use App\Services\ThemeService;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(
        private StatsService $stats,
        private ThemeService $theme,
    ) {}

    public function index()
    {
        $globalStats = $this->stats->getGlobalStats();

        $games = Game::visible()
            ->with(['servers' => fn($q) => $q->visible()])
            ->get()
            ->map(function ($game) {
                $topPlayer = DB::table('hlstats_Players')
                    ->where('game', $game->code)
                    ->where('hideranking', 0)
                    ->orderByDesc('skill')
                    ->first(['playerId', 'lastName', 'country', 'flag']);

                $topClan = DB::table('hlstats_Clans as c')
                    ->join('hlstats_Players as p', function ($join) use ($game) {
                        $join->on('p.clan', '=', 'c.clanId')
                             ->where('p.game', '=', $game->code)
                             ->where('p.hideranking', '=', 0);
                    })
                    ->where('c.game', $game->code)
                    ->where('c.hidden', 0)
                    ->groupBy('c.clanId', 'c.name', 'c.tag')
                    ->orderByDesc(DB::raw('SUM(p.kills)'))
                    ->first(['c.clanId', 'c.name', 'c.tag']);

                $connectedPlayers = $game->servers->sum('act_players');
                $maxPlayers       = $game->servers->sum('max_players');

                return [
                    'game'             => $game,
                    'topPlayer'        => $topPlayer,
                    'topClan'          => $topClan,
                    'connectedPlayers' => $connectedPlayers,
                    'maxPlayers'       => $maxPlayers,
                ];
            });

        $serverMarkers = Server::visible()
            ->whereNotNull('lat')->where('lat', '!=', 0)
            ->whereNotNull('lng')->where('lng', '!=', 0)
            ->get(['serverId', 'name', 'address', 'port', 'publicaddress', 'lat', 'lng', 'last_event'])
            ->map(fn($s) => [
                'lat'     => (float)$s->lat,
                'lng'     => (float)$s->lng,
                'name'    => $s->name,
                'address' => $s->full_address,
                'online'  => $s->last_event >= now()->subMinutes(5)->timestamp,
            ])
            ->toArray();

        $playerMarkers = DB::table('hlstats_Players')
            ->where('hideranking', 0)
            ->whereNotNull('lat')->where('lat', '!=', 0)
            ->whereNotNull('lng')->where('lng', '!=', 0)
            ->orderByDesc('skill')
            ->limit(500)
            ->get(['lat', 'lng', 'lastName', 'country', 'game'])
            ->map(fn($p) => [
                'lat'     => (float)$p->lat,
                'lng'     => (float)$p->lng,
                'name'    => $p->lastName,
                'country' => $p->country,
            ])
            ->toArray();

        $activeTheme = $this->theme->getActive();
        $tileUrl     = $activeTheme['charts']['map-tiles'] ?? 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

        return view('frontend.home', compact('globalStats', 'games', 'serverMarkers', 'playerMarkers', 'tileUrl'));
    }
}
