<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerConfig extends Model
{
    protected $table = 'hlstats_Servers_Config';
    protected $primaryKey = 'serverConfigId';
    public $timestamps = false;

    protected $fillable = ['serverId', 'parameter', 'value'];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class, 'serverId', 'serverId');
    }
}
