<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClanTag extends Model
{
    protected $table = 'hlstats_ClanTags';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['pattern', 'position'];
}
