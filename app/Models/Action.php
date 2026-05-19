<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model
{
    protected $table = 'hlstats_Actions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['game', 'code', 'reward_player', 'reward_team', 'team', 'description', 'forPlayerActions', 'forTeamplayActions', 'count'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game', 'code');
    }
}
