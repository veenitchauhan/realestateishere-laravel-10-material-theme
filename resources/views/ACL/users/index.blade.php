<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='users'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <x-status-message></x-status-message>
            
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">Users Management</h6>
                                    <div class="me-3">
                                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-white mb-0">
                                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New User
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Roles</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                                            <th class="text-secondary opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
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
                                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if($user->roles->count() > 0)
                                                        @foreach($user->roles as $role)
                                                            <span class="badge badge-sm bg-gradient-secondary me-1">{{ $role->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-secondary text-xs font-weight-bold">No Role</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('d/m/Y') }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm mb-0 me-1" data-toggle="tooltip" data-original-title="View user">
                                                        <i class="material-icons text-sm">visibility</i>
                                                    </a>
                                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm mb-0 me-1" data-toggle="tooltip" data-original-title="Edit user">
                                                        <i class="material-icons text-sm">edit</i>
                                                    </a>
                                                    @if($user->id !== auth()->id())
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm mb-0" data-toggle="tooltip" data-original-title="Delete user">
                                                                <i class="material-icons text-sm">delete</i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <p class="text-sm mb-0">No users found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($users->hasPages())
                                <div class="card-footer">
                                    {{ $users->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
