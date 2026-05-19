<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Server;
use App\Services\GeoIPService;
use App\Services\StatsService;
use Carbon\Carbon;

class GameController extends Controller
{
    public function __construct(
        private StatsService $stats,
        private GeoIPService $geoip,
    ) {}

    public function show(string $code)
    {
        $game = Game::findOrFail($code);

        $servers = Server::visible()
            ->forGame($code)
            ->get()
            ->map(function ($server) {
                $coords = $this->geoip->getCoordinates($server->address);
                return [
                    'server'    => $server,
                    'lat'       => $coords['lat'] ?? null,
                    'lng'       => $coords['lng'] ?? null,
                    'chart'     => $this->stats->getActivityChart($server->serverId),
                    'players'   => $this->stats->getServerPlayers($server->serverId),
                ];
            });

        $mapMarkers = $servers
            ->filter(fn($s) => $s['lat'] !== null && $s['lng'] !== null)
            ->map(fn($s) => [
                'lat'     => $s['lat'],
                'lng'     => $s['lng'],
                'name'    => $s['server']->name,
                'address' => $s['server']->full_address,
                'online'  => $s['server']->last_event >= now()->subMinutes(5)->timestamp,
            ])
            ->values();

        $playerMarkers = $servers
            ->flatMap(fn($s) => $s['players'])
            ->filter(fn($p) => !empty($p->lat) && !empty($p->lng) && (float)$p->lat !== 0.0 && (float)$p->lng !== 0.0)
            ->map(fn($p) => [
                'lat'     => (float)$p->lat,
                'lng'     => (float)$p->lng,
                'name'    => $p->lastName,
                'country' => $p->country ?? null,
            ])
            ->values();

        $dailyAwards = $this->stats->getDailyAwards($code, Carbon::today());

        $totalPlayers = Server::forGame($code)->sum('act_players');
        $totalKills   = \App\Models\Player::forGame($code)->sum('kills');

        $theme = app(\App\Services\ThemeService::class)->getActive();
        $tileUrl = $theme['charts']['map-tiles'] ?? 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

        return view('frontend.game.show', compact(
            'game', 'servers', 'mapMarkers', 'playerMarkers', 'dailyAwards',
            'totalPlayers', 'totalKills', 'tileUrl'
        ));
    }
}
