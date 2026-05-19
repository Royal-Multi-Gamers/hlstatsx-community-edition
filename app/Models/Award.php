<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Award extends Model
{
    protected $table = 'hlstats_Awards';
    protected $primaryKey = 'awardId';
    public $timestamps = false;

    protected $fillable = ['awardType', 'game', 'code', 'name', 'verb', 'd_winner_id', 'winner_id', 'w_winner_count', 'd_winner_count'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game', 'code');
    }

    public function weeklyWinner(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'w_winner_id', 'playerId');
    }

    public function dailyWinner(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'd_winner_id', 'playerId');
    }

    public function globalWinner(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'g_winner_id', 'playerId');
    }
}
