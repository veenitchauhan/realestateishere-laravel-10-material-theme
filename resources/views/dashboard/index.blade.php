<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>
        <!-- End Navbar -->
        
        <!-- Custom CSS for hover effects -->
        <style>
        .dashboard-card-link {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .dashboard-card-link:hover {
            transform: translateY(-5px);
            text-decoration: none !important;
        }
        .dashboard-card-link:hover .card {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        </style>
        
        <div class="container-fluid py-4">
            <!-- Role-Based Access Demo -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">🔐 Permission-Based Access Control Demo</h6>
                                <p class="text-sm mb-0">See how permissions control what you can access!</p>
                            </div>
                            <div class="badge badge-lg bg-gradient-primary text-white">
                                Your Role: 
                                @if(auth()->user()->roles->count() > 0)
                                    {{ auth()->user()->roles->first()->name }}
                                @else
                                    No Role Assigned
                                @endif
                            </div>
                        </div>
                        <div class="row">
                                @can('view-permissions')
                                <div class="col-md-3 mb-4">
                                    <a href="{{ route('permissions.index') }}" class="dashboard-card-link">
                                        <div class="card bg-gradient-danger shadow-lg">
                                            <div class="card-body text-center text-white p-4">
                                                <i class="material-icons mb-3 text-white" style="font-size: 3rem;">security</i>
                                                <h6 class="text-white font-weight-bold mb-2">Permissions</h6>
                                                <p class="text-white opacity-8 mb-0">Manage permissions</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('view-roles')
                                <div class="col-md-3 mb-4">
                                    <a href="{{ route('roles.index') }}" class="dashboard-card-link">
                                        <div class="card bg-gradient-warning shadow-lg">
                                            <div class="card-body text-center text-white p-4">
                                                <i class="material-icons mb-3 text-white" style="font-size: 3rem;">admin_panel_settings</i>
                                                <h6 class="text-white font-weight-bold mb-2">Roles</h6>
                                                <p class="text-white opacity-8 mb-0">Manage user roles</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('view-users')
                                <div class="col-md-3 mb-4">
                                    <a href="{{ route('users.index') }}" class="dashboard-card-link">
                                        <div class="card bg-gradient-info shadow-lg">
                                            <div class="card-body text-center text-white p-4">
                                                <i class="material-icons mb-3 text-white" style="font-size: 3rem;">people</i>
                                                <h6 class="text-white font-weight-bold mb-2">Users</h6>
                                                <p class="text-white opacity-8 mb-0">
                                                    @can('create-users')
                                                        Create & edit users
                                                    @else
                                                        View users only
                                                    @endcan
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('view-properties')
                                <div class="col-md-3 mb-4">
                                    <a href="{{ route('properties.index') }}" class="dashboard-card-link">
                                        <div class="card bg-gradient-success shadow-lg">
                                            <div class="card-body text-center text-white p-4">
                                                <i class="material-icons mb-3 text-white" style="font-size: 3rem;">home</i>
                                                <h6 class="text-white font-weight-bold mb-2">Properties</h6>
                                                <p class="text-white opacity-8 mb-0">
                                                    @can('create-properties')
                                                        Full property control
                                                    @else
                                                        View properties only
                                                    @endcan
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('view-reports')
                                <div class="col-md-3 mb-4">
                                    <a href="{{ route('reports') }}" class="dashboard-card-link">
                                        <div class="card bg-gradient-secondary shadow-lg">
                                            <div class="card-body text-center text-white p-4">
                                                <i class="material-icons mb-3 text-white" style="font-size: 3rem;">analytics</i>
                                                <h6 class="text-white font-weight-bold mb-2">Reports</h6>
                                                <p class="text-white opacity-8 mb-0">View system reports</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @cannot('view-users')
                                @cannot('view-roles') 
                                @cannot('view-properties')
                                @cannot('view-reports')
                                <div class="col-md-6 mb-4">
                                    <div class="card bg-gradient-light shadow-lg">
                                        <div class="card-body text-center p-4">
                                            <i class="material-icons mb-3" style="font-size: 3rem;">person</i>
                                            <h6 class="font-weight-bold mb-2">Basic User Access</h6>
                                            <p class="opacity-8 mb-0">Dashboard and profile access only</p>
                                        </div>
                                    </div>
                                </div>
                                @endcannot
                                @endcannot
                                @endcannot  
                                @endcannot
                            </div>
                        </div>
                    </div>
                
                    <!-- Permission Details -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6 class="mb-0">🎯 Your Current Permissions</h6>
                                </div>
                                <div class="card-body">
                                            <div class="row">
                                                @forelse(auth()->user()->getAllPermissions()->groupBy(function($permission) {
                                                    return explode('-', $permission->name)[1] ?? 'other';
                                                }) as $category => $permissions)
                                                    <div class="col-md-3">
                                                        <h6 class="text-uppercase text-xs font-weight-bolder opacity-8">{{ ucfirst($category) }}</h6>
                                                        <ul class="list-unstyled">
                                                            @foreach($permissions as $permission)
                                                                <li class="text-sm">
                                                                    <i class="material-icons text-success" style="font-size: 14px;">check_circle</i>
                                                                    {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @empty
                                                    <div class="col-12">
                                                        <p class="text-center text-muted">No specific permissions assigned</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
