<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerWeapon extends Model
{
    protected $table = 'hlstats_PlayerWeapons';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['playerId', 'game', 'weaponId', 'kills', 'headshots', 'shots', 'hits', 'teamkills', 'deaths'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'playerId', 'playerId');
    }

    public function weapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class, 'weaponId', 'weaponId');
    }
}
