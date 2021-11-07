<?php

namespace App\Service\User;

use App\Models\User;
use Illuminate\Http\Request;

class UserCreateService
{
    public function execute(request|array $data): User
    {
        return User::create($this->getDataForCreate($data));
    }

    public function getDataForCreate(request|array $params): array
    {
        $data = $params;
        
        if ($params instanceof \Illuminate\Http\Request) {
            $data = $params->all();
        }

        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];
    }
}
