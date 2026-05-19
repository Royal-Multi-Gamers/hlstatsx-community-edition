<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clan extends Model
{
    protected $table = 'hlstats_Clans';
    protected $primaryKey = 'clanId';
    public $timestamps = false;

    protected $fillable = ['tag', 'name', 'homepage', 'game', 'hidden'];

    // Players whose clan FK points to this clan
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'clan', 'clanId');
    }

    public function scopeForGame(Builder $query, string $gameCode): Builder
    {
        return $query->where('game', $gameCode);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('hidden', 0);
    }
}
