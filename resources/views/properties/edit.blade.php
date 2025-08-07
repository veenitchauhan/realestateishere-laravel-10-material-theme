<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="properties"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Property"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">🏠 Edit Property #{{ $property->id }}</h6>
                                    <div class="me-3">
                                        <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-white">
                                            <i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('properties.update', $property) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3 @if($property->title) is-filled @endif">
                                            <label class="form-label">Property Title</label>
                                            <input type="text" class="form-control" name="title" value="{{ old('title', $property->title) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3 @if($property->type) is-filled @endif">
                                            <label class="form-label">Property Type</label>
                                            <select class="form-control" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="House" {{ old('type', $property->type) == 'House' ? 'selected' : '' }}>House</option>
                                                <option value="Apartment" {{ old('type', $property->type) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                                <option value="Villa" {{ old('type', $property->type) == 'Villa' ? 'selected' : '' }}>Villa</option>
                                                <option value="Plot" {{ old('type', $property->type) == 'Plot' ? 'selected' : '' }}>Plot</option>
                                                <option value="Commercial" {{ old('type', $property->type) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group input-group-outline mb-3 @if($property->description) is-filled @endif">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3">{{ old('description', $property->description) }}</textarea>
                                </div>
                                
                                <div class="input-group input-group-outline mb-3 @if($property->address) is-filled @endif">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address', $property->address) }}" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3 @if($property->city) is-filled @endif">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" value="{{ old('city', $property->city) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3 @if($property->state) is-filled @endif">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="state" value="{{ old('state', $property->state) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3 @if($property->pincode) is-filled @endif">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control" name="pincode" value="{{ old('pincode', $property->pincode) }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->price) is-filled @endif">
                                            <label class="form-label">Price (₹)</label>
                                            <input type="number" class="form-control" name="price" value="{{ old('price', $property->price) }}" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->area) is-filled @endif">
                                            <label class="form-label">Area (sq ft)</label>
                                            <input type="number" class="form-control" name="area" value="{{ old('area', $property->area) }}" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->bedrooms) is-filled @endif">
                                            <label class="form-label">Bedrooms</label>
                                            <input type="number" class="form-control" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->bathrooms) is-filled @endif">
                                            <label class="form-label">Bathrooms</label>
                                            <input type="number" class="form-control" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group input-group-outline mb-3 @if($property->status) is-filled @endif">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Available" {{ old('status', $property->status) == 'Available' ? 'selected' : '' }}>Available</option>
                                        <option value="Pending" {{ old('status', $property->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Sold" {{ old('status', $property->status) == 'Sold' ? 'selected' : '' }}>Sold</option>
                                        <option value="Rented" {{ old('status', $property->status) == 'Rented' ? 'selected' : '' }}>Rented</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('properties.show', $property) }}" class="btn btn-outline-secondary">
                                        <i class="material-icons">visibility</i> View Property
                                    </a>
                                    <div>
                                        <a href="{{ route('properties.index') }}" class="btn btn-outline-primary me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="material-icons">save</i> Update Property
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
