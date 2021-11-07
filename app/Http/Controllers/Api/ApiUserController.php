<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Service\Role\AddUserRoleService;
use App\Service\Role\UpdateUserRoleService;
use App\Service\User\UserCreateService;
use App\Service\User\UserDeleteService;
use App\Service\User\UserUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiUserController extends ApiController
{
    public function index(Request $request)
    {
        $keyword = $request->search;

        $query = User::with('roles')->where(function ($q) use ($keyword) {
            if (!empty($keyword)) {
                $q->where(function ($q2) use ($keyword) {
                    $q2->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%');
                });
            }
        });

        return $this->successResponse($this->bootstrapTableFormat($query, $request), 'ok');
    }

    public function store(UserRequest $request, UserCreateService $userCreateService, AddUserRoleService $addUserRoleService)
    {
        DB::beginTransaction();
        try {
            $user = $userCreateService->execute($request);
            $addUserRoleService->assignRole($user, $request->role_id);
            DB::commit();
            return $this->successResponse($user, 'ok');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e, $e->getMessage());
        }
    }

    public function update(UserRequest $request, $id, UserUpdateService $userUpdateService, UpdateUserRoleService $updateUserRoleService)
    {
        DB::beginTransaction();
        try {
            $user = $userUpdateService->execute($id, $request);
            $updateUserRoleService->syncRoles($user, $request->role_id);
            DB::commit();
            return $this->successResponse($user, 'ok');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e, $e->getMessage());
        }
    }

    public function destroy($id, UserDeleteService $userDeleteService)
    {
        return $this->successResponse($userDeleteService->execute($id), 'ok');
    }
}
