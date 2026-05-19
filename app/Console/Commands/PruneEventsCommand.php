<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneEventsCommand extends Command
{
    protected $signature   = 'hlstats:prune-events {--days=90 : Delete events older than this many days}';
    protected $description = 'Delete old events to keep the database size manageable';

    public function handle(): int
    {
        $days      = (int)$this->option('days');
        $threshold = now()->subDays($days)->toDateTimeString();

        $tables = [
            'hlstats_Events_Frags',
            'hlstats_Events_Connects',
            'hlstats_Events_Chat',
            'hlstats_Events_PlayerActions',
        ];

        foreach ($tables as $table) {
            $deleted = DB::table($table)->where('eventTime', '<', $threshold)->delete();
            $this->line("Pruned <info>{$deleted}</info> rows from {$table}");
        }

        $this->info("Event pruning complete (threshold: {$threshold}).");
        return self::SUCCESS;
    }
}
