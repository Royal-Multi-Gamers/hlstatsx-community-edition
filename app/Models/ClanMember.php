<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClanMember extends Model
{
    protected $table = 'hlstats_ClanMembers';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['clanId', 'playerId'];

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class, 'clanId', 'clanId');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'playerId', 'playerId');
    }
}
