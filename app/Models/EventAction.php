<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAction extends Model
{
    protected $table = 'hlstats_Events_Actions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['eventTime', 'serverId', 'playerId', 'map', 'actionId', 'bonus', 'player2Id', 'team'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'playerId', 'playerId');
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class, 'serverId', 'serverId');
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class, 'actionId', 'id');
    }
}
