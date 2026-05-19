<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Services\ServerStatusService;
use Illuminate\Console\Command;

class CheckServersCommand extends Command
{
    protected $signature   = 'hlstats:check-servers';
    protected $description = 'Ping all visible servers and update their online status';

    public function __construct(private ServerStatusService $service)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $servers = Server::visible()->get();
        $online  = 0;

        foreach ($servers as $server) {
            $status = $this->service->ping($server->address, $server->port);
            if ($status) {
                $online++;
            }
            $this->line(sprintf(
                '%s:%d — %s',
                $server->address,
                $server->port,
                $status ? '<info>online</info>' : '<comment>offline</comment>'
            ));
        }

        $this->info("Done. {$online}/{$servers->count()} servers online.");
        return self::SUCCESS;
    }
}
