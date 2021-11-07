<?php

namespace App\Http\Controllers;

use App\Models\WebInfo;

class WebAdminController extends Controller
{
    public $viewData = [];

    public function __construct()
    {
        $this->setViewData($this->getCommonViewData());
    }

    public function setViewData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->viewData[$key] = $value;
        }
        return $this;
    }

    public function getViewData()
    {
        return $this->viewData;
    }

    public function getSidebarMenu()
    {
        $route = request()->segment(2);
        $active_master = in_array($route, ['companies', 'customers', 'brands', 'payments', 'banks', 'services', 'spareparts', 'brand_types']) ? 'active' : '';
        $active_UTILITY = in_array($route, ['users', 'roles']) ? 'active' : '';
        $active_trx = in_array($route, ['quotations']) ? 'active' : '';

        $menus = [
            [
                'name' => 'DASHBOARD',
                'url' => url('admin/dashboard'),
                'icon' => 'fas fa-tachometer-alt',
                'active_class' => $route == 'dashboard' ? 'active' : '',
                'isSubMenu' => false,
                'submenu_open_class' => '',
                'submenu' => []
            ],
            [
                'name' => 'MASTER',
                'url' => '#',
                'icon' => 'fas fa-tachometer-alt',
                'active_class' => $active_master,
                'submenu_open_class' => ($active_master != '') ? 'menu-open' : '',
                'isSubMenu' => true,
                'submenu' => [
                    [
                        'name' => 'COMPANY',
                        'url' => url('admin/companies'),
                        'active_class' => $route == 'companies' ? 'active' : '',
                    ],
                ]
            ],
            [
                'name' => 'UTILITY SYSTEM',
                'url' => '#',
                'icon' => 'fas fa-tachometer-alt',
                'active_class' => $active_UTILITY,
                'submenu_open_class' => ($active_UTILITY != '') ? 'menu-open' : '',
                'isSubMenu' => true,
                'submenu' => [
                    [
                        'name' => 'USER',
                        'url' => url('admin/users'),
                        'active_class' => $route == 'users' ? 'active' : '',
                    ],
                    [
                        'name' => 'ROLE',
                        'url' => url('admin/roles'),
                        'active_class' => $route == 'roles' ? 'active' : '',
                    ],
                ]
            ],
        ];
        return $menus;
    }

    public function getCommonViewData()
    {
        return [
            'title' => 'myApp',
            'title_header' => '',
            'app_name' => 'myApp',
            'master_template' => 'admin.template.master',
            'sidebar_menu' => $this->getSidebarMenu(),
        ];
    }

    public function loadView($path, $data = [])
    {
        $this->setViewData($data);

        return view($path, $this->getViewData());
    }
}
