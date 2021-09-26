<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @foreach($sidebar_menu as $menu)
            <li class="nav-item {{ $menu['active_class'] }}">
                <a href="{{ $menu['url'] }}" class="nav-link {{ $menu['submenu_open_class'] }}">
                    <i class="nav-icon {{ $menu['icon'] }}"></i>
                    <p>{{ $menu['name'] }}  @if($menu['isSubMenu'])<i class="right fas fa-angle-left"></i>@endif</p>
                </a>
                @if($menu['isSubMenu'])
                <ul class="nav nav-treeview">
                    @foreach($menu['submenu'] as $submenu)
                    <li class="nav-item">
                        <a href="{{ $submenu['url'] }}" class="nav-link {{ $submenu['active_class'] }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ $submenu['name'] }}</p>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>