<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='users'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="User Details"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6>User Details</h6>
                                <div>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back to Users</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <strong>Name:</strong>
                                        <p class="text-muted">{{ $user->name }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Email:</strong>
                                        <p class="text-muted">{{ $user->email }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Phone:</strong>
                                        <p class="text-muted">{{ $user->phone ?? 'Not provided' }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Location:</strong>
                                        <p class="text-muted">{{ $user->location ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <strong>About:</strong>
                                        <p class="text-muted">{{ $user->about ?? 'No description provided' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Assigned Roles:</strong>
                                        <div class="mt-2">
                                            @if($user->roles->count() > 0)
                                                @foreach($user->roles as $role)
                                                    <span class="badge bg-gradient-primary me-1">{{ $role->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No roles assigned</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Permissions (via roles):</strong>
                                        <div class="mt-2">
                                            @php
                                                $permissions = $user->getAllPermissions();
                                            @endphp
                                            @if($permissions->count() > 0)
                                                @foreach($permissions as $permission)
                                                    <span class="badge bg-gradient-success me-1 mb-1">{{ $permission->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No permissions</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Account Created:</strong>
                                        <p class="text-muted">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Last Updated:</strong>
                                        <p class="text-muted">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end mt-4">
                                <form method="POST" action="{{ route('users.destroy', $user) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                        Delete User
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
