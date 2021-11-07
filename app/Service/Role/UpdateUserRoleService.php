<?php

namespace App\Service\Role;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UpdateUserRoleService
{
    public function syncRoles(User $user, $role_id)
    {
        return $user->syncRoles(Role::where('id', $role_id)->firstOrFail());
    }
}
