<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='users'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Edit User"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6>Edit User: {{ $user->name }}</h6>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back to Users</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.update', $user) }}" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control border border-2 p-2" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control border border-2 p-2" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control border border-2 p-2" placeholder="Leave blank to keep current password">
                                        @error('password')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control border border-2 p-2" placeholder="Confirm new password">
                                        @error('password_confirmation')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control border border-2 p-2" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Location</label>
                                        <input type="text" name="location" class="form-control border border-2 p-2" value="{{ old('location', $user->location) }}">
                                        @error('location')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">About</label>
                                        <textarea name="about" class="form-control border border-2 p-2" rows="3" placeholder="Tell something about this user">{{ old('about', $user->about) }}</textarea>
                                        @error('about')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <hr class="my-4">
                                        <h6 class="mb-3">Assign Roles</h6>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            @foreach ($roles as $role)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                                               id="role_{{ $role->id }}" class="form-check-input"
                                                               @if(old('roles'))
                                                                   {{ in_array($role->name, old('roles')) ? 'checked' : '' }}
                                                               @else
                                                                   {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                               @endif>
                                                        <label for="role_{{ $role->id }}" class="form-check-label">
                                                            {{ $role->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn bg-gradient-primary">Update User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Firefox form state reset
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page was loaded from cache (Firefox bfcache)
                window.location.reload();
            }
        });
        
        // Additional Firefox checkbox reset
        document.addEventListener('DOMContentLoaded', function() {
            // Force reset all checkboxes to their server-rendered state
            setTimeout(function() {
                const checkboxes = document.querySelectorAll('input[type="checkbox"][name="roles[]"]');
                checkboxes.forEach(function(checkbox) {
                    // Get the original checked state from the server-rendered HTML
                    const shouldBeChecked = checkbox.hasAttribute('checked');
                    checkbox.checked = shouldBeChecked;
                });
            }, 100);
        });
    </script>
</x-layout>
