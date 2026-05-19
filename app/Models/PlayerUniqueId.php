<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerUniqueId extends Model
{
    protected $table = 'hlstats_PlayerUniqueIds';
    protected $primaryKey = 'uniqueId';
    public $timestamps = false;

    protected $fillable = ['playerId', 'uniqueId', 'game', 'merge'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'playerId', 'playerId');
    }
}
