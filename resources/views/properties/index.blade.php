<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="properties"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Property Management"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">🏠 Property Management</h6>
                                    <div class="me-3">
                                        @can('add-property')
                                        <a href="{{ route('properties.create') }}" class="btn btn-sm btn-outline-white mb-0">
                                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Property
                                        </a>
                                        @else
                                        <span class="badge badge-sm bg-gradient-info">
                                            @if(auth()->user()->hasRole('Admin'))
                                                Admin View: Full Access
                                            @elseif(auth()->user()->hasRole('Dealer'))
                                                Dealer View: Read Only
                                            @endif
                                        </span>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Property</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type & Details</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @can('show-property')
                                        @forelse($properties as $index => $property)
                                        <tr>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{ $properties->firstItem() + $index }}</h6>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $property->title }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $property->address }}, {{ $property->city }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                @php
                                                    $images = $property->images;
                                                    // Handle both array and string cases
                                                    if (is_string($images)) {
                                                        $images = json_decode($images, true) ?: [];
                                                    } elseif (!is_array($images)) {
                                                        $images = [];
                                                    }
                                                    $imageCount = count($images);
                                                @endphp
                                                
                                                @if($imageCount > 0)
                                                    <div class="avatar avatar-sm me-3 rounded-3 position-relative cursor-pointer" style="width: 60px; height: 45px;" data-bs-toggle="tooltip" data-bs-title="View property images">
                                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $property->title }}" class="w-100 h-100 rounded-3" style="object-fit: cover;">
                                                        @if($imageCount > 1)
                                                            <div class="position-absolute top-0 end-0 bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 18px; height: 18px; font-size: 10px; margin: -2px;">
                                                                {{ $imageCount }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="avatar avatar-sm bg-gradient-secondary rounded-3 d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 45px;" data-bs-toggle="tooltip" data-bs-title="No images available">
                                                        <i class="material-icons text-white opacity-10" style="font-size: 18px;">image_not_supported</i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0">{{ $property->type }}</p>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if($property->bedrooms || $property->bathrooms)
                                                        {{ $property->bedrooms ?? 0 }} Bed, {{ $property->bathrooms ?? 0 }} Bath
                                                    @else
                                                        {{ number_format($property->area) }} sq ft
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-success text-xs font-weight-bold">{{ $property->formatted_price }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge badge-sm {{ $property->status_badge_class }}">{{ $property->status }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @can('show-property')
                                                <a href="{{ route('properties.show', $property) }}" class="btn btn-info btn-sm mb-0 me-1" data-toggle="tooltip" data-original-title="View property">
                                                    <i class="material-icons text-sm">visibility</i>
                                                </a>
                                                @endcan
                                                
                                                @can('edit-property')
                                                <a href="{{ route('properties.edit', $property) }}" class="btn btn-warning btn-sm mb-0 me-1" data-toggle="tooltip" data-original-title="Edit property">
                                                    <i class="material-icons text-sm">edit</i>
                                                </a>
                                                @endcan
                                                
                                                @can('delete-property')
                                                <form action="{{ route('properties.destroy', $property) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mb-0" data-toggle="tooltip" data-original-title="Delete property">
                                                        <i class="material-icons text-sm">delete</i>
                                                    </button>
                                                </form>
                                                @endcan
                                                
                                                @cannot('edit-property')
                                                @cannot('delete-property')
                                                <span class="badge badge-sm bg-gradient-secondary">Read Only</span>
                                                @endcannot
                                                @endcannot
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="material-icons text-info" style="font-size: 3rem;">home</i>
                                                <h6 class="text-info">No Properties Found</h6>
                                                <p class="text-sm text-secondary">
                                                    @can('add-property')
                                                        <a href="{{ route('properties.create') }}" class="text-primary">Add the first property</a> to get started
                                                    @else
                                                        No properties have been added yet
                                                    @endcan
                                                </p>
                                            </td>
                                        </tr>
                                        @endforelse
                                        @else
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="material-icons text-danger" style="font-size: 3rem;">block</i>
                                                <h6 class="text-danger">Access Denied</h6>
                                                <p class="text-sm text-secondary">You don't have permission to view properties</p>
                                            </td>
                                        </tr>
                                        @endcan
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Beautiful Custom Pagination -->
                            @if($properties->hasPages())
                            <div class="mt-4">
                                {{ $properties->links('custom-pagination') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
