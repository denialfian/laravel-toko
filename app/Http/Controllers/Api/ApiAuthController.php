<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $resp = [
                'user' => $user,
                'token' => $user->createToken('MyApp')->plainTextToken
            ];
            return $this->successResponse($resp, 'User login successfully.');
        }

        return $this->errorResponse([], 'email or password mismatch', 401);
    }
}
