<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostGroup extends Model
{
    protected $table = 'hlstats_HostGroups';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['pattern', 'name'];
}
