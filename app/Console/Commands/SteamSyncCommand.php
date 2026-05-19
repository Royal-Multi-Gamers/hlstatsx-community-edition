<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Services\SteamService;
use Illuminate\Console\Command;

class SteamSyncCommand extends Command
{
    protected $signature   = 'hlstats:steam-sync {--limit=500 : Max players to sync}';
    protected $description = 'Sync Steam avatars and display names for players';

    public function __construct(private SteamService $steam)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $limit   = (int)$this->option('limit');
        $players = Player::whereNotNull('steamId')
            ->where('steamId', '!=', '')
            ->orderByDesc('skill')
            ->limit($limit)
            ->get();

        $bar = $this->output->createProgressBar($players->count());
        $bar->start();

        foreach ($players as $player) {
            try {
                $steam64 = $this->steam->steamId32to64($player->steamId);
                $this->steam->getAvatar($steam64);
                $this->steam->getDisplayName($steam64);
            } catch (\Exception) {
                // Skip players with invalid Steam IDs
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced {$players->count()} players.");

        return self::SUCCESS;
    }
}
