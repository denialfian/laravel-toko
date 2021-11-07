<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebAdminController;

class WebAdminDashboardController extends WebAdminController
{
    public function index()
    {
        return $this->setViewData([
            'title' => 'Dashboard',
            'title_header' => 'Dashboard',
        ])->loadView('admin.dashboard.dashboard');
    }
}
