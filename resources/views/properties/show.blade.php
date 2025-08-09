<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="properties"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Property Details"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Property Details</h6>
                            <div class="pe-3">
                                @can('edit-property')
                                    <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-light">
                                        <i class="material-icons">edit</i> Edit
                                    </a>
                                @endcan
                                <a href="{{ route('properties.index') }}" class="btn btn-sm btn-light">
                                    <i class="material-icons">arrow_back</i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <!-- Property Image/Gallery Section -->
                            <div class="col-lg-8 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        @if($property->images && count($property->images) > 0)
                                            <!-- Main Image Display -->
                                            <div class="position-relative mb-3">
                                                <img id="mainPropertyImage" src="{{ asset('storage/' . $property->images[0]) }}" alt="{{ $property->title }}" class="w-100 rounded-3" style="height: 400px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <span class="badge bg-gradient-info px-3 py-2">
                                                        <i class="material-icons text-sm me-1">photo_library</i>
                                                        {{ count($property->images) }} {{ count($property->images) == 1 ? 'Photo' : 'Photos' }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Thumbnail Navigation -->
                                            @if(count($property->images) > 1)
                                            <div class="row">
                                                @foreach($property->images as $index => $image)
                                                <div class="col-3 mb-2">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Property image {{ $index + 1 }}" class="w-100 rounded-3 cursor-pointer property-thumbnail @if($index == 0) border border-primary border-3 @endif" style="height: 80px; object-fit: cover;" onclick="changeMainImage('{{ asset('storage/' . $image) }}', {{ $index }})">
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        @else
                                            <!-- No Images Placeholder -->
                                            <div class="text-center py-5">
                                                <div class="bg-gradient-secondary border-radius-lg p-5 mb-3">
                                                    <i class="material-icons text-white" style="font-size: 4rem;">image_not_supported</i>
                                                    <h4 class="text-white mt-2">No Images Available</h4>
                                                    <p class="text-white opacity-8">This property doesn't have any images yet</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Property Information Section -->
                            <div class="col-lg-4 mb-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-gradient-success">
                                        <h5 class="text-white mb-0">
                                            <i class="material-icons">info</i> Property Info
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-4"><strong>Type:</strong></div>
                                            <div class="col-8">
                                                <span class="badge badge-sm bg-gradient-primary">{{ $property->type }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($property->bedrooms)
                                        <div class="row mb-2">
                                            <div class="col-4"><strong>Bedrooms:</strong></div>
                                            <div class="col-8">{{ $property->bedrooms }}</div>
                                        </div>
                                        @endif

                                        @if($property->bathrooms)
                                        <div class="row mb-2">
                                            <div class="col-4"><strong>Bathrooms:</strong></div>
                                            <div class="col-8">{{ $property->bathrooms }}</div>
                                        </div>
                                        @endif

                                        <div class="row mb-2">
                                            <div class="col-4"><strong>Area:</strong></div>
                                            <div class="col-8">{{ number_format($property->area) }} sq ft</div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-4"><strong>Status:</strong></div>
                                            <div class="col-8">
                                                @php
                                                    $statusColors = [
                                                        'Available' => 'success',
                                                        'Sold' => 'danger',
                                                        'Rented' => 'warning',
                                                        'Pending' => 'info'
                                                    ];
                                                    $statusColor = $statusColors[$property->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-sm bg-gradient-{{ $statusColor }}">
                                                    {{ $property->status }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-4"><strong>Added by:</strong></div>
                                            <div class="col-8">{{ $property->creator->name ?? 'Unknown' }}</div>
                                        </div>

                                        <hr>
                                        <div class="text-center">
                                            <h4 class="text-gradient text-primary mb-0">
                                                ₹{{ number_format($property->price / 100000, 2) }} Lakhs
                                            </h4>
                                            <small class="text-muted">₹{{ number_format($property->price) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Property Details -->
                            <div class="col-lg-8 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-gradient-info">
                                        <h5 class="text-white mb-0">
                                            <i class="material-icons">description</i> {{ $property->title }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-sm">{{ $property->description }}</p>
                                        
                                        <h6 class="mt-4 mb-3">
                                            <i class="material-icons text-info">location_on</i> Location
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-sm mb-1">
                                                    <strong>Address:</strong><br>
                                                    {{ $property->address }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-sm mb-1">
                                                    <strong>City:</strong> {{ $property->city }}<br>
                                                    <strong>State:</strong> {{ $property->state }}<br>
                                                    <strong>Pincode:</strong> {{ $property->pincode }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="col-lg-4 mb-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-gradient-warning">
                                        <h5 class="text-white mb-0">
                                            <i class="material-icons">star</i> Features
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if($property->features && count($property->features) > 0)
                                            <div class="row">
                                                @foreach($property->features as $feature)
                                                    <div class="col-12 mb-2">
                                                        <span class="badge badge-sm bg-gradient-secondary">
                                                            <i class="material-icons" style="font-size: 12px;">check</i>
                                                            {{ $feature }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted text-sm">No features listed</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @canany(['edit-property', 'delete-property'])
                        <div class="row">
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <h6 class="mb-3">Actions</h6>
                                        
                                        @can('edit-property')
                                            <a href="{{ route('properties.edit', $property) }}" 
                                               class="btn btn-info btn-sm me-2">
                                                <i class="material-icons">edit</i> Edit Property
                                            </a>
                                        @endcan

                                        @can('delete-property')
                                            <form action="{{ route('properties.destroy', $property) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Are you sure you want to delete this property?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="material-icons">delete</i> Delete Property
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcanany
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        function changeMainImage(imageUrl, index) {
            // Update the main image
            document.getElementById('mainPropertyImage').src = imageUrl;
            
            // Update thumbnail borders
            document.querySelectorAll('.property-thumbnail').forEach((thumb, i) => {
                if (i === index) {
                    thumb.classList.add('border', 'border-primary', 'border-3');
                } else {
                    thumb.classList.remove('border', 'border-primary', 'border-3');
                }
            });
        }
    </script>
    
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        
        .property-thumbnail {
            transition: all 0.3s ease;
        }
        
        .property-thumbnail:hover {
            transform: scale(1.05);
        }
    </style>
</x-layout>
