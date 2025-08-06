<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='roles'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Roles"></x-navbars.navs.auth>

        <div class="container">
            <x-status-message></x-status-message>
            <div class="card card-body mx-auto mt-5">
                <form action="{{ route('roles.store') }}" method="post" class="form-inline">@csrf
                    <div class="row">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">New Role:</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Role Name"
                                class="p-2 form-control border col-6">
                            @error('name')
                                <p class="text-danger inputerror">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row my-2">
                        @foreach ($permissions as $permission)
                            <div class="col-auto">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    id="permission_{{ $permission->id }}">
                                <label for="permission_{{ $permission->id }}"
                                    class="col-form-label">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary mb-0">Add</button>
                    </div>
                </form>
            </div>

            <div class="card mt-3">
                <div class="card-header pb-0">
                    <h6>Roles List</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1 px-1">#</th>
                                <th class="col-2 px-1 text-start">Name</th>
                                <th class="col-5 px-1 text-start">Permissions</th>
                                <th class="col-2 px-1">Created</th>
                                <th class="col-2 px-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr class="text-center">
                                    <th class="col-1">{{ $loop->iteration }}</th>
                                    <td class="col-2 text-start">{{ $role->name }}</td>
                                    <td class="col-5 text-start">{{ $role->permissions->pluck('name')->join(', ') }}</td>
                                    <td class="col-2">{{ $role->created_at->diffForHumans() }}</td>
                                    <td class="col-2">
                                        <form action="{{ route('roles.destroy', $role) }}" method="post" onsubmit="return confirm('Are you sure you want to delete the role: {{ $role->name }}? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm mb-0">
                                                Edit
                                            </a>
                                            <button type="submit" class="btn btn-danger btn-sm mb-0">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</x-layout>
