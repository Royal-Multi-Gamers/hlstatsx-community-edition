<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $table = 'hlstats_Players';
    protected $primaryKey = 'playerId';
    public $timestamps = false;

    protected $fillable = [
        'lastName', 'uniqueId', 'clan', 'kills', 'deaths', 'suicides',
        'skill', 'shots', 'hits', 'headshots', 'connection_time',
        'game', 'hideranking', 'country', 'city', 'flag', 'lat', 'lng',
        'createDate', 'activity', 'fullName',
    ];

    // Disable Eloquent's snake_case conversion
    public function getKeyName(): string
    {
        return 'playerId';
    }

    // Scopes
    public function scopeForGame(Builder $query, string $gameCode): Builder
    {
        return $query->where('game', $gameCode);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('activity', '>=', date('Y-m-d H:i:s', strtotime('-28 days')));
    }

    public function scopeRanked(Builder $query): Builder
    {
        return $query->where('skill', '>', 0)
                     ->where('hideranking', 0);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('hideranking', 0);
    }

    // Relations
    public function clanRelation(): BelongsTo
    {
        return $this->belongsTo(Clan::class, 'clan', 'clanId');
    }

    public function uniqueIds(): HasMany
    {
        return $this->hasMany(PlayerUniqueId::class, 'playerId', 'playerId');
    }

    public function killsAsKiller(): HasMany
    {
        return $this->hasMany(EventKill::class, 'killerId', 'playerId');
    }

    public function killsAsVictim(): HasMany
    {
        return $this->hasMany(EventKill::class, 'victimId', 'playerId');
    }

    public function playerWeapons(): HasMany
    {
        return $this->hasMany(PlayerWeapon::class, 'playerId', 'playerId');
    }

    public function playerMaps(): HasMany
    {
        return $this->hasMany(PlayerMap::class, 'playerId', 'playerId');
    }

    public function getKdRatioAttribute(): float
    {
        if ($this->deaths == 0) {
            return (float) $this->kills;
        }

        return round($this->kills / $this->deaths, 2);
    }

    public function getHsPercentAttribute(): float
    {
        if ($this->kills == 0) {
            return 0.0;
        }

        return round(($this->headshots / $this->kills) * 100, 2);
    }

    public function getAccuracyAttribute(): float
    {
        if ($this->shots == 0) {
            return 0.0;
        }

        return round(($this->hits / $this->shots) * 100, 1);
    }
}
