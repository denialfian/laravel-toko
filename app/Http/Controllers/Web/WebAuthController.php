<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends WebAdminController
{
    public function loginView()
    {
        return $this->loadView('authentication.login');
    }

    public function loginProsses(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return 'errr';
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/auth/login');
    }
}
