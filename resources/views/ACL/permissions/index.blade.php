<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='permissions'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Permissions Management"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <x-status-message></x-status-message>
            
            <!-- Add New Permission Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-3">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Create New Permission</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('permissions.store') }}" method="post">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-8">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Permission Name</label>
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                        </div>
                                        @error('name')
                                            <p class="text-danger inputerror">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn bg-gradient-info w-100 mb-3">
                                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Create Permission
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions List -->
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Permissions Management</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Permission Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Used in Roles</th>
                                            <th class="text-secondary opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($permissions as $permission)
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
                                                            <h6 class="mb-0 text-sm">{{ $permission->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $permission->created_at->format('M d, Y') }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if($permission->roles->count() > 0)
                                                        <div class="d-flex justify-content-center flex-wrap">
                                                            @foreach($permission->roles as $role)
                                                                <span class="badge bg-gradient-success me-1 mb-1">{{ $role->name }}</span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-secondary">Not used</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <form action="{{ route('permissions.destroy', $permission) }}" method="post" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Are you sure you want to delete this permission? This will remove it from all roles.')">
                                                            <i class="material-icons text-sm">delete</i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="material-icons text-muted mb-2" style="font-size: 48px;">security</i>
                                                        <h6 class="text-muted">No permissions found</h6>
                                                        <p class="text-xs text-muted">Create your first permission above</p>
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
