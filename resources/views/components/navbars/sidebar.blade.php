@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <span class="font-weight-bold text-white h5">Real Estate is Here</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">

    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                href="{{ route('dashboard') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">dashboard</i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>

        @can('view-permissions')
        <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'permissions' ? ' active bg-gradient-primary' : '' }} "
                href="{{ route('permissions.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">security</i>
                </div>
                <span class="nav-link-text ms-1">Permissions</span>
            </a>
        </li>
        @endcan

        @can('view-roles')
        <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'roles' ? ' active bg-gradient-primary' : '' }} "
                href="{{ route('roles.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">admin_panel_settings</i>
                </div>
                <span class="nav-link-text ms-1">Roles</span>
            </a>
        </li>
        @endcan

        @can('view-users')
        <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'users' ? ' active bg-gradient-primary' : '' }} "
                href="{{ route('users.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">people</i>
                </div>
                <span class="nav-link-text ms-1">Users</span>
            </a>
        </li>
        @endcan

        @can('view-properties')
        <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'properties' ? ' active bg-gradient-primary' : '' }} "
                href="{{ route('properties.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">home</i>
                </div>
                <span class="nav-link-text ms-1">Properties</span>
            </a>
        </li>
        @endcan

        @can('view-reports')
        <li class="nav-item">
            <a class="nav-link text-white {{ $activePage == 'reports' ? ' active bg-gradient-primary' : '' }} "
                href="{{ route('reports') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">analytics</i>
                </div>
                <span class="nav-link-text ms-1">Reports</span>
            </a>
        </li>
        @endcan
    </ul>
</aside>
