<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebAdminController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WebAdminRoleController extends WebAdminController
{
    public function index()
    {
        return $this->loadView('admin.role.index', [
            'title' => 'role',
        ]);
    }

    public function create()
    {
        return $this->loadView('admin.role.create', [
            'title' => 'create role',
            'permissions' => Permission::orderBy('name', 'asc')->get()->groupBy('category_name')
        ]);
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->where('id', $id)->firstOrFail();
        $permissions = Permission::orderBy('name', 'asc')->get()->map(function ($row) use ($role) {
            $checked = $role->permissions->where('id', $row->id)->first() == null ? '' : 'checked';
            return [
                'id' => $row->id,
                'name' => $row->name,
                'checked' => $checked,
                'category_name' => $row->category_name,
            ];
        });

        return $this->loadView('admin.role.edit', [
            'title' => 'role edit',
            'permissions' => $permissions->groupBy('category_name'),
            'role' => $role
        ]);
    }
}
