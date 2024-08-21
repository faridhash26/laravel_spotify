<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserAccessPolicy
{
    
    public function access_user(User $user): bool
    {
        return $user->hasPermissionTo('RETRIVERED_ALBUMS');
    }
}
