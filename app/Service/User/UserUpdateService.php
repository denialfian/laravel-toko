<?php

namespace App\Service\User;

use App\Models\User;
use Illuminate\Http\Request;

class UserUpdateService
{
    public function execute($id, request|array $params): User
    {
        return tap(User::where('id', $id)->firstOrFail())->update($this->getDataForUpdate($params));
    }

    public function getDataForUpdate(request|array $params): array
    {
        $data = $params;
        
        if ($params instanceof \Illuminate\Http\Request) {
            $data = $params->all();
        }

        return [
            'name' => $data['name'],
            'email' => $data['email'],
        ];
    }
}
