<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function updateRole(User $currentUser, User $targetUser)
{
    if ($targetUser->email === 'admin@ritecs.com') {
        return false;
    }
    return $currentUser->hasRole('Admin');
}

}
