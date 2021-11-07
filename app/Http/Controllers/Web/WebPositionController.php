<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;

class WebPositionController extends WebController
{
    public function index()
    {
        return $this->loadView('admin.position.index', [
            'title' => 'position'
        ]);
    }
}
