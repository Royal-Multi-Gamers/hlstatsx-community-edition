<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventConnect extends Model
{
    protected $table = 'hlstats_Events_Connects';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['eventTime', 'serverId', 'playerId', 'map', 'eventType', 'ipAddress'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'playerId', 'playerId');
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class, 'serverId', 'serverId');
    }
}
