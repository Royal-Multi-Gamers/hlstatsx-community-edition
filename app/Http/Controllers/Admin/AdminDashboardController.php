<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Clan;
use App\Models\Game;
use App\Models\Player;
use App\Models\Server;
use App\Services\StatsService;

class AdminDashboardController extends Controller
{
    public function __construct(private StatsService $stats) {}

    public function index()
    {
        $stats = [
            'players' => Player::count(),
            'clans'   => Clan::count(),
            'servers' => Server::count(),
            'games'   => Game::count(),
            'bans'    => Ban::where(function ($q) {
                $q->whereNull('expires')->orWhere('expires', '>', now());
            })->count(),
        ];

        $globalStats = $this->stats->getGlobalStats();

        return view('admin.dashboard', compact('stats', 'globalStats'));
    }
}
