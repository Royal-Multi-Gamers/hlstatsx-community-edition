<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weapon extends Model
{
    protected $table = 'hlstats_Weapons';
    protected $primaryKey = 'weaponId';
    public $timestamps = false;

    protected $fillable = ['code', 'game', 'name', 'modifier', 'kills', 'headshots', 'shots', 'hits', 'teamkills'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game', 'code');
    }
}
