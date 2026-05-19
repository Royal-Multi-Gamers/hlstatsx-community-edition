<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ribbon extends Model
{
    protected $table = 'hlstats_Ribbons';
    protected $primaryKey = 'ribbonId';
    public $timestamps = false;

    protected $fillable = ['awardCode', 'awardCount', 'special', 'game', 'image', 'ribbonName'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game', 'code');
    }
}
