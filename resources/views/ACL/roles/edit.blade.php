<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='roles'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Edit Role"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <x-status-message></x-status-message>
            
            <!-- Edit Role Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg pt-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">Edit Role: {{ $role->name }}</h6>
                                    <div class="me-3">
                                        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-white mb-0">
                                            <i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back to Roles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('roles.update', $role) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-sm mb-0">Update Permissions:</h6>
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
                                                               onchange="togglePermissionBadge(this)"
                                                               @if($role->permissions->contains($permission)) checked @endif>
                                                        <label for="permission_{{ $permission->id }}" 
                                                               class="badge {{ $role->permissions->contains($permission) ? 'bg-success' : 'bg-secondary' }} text-white permission-badge cursor-pointer user-select-none">
                                                            <i class="material-icons text-xs me-1">{{ $role->permissions->contains($permission) ? 'check_box' : 'check_box_outline_blank' }}</i>
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 is-filled">
                                            <label class="form-label">Role Name</label>
                                            <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-control">
                                        </div>
                                        @error('name')
                                            <p class="text-danger inputerror">{{ $message }}</p>
                                        @enderror
                                        <button type="submit" class="btn bg-gradient-warning w-100 mb-3">
                                            <i class="material-icons text-sm">update</i>&nbsp;&nbsp;Update Role
                                        </button>
                                        
                                        <!-- Role Info -->
                                        <div class="card bg-light">
                                            <div class="card-body p-3">
                                                <h6 class="text-sm mb-2">Role Information:</h6>
                                                <p class="text-xs mb-1"><strong>Created:</strong> {{ $role->created_at->format('M d, Y') }}</p>
                                                <p class="text-xs mb-1"><strong>Updated:</strong> {{ $role->updated_at->format('M d, Y') }}</p>
                                                <p class="text-xs mb-0"><strong>Current Permissions:</strong> {{ $role->permissions->count() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    </main>
</x-layout>
