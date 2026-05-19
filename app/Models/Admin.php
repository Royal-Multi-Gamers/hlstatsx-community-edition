<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'hlstats_Admins';
    protected $primaryKey = 'adminId';
    public $timestamps = false;

    protected $fillable = ['username', 'password', 'game', 'serverID', 'accessLevel'];

    protected $hidden = ['password', 'remember_token'];

    public function isSuperAdmin(): bool
    {
        return $this->accessLevel === 'superadmin';
    }

    public function canManageGame(string $gameCode): bool
    {
        return $this->isSuperAdmin() || $this->game === $gameCode;
    }
}
