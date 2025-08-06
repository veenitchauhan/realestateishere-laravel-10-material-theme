<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='permissions'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Permissions"></x-navbars.navs.auth>

        <div class="container">
            <x-status-message></x-status-message>
            <div class="card card-body col-8 mx-auto mt-5 align-items-center">
                <form action="{{ route('permissions.store') }}" method="post" class="form-inline">@csrf
                    <div class="row">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">New Permission:</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="Permission Name" class="p-2 form-control border col-6">
                            @error('name')
                                <p class="text-danger inputerror">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary mb-0">Add</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card mt-3">
                <div class="card-header pb-0">
                    <h6>Permissions List</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1 px-1">#</th>
                                <th class="col-6 px-1 text-start">Name</th>
                                <th class="col-2 px-1">Created</th>
                                <th class="col-3 px-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr class="text-center">
                                    <th class="col-1">{{ $loop->iteration }}</th>
                                    <td class="col-6 text-start">{{ $permission->name }}</td>
                                    <td class="col-2">{{ $permission->created_at->diffForHumans() }}</td>
                                    <td class="col-3">
                                        <form action="{{ route('permissions.destroy', $permission) }}" method="post">
                                            @csrf
                                            @method('DELETE')
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
