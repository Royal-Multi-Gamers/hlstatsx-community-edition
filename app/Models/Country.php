<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'hlstats_Countries';
    protected $primaryKey = 'countryId';
    public $timestamps = false;

    protected $fillable = ['flag', 'name', 'kills', 'players'];
}
