<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebAdminController;
use Spatie\Permission\Models\Role;

class WebAdminUserController extends WebAdminController
{
    public function index()
    {
        return $this->loadView('admin.user.index', [
            'title' => 'users',
            'title_header' => 'users',
            'roles' => Role::all(),
        ]);
    }
}
