<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    protected $table = 'hlstats_Teams';
    protected $primaryKey = 'teamId';
    public $timestamps = false;

    protected $fillable = ['game', 'code', 'name', 'hidden', 'playerlist_bgcolor', 'playerlist_color', 'playerlist_index'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game', 'code');
    }
}
