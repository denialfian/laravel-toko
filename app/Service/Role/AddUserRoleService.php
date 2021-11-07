<?php

namespace App\Service\Role;

use App\Models\User;
use Spatie\Permission\Models\Role;

class AddUserRoleService
{
    public function assignRole(User $user, $role_id)
    {
        return $user->assignRole(Role::where('id', $role_id)->firstOrFail());
    }
}
