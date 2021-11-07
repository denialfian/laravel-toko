<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ApiRoleController extends ApiController
{
    public function index(Request $request)
    {
        $keyword = $request->search;

        $query = Role::where(function ($q) use ($keyword) {
            if (!empty($keyword)) {
                $q->where('name', 'like', '%' . $keyword . '%');
            }
        });

        return $this->successResponse($this->bootstrapTableFormat($query, $request), 'ok');
    }

    public function store(RoleRequest $request)
    {
        $permissions = Permission::whereIn('id', $request->permission_id)->get();

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ])->givePermissionTo($permissions);

        return $this->successResponse($role, 'ok');
    }

    public function update(RoleRequest $request, $id)
    {
        $permissions = Permission::whereIn('id', $request->permission_id)->get();

        $role = Role::where('id', $id)->firstOrFail();

        $resp = $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($permissions);

        return $this->successResponse($resp, 'ok');
    }

    public function destroy($id)
    {
        $resp = Role::where('id', $id)->firstOrFail()->delete();

        return $this->successResponse($resp, 'ok');
    }
}
