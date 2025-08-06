<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='roles'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Roles"></x-navbars.navs.auth>

        <div class="container">
            <x-status-message></x-status-message>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary my-3">Back</a>
            <div class="card card-body mx-auto">
                <form action="{{ route('roles.update', $role) }}" method="post" class="form-inline">@csrf @method('PUT')
                    <div class="row">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Role Name:</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="name" value="{{ old('name', $role->name) }}" placeholder="Role Name"
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
                                    id="permission_{{ $permission->id }}"
                                    @if($role->permissions->contains($permission)) checked @endif>
                                <label for="permission_{{ $permission->id }}"
                                    class="col-form-label">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary mb-0">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</x-layout>
