<?php

namespace App\Service\User;

use App\Models\User;

class UserDeleteService
{
    public function execute($id)
    {
        return User::where('id', $id)->delete();
    }
}
