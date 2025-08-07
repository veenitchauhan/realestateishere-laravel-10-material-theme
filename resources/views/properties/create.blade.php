<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="properties"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Create Property"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">🏠 Create New Property</h6>
                            <p class="text-sm mb-0">Add a new property to your listings</p>
                        </div>
                        <div class="card-body">
                            @can('create-properties')
                            <form id="propertyForm" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Property Name</label>
                                            <input type="text" class="form-control" name="property_name" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Property Type</label>
                                            <select class="form-control" name="property_type" autocomplete="off">
                                                <option value=" ">--Select Property Type--</option>
                                                <option value="Villa">Villa</option>
                                                <option value="Apartment">Apartment</option>
                                                <option value="House">House</option>
                                                <option value="Commercial">Commercial</option>
                                                <option value="Condo">Condo</option>
                                                <option value="Townhouse">Townhouse</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" autocomplete="off">
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="number" class="form-control" name="price" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Bedrooms</label>
                                            <input type="number" class="form-control" name="bedrooms" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Bathrooms</label>
                                            <input type="number" class="form-control" name="bathrooms" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('properties.index') }}" class="btn btn-light me-2">Cancel</a>
                                    <button type="submit" class="btn bg-gradient-primary">Create Property</button>
                                </div>
                            </form>
                            @else
                            <div class="text-center py-4">
                                <i class="material-icons text-danger" style="font-size: 3rem;">block</i>
                                <h6 class="text-danger">Access Denied</h6>
                                <p class="text-sm text-secondary">You don't have permission to create properties</p>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reset form on page load to prevent Firefox form persistence
            document.getElementById('propertyForm').reset();
            
            // Initialize Material Dashboard form elements
            var inputs = document.querySelectorAll('.input-group input, .input-group select');
            inputs.forEach(function(input) {
                if (input.value !== '') {
                    input.parentElement.classList.add('is-filled');
                }
                
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('is-focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('is-focused');
                    if (this.value !== '') {
                        this.parentElement.classList.add('is-filled');
                    } else {
                        this.parentElement.classList.remove('is-filled');
                    }
                });
            });
            
            // Special handling for select element
            var selectElement = document.querySelector('select[name="property_type"]');
            if (selectElement) {
                selectElement.addEventListener('change', function() {
                    if (this.value !== '') {
                        this.parentElement.classList.add('is-filled');
                    } else {
                        this.parentElement.classList.remove('is-filled');
                    }
                });
            }
        });
    </script>
</x-layout>
