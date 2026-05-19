<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventKill extends Model
{
    protected $table = 'hlstats_Events_Frags';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'eventTime', 'serverId', 'map', 'killerId', 'victimId',
        'weapon', 'headshot',
        'killerRole', 'victimRole', 'pos_x', 'pos_y', 'pos_z',
        'pos_victim_x', 'pos_victim_y', 'pos_victim_z',
    ];

    public function killer(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'killerId', 'playerId');
    }

    public function victim(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'victimId', 'playerId');
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class, 'serverId', 'serverId');
    }
}
