<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class HlstatsAdminProvider extends EloquentUserProvider
{
    /**
     * Validate credentials using MD5 (legacy HLStatsX password format).
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return md5($credentials['password']) === $user->getAuthPassword();
    }
}
