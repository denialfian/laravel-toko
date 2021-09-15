<?php

namespace App\Http\Controllers;

use App\Models\WebInfo;

class WebController extends Controller
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
                'icon' => 'mdi mdi-av-timer',
                'active' => $route == 'dashboard' ? 'active' : 'active',
                'isSubMenu' => false,
                'submenu_selection_class' => '',
                'submenu_open_class' => '',
                'submenu_arrow_class' => '',
                'submenu' => []
            ],
            [
                'name' => 'MASTER',
                'url' => 'javascript:void(0)',
                'icon' => 'mdi mdi-apps',
                'active' => $active_master,
                'submenu_selection_class' => ($active_master != '') ? 'selected' : '',
                'submenu_open_class' => ($active_master != '') ? 'in' : '',
                'submenu_arrow_class' => 'has-arrow',
                'isSubMenu' => true,
                'submenu' => [
                    [
                        'name' => 'COMPANY',
                        'url' => url('admin/companies'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'companies' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'CUSTOMER',
                        'url' => url('admin/customers'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'customers' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'BRAND',
                        'url' => url('admin/brands'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'brands' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'BRAND TYPE',
                        'url' => url('admin/brand_types'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'brand_types' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'BANK',
                        'url' => url('admin/banks'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'banks' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'PAYMENT',
                        'url' => url('admin/payments'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'payments' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'SERIVCE',
                        'url' => url('admin/services'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'services' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'SPAREPART',
                        'url' => url('admin/spareparts'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'spareparts' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                ]
            ],
            [
                'name' => 'TRANSACTION',
                'url' => 'javascript:void(0)',
                'icon' => 'mdi mdi-apps',
                'active' => $active_trx,
                'submenu_selection_class' => ($active_trx != '') ? 'selected' : '',
                'submenu_open_class' => ($active_trx != '') ? 'in' : '',
                'submenu_arrow_class' => 'has-arrow',
                'isSubMenu' => true,
                'submenu' => [
                    [
                        'name' => 'QUOTATION',
                        'url' => url('admin/quotations'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'quotations' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                ]
            ],
            [
                'name' => 'UTILITY SYSTEM',
                'url' => 'javascript:void(0)',
                'icon' => 'mdi mdi-apps',
                'active' => $active_UTILITY,
                'submenu_selection_class' => ($active_UTILITY != '') ? 'selected' : '',
                'submenu_open_class' => ($active_UTILITY != '') ? 'in' : '',
                'submenu_arrow_class' => 'has-arrow',
                'isSubMenu' => true,
                'submenu' => [
                    [
                        'name' => 'USER',
                        'url' => url('admin/users'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'users' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                    [
                        'name' => 'ROLE',
                        'url' => url('admin/roles'),
                        'icon' => 'mdi mdi-adjust',
                        'active' => $route == 'roles' ? 'active' : 'nav-link',
                        'isSubMenu' => false,
                    ],
                ]
            ],
        ];
        return $menus;
    }

    public function getCommonViewData()
    {
        return [
            'title' => 'astect',
            'card_header_color_class' => 'bg-info',
            'modal_header_color_class' => 'modal-colored-header bg-info text-white',
            'master_template' => 'admin.template.master',
            'sidebar_menu' => $this->getSidebarMenu(),
        ];
    }

    public function loadView($path, $data = [])
    {
        $this->setViewData($data);
        $this->setViewData([
            'auth_user' =>  auth()->user()
        ]);
        return view($path, $this->getViewData());
    }
}
