<?php

namespace Database\Seeders;

use App\Models\User;
use App\Service\Role\AddUserRoleService;
use App\Service\User\UserCreateService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCreateService = new UserCreateService;

        $user = $userCreateService->execute([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $this->permissions();
        $this->roles();

        $addUserRoleService = new AddUserRoleService;
        $addUserRoleService->assignRole($user, Role::where('name', 'super-admin')->firstOrFail()->id);
    }

    public function permissions()
    {
        $moduls = [
            'user', 'role', 'permission',
        ];
        $results = [];
        foreach ($moduls as $modul) {
            $results[] = ['name' => $modul . '.read', 'guard_name' => 'web', 'category_name' => $modul];
            $results[] = ['name' => $modul . '.create', 'guard_name' => 'web', 'category_name' => $modul];
            $results[] = ['name' => $modul . '.update', 'guard_name' => 'web', 'category_name' => $modul];
            $results[] = ['name' => $modul . '.delete', 'guard_name' => 'web', 'category_name' => $modul];
        }

        Permission::insert($results);
    }

    public function roles()
    {
        $permissions = Permission::all();

        Role::create([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ])->givePermissionTo($permissions);
    }
}
