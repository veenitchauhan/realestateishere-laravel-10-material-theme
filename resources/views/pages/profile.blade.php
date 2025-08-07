<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="User Profile"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">👤 User Profile</h6>
                                    <div class="me-3">
                                        <span class="badge bg-gradient-success">
                                            {{ auth()->user()->roles->first()->name ?? 'User' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success') || session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="text-white">{{ session('success') ?? session('status') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('user-profile') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3 @if(auth()->user()->name) is-filled @endif">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="name" 
                                                   value="{{ old('name', auth()->user()->name) }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3 @if(auth()->user()->email) is-filled @endif">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="email" 
                                                   value="{{ old('email', auth()->user()->email) }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3 @if(auth()->user()->phone) is-filled @endif">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="phone" 
                                                   value="{{ old('phone', auth()->user()->phone) }}" maxlength="10">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3 @if(auth()->user()->location) is-filled @endif">
                                            <label class="form-label">Location</label>
                                            <input type="text" class="form-control" name="location" 
                                                   value="{{ old('location', auth()->user()->location) }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="input-group input-group-outline mb-3 @if(auth()->user()->about) is-filled @endif">
                                    <label class="form-label">About Me</label>
                                    <textarea class="form-control" name="about" rows="3" maxlength="150">{{ old('about', auth()->user()->about) }}</textarea>
                                </div>
                                
                                <hr class="horizontal dark my-4">
                                <h6 class="mb-3">🔒 Change Password (Optional)</h6>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" class="form-control" name="current_password">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control" name="password" minlength="8">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" minlength="8">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="material-icons">save</i> Update Profile
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Current User Info Display -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">📋 Current Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                                                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                                    <p><strong>Phone:</strong> {{ auth()->user()->phone ?? 'Not provided' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Role:</strong> 
                                                        <span class="badge bg-gradient-info">
                                                            {{ auth()->user()->roles->first()->name ?? 'No role assigned' }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Location:</strong> {{ auth()->user()->location ?? 'Not provided' }}</p>
                                                    <p><strong>Member Since:</strong> {{ auth()->user()->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>