<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    protected $table = 'hlstats_Roles';
    protected $primaryKey = 'roleId';
    public $timestamps = false;

    protected $fillable = ['game', 'code', 'name', 'hidden', 'picked', 'kills', 'deaths'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game', 'code');
    }
}
