<?php

namespace App\Services;

use App\Models\Server;

class ServerStatusService
{
    /**
     * Ping a Source server via UDP query.
     */
    public function ping(string $ip, int $port): bool
    {
        try {
            $socket = @fsockopen("udp://{$ip}", $port, $errno, $errstr, 2);
            if (!$socket) {
                return false;
            }

            // A2S_INFO query packet
            $packet = "\xFF\xFF\xFF\xFF\x54Source Engine Query\x00";
            fwrite($socket, $packet);
            stream_set_timeout($socket, 2);
            $data = fread($socket, 4096);
            fclose($socket);

            return strlen($data) > 5;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get number of online players for a server.
     */
    public function getOnlinePlayers(int $serverId): int
    {
        $server = Server::find($serverId);
        if (!$server) {
            return 0;
        }

        return (int) $server->act_players;
    }

    /**
     * Update online status for all tracked servers.
     */
    public function updateAllStatuses(): void
    {
        Server::visible()->each(function (Server $server) {
            $online = $this->ping($server->address, (int) $server->port);
            $server->update(['last_event' => $online ? now()->timestamp : $server->last_event]);
        });
    }
}
