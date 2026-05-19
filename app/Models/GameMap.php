<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMap extends Model
{
    protected $table = 'hlstats_Maps_Counts';
    protected $primaryKey = 'rowId';
    public $timestamps = false;

    protected $fillable = ['game', 'map', 'kills', 'headshots'];
}
