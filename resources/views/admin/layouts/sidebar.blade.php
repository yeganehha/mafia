<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ __('titles.admin_panel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ \Route::currentRouteName() == 'admin.home' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('titles.dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ in_array(\Route::currentRouteName(),['admin.users.index','admin.users.create','admin.users.edit']) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>{{ __('titles.users') }}</span>
        </a>
    </li>

    <li class="nav-item {{ in_array(\Route::currentRouteName(),['admin.orders', 'admin.transactions']) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.orders') }}">
            <i class="fas fa-shopping-cart"></i>
            <span>{{ __('titles.orders') }}</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-md-block bg-light">

    <li class="nav-item {{ in_array(\Route::currentRouteName(),['admin.setting']) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.setting') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>{{ __('titles.setting') }}</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"><i class="fas fa-fw fa-arrows-h text-light mt-2"></i>
        </button>
    </div>

</ul>
