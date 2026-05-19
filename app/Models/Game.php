<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $table = 'hlstats_Games';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'code', 'name', 'realgame', 'hidden', 'website',
        'defaultSkill', 'killSkillBonus', 'deathSkillPenalty',
        'suicidePenalty', 'teamKillPenalty', 'minPlayers', 'headShotBonus',
    ];

    public function servers(): HasMany
    {
        return $this->hasMany(Server::class, 'game', 'code');
    }

    public function weapons(): HasMany
    {
        return $this->hasMany(Weapon::class, 'game', 'code');
    }

    public function maps(): HasMany
    {
        return $this->hasMany(GameMap::class, 'game', 'code');
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'game', 'code');
    }

    public function scopeVisible(Builder $query): Builder
    {
        // hidden is ENUM('0','1'); use string comparison
        return $query->where('hidden', '0');
    }
}
