<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ban extends Model
{
    protected $table = 'hlstats_Bans';
    protected $primaryKey = 'banId';
    public $timestamps = false;

    protected $fillable = [
        'playerId', 'created', 'expires', 'type', 'adminId', 'reason', 'playerIp',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'playerId', 'playerId');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'adminId', 'adminId');
    }

    public function isActive(): bool
    {
        return is_null($this->expires) || $this->expires > now()->toDateTimeString();
    }

    public function isPermanent(): bool
    {
        return is_null($this->expires);
    }
}
