<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rank extends Model
{
    protected $table = 'hlstats_Ranks';
    protected $primaryKey = 'rankId';
    public $timestamps = false;

    protected $fillable = ['image', 'minKills', 'maxKills', 'rankName', 'game'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game', 'code');
    }
}
