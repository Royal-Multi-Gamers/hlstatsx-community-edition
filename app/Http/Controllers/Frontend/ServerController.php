<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Services\StatsService;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function __construct(private StatsService $stats) {}

    public function index(Request $request)
    {
        $game    = $request->query('game', '');
        $servers = Server::visible()
            ->when($game, fn($q) => $q->forGame($game))
            ->with('game')
            ->get();

        return view('frontend.servers.index', compact('servers', 'game'));
    }

    public function show(int $id)
    {
        $server        = Server::with('game')->findOrFail($id);
        $onlinePlayers = $this->stats->getServerPlayers($id);
        $chart         = $this->stats->getActivityChart($id);
        $chartLabels   = $chart['labels'] ?? [];
        $chartData     = $chart['kills']  ?? [];

        return view('frontend.servers.show', compact('server', 'onlinePlayers', 'chartLabels', 'chartData'));
    }

    public function status(int $id)
    {
        $server = Server::findOrFail($id);
        return response()->json([
            'online'      => $server->last_event >= now()->subMinutes(5)->timestamp,
            'act_players' => $server->act_players,
            'max_players' => $server->max_players,
            'act_map'     => $server->act_map,
        ]);
    }
}
