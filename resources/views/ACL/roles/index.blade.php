<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='roles'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Roles Management"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <x-status-message></x-status-message>
            
            <!-- Add New Role Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-3 pb-3">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Create New Role</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('roles.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-sm mb-0">Assign Permissions:</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-outline-success me-1" onclick="selectAllPermissions()">Select All</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearAllPermissions()">Clear All</button>
                                            </div>
                                        </div>
                                        <div class="border rounded p-3" style="max-height: 120px; overflow-y: auto; background-color: #f8f9fa;">
                                            <div class="d-flex flex-wrap">
                                                @foreach ($permissions as $permission)
                                                    <div class="permission-badge-container ms-2 mb-2">
                                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                               id="permission_{{ $permission->id }}" class="permission-checkbox d-none"
                                                               onchange="togglePermissionBadge(this)">
                                                        <label for="permission_{{ $permission->id }}" 
                                                               class="badge bg-secondary text-white permission-badge cursor-pointer user-select-none">
                                                            <i class="material-icons text-xs me-1">check_box_outline_blank</i>
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Role Name</label>
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                        </div>
                                        @error('name')
                                            <p class="text-danger inputerror">{{ $message }}</p>
                                        @enderror
                                        <button type="submit" class="btn bg-gradient-success w-100">
                                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Create Role
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function togglePermissionBadge(checkbox) {
                    const badge = checkbox.nextElementSibling;
                    const icon = badge.querySelector('i');
                    
                    if (checkbox.checked) {
                        badge.classList.remove('bg-secondary');
                        badge.classList.add('bg-success');
                        icon.textContent = 'check_box';
                    } else {
                        badge.classList.remove('bg-success');
                        badge.classList.add('bg-secondary');
                        icon.textContent = 'check_box_outline_blank';
                    }
                }
                
                function selectAllPermissions() {
                    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = true;
                        togglePermissionBadge(checkbox);
                    });
                }
                
                function clearAllPermissions() {
                    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        togglePermissionBadge(checkbox);
                    });
                }
            </script>

            <!-- Roles List -->
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Roles Management</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Permissions</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                                            <th class="text-secondary opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roles as $role)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $loop->iteration }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">
                                                                {{ $role->name }}
                                                                @if($role->name === 'Super Admin')
                                                                    <span class="badge badge-sm bg-gradient-warning ms-2">Protected</span>
                                                                @endif
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap">
                                                        @if($role->name === 'Super Admin')
                                                            <span class="badge bg-gradient-success me-1 mb-1">
                                                                <i class="material-icons text-xs me-1">star</i>
                                                                All Permissions (Automatic)
                                                            </span>
                                                        @elseif($role->permissions->count() > 0)
                                                            @foreach($role->permissions as $permission)
                                                                <span class="badge bg-gradient-info me-1 mb-1">{{ $permission->name }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-xs text-secondary">No permissions assigned</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $role->created_at->format('M d, Y') }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    @if($role->name === 'Super Admin')
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-gradient-secondary">
                                                                <i class="material-icons text-xs me-1">lock</i>
                                                                System Role
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="d-flex align-items-center">
                                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm me-2">
                                                                <i class="material-icons text-sm">edit</i>
                                                            </a>
                                                            <form action="{{ route('roles.destroy', $role) }}" method="post" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                                        onclick="return confirm('Are you sure you want to delete the role: {{ $role->name }}? This action cannot be undone.')">
                                                                    <i class="material-icons text-sm">delete</i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="material-icons text-muted mb-2" style="font-size: 48px;">folder_open</i>
                                                        <h6 class="text-muted">No roles found</h6>
                                                        <p class="text-xs text-muted">Create your first role above</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
