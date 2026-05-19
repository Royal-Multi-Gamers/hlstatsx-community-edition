<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerMap extends Model
{
    protected $table = 'hlstats_PlayerMaps';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['playerId', 'game', 'mapId', 'kills', 'deaths', 'headshots', 'rounds', 'playtime'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'playerId', 'playerId');
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(GameMap::class, 'mapId', 'mapId');
    }
}
