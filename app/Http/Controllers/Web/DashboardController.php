<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class DashboardController extends WebController
{
    public function index()
    {
        return $this->setViewData([
            'title' => 'Dashboard',
            'title_header' => 'Dashboard',
        ])->loadView('admin.dashboard.dashboard');
    }
}
