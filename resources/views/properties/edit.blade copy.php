<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="properties"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Property"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="ps-3">
                                        <h6 class="text-white text-capitalize mb-0">🏠 Edit Property #{{ $property->id }}</h6>
                                        <p class="text-white opacity-8 text-sm mb-0">Update property information</p>
                                    </div>
                                    <div class="me-3">
                                        <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-white mb-0">
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

                            <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <!-- Required Fields -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group input-group-outline mb-3 @if($property->title) is-filled @endif">
                                            <label class="form-label">Property Title *</label>
                                            <input type="text" class="form-control" name="title" value="{{ old('title', $property->title) }}" required>
                                            @error('title')
                                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="type" class="ms-0">Property Type *</label>
                                            <select class="form-control" name="type" id="type" required>
                                                <option value="" disabled>--Select Property Type--</option>
                                                <option value="House" {{ old('type', $property->type) == 'House' ? 'selected' : '' }}>House</option>
                                                <option value="Apartment" {{ old('type', $property->type) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                                <option value="Villa" {{ old('type', $property->type) == 'Villa' ? 'selected' : '' }}>Villa</option>
                                                <option value="Plot" {{ old('type', $property->type) == 'Plot' ? 'selected' : '' }}>Plot</option>
                                                <option value="Commercial" {{ old('type', $property->type) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                            </select>
                                            @error('type')
                                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="status" class="ms-0">Status *</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" disabled>--Select Status--</option>
                                                <option value="Available" {{ old('status', $property->status) == 'Available' ? 'selected' : '' }}>Available</option>
                                                <option value="Pending" {{ old('status', $property->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Sold" {{ old('status', $property->status) == 'Sold' ? 'selected' : '' }}>Sold</option>
                                                <option value="Rented" {{ old('status', $property->status) == 'Rented' ? 'selected' : '' }}>Rented</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Property Images Gallery -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">📸 Property Gallery</h6>
                                        <p class="text-sm text-muted mb-3">Upload up to 12 images for your property (optional)</p>
                                        
                                        <!-- Main Preview Container -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                @php
                                                    $images = $property->images;
                                                    if (is_string($images)) {
                                                        $images = json_decode($images, true) ?: [];
                                                    } elseif (!is_array($images)) {
                                                        $images = [];
                                                    }
                                                    $hasImages = !empty($images);
                                                    $mainImage = $hasImages ? asset('storage/' . $images[0]) : '';
                                                @endphp
                                                <div id="mainImagePreview" class="border-2 border-dashed border-light rounded-3 d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa; @if($hasImages) background-image: url('{{ $mainImage }}'); background-size: cover; background-position: center; @endif">
                                                    @if(!$hasImages)
                                                    <div class="text-center">
                                                        <i class="material-icons text-muted" style="font-size: 3rem;">add_photo_alternate</i>
                                                        <p class="text-muted mb-0">Main Property Image</p>
                                                        <small class="text-muted">Click on thumbnails below to set as main image</small>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Upload Instructions -->
                                            <div class="col-md-4">
                                                <div class="card h-100">
                                                    <div class="card-body d-flex flex-column justify-content-center">
                                                        <h6 class="text-primary mb-3">🎯 Image Tips</h6>
                                                        <ul class="text-sm text-muted mb-0 ps-3">
                                                            <li class="mb-1">Upload high-quality images</li>
                                                            <li class="mb-1">Recommended: 1200x800px</li>
                                                            <li class="mb-1">Formats: JPG, PNG, WebP</li>
                                                            <li class="mb-1">Max size: 5MB per image</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Thumbnail Grid -->
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="row" id="thumbnailGrid">
                                                    <!-- Existing Images -->
                                                    @if($hasImages)
                                                        @foreach($images as $index => $image)
                                                        <div class="col-2 mb-3" id="existingSlot{{ $index + 1 }}">
                                                            <div class="image-upload-slot position-relative">
                                                                <div class="image-slot border-2 border-dashed border-light rounded-3 d-flex align-items-center justify-content-center cursor-pointer @if($index == 0) border-primary @endif" style="height: 120px; background-color: #f8f9fa; background-image: url('{{ asset('storage/' . $image) }}'); background-size: cover; background-position: center; @if($index == 0) border-width: 3px; @endif" onclick="setMainImage({{ $index + 1 }})">
                                                                </div>
                                                                <div class="image-controls position-absolute top-0 end-0" style="margin: 5px;">
                                                                    <button type="button" class="btn btn-sm @if($index == 0) btn-warning @else btn-success @endif me-1 rounded-circle" style="width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;" onclick="setMainImage({{ $index + 1 }})" title="Set as main image">
                                                                        <i class="material-icons" style="font-size: 14px; font-weight: bold;">star</i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-danger rounded-circle" style="width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;" onclick="removeExistingImage({{ $index + 1 }})" title="Remove image">
                                                                        <i class="material-icons" style="font-size: 14px; font-weight: bold;">close</i>
                                                                    </button>
                                                                </div>
                                                                <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @endif

                                                    <!-- New Image Upload Slots - Only created dynamically via "Add More" -->
                                                    @php
                                                        $existingCount = count($images);
                                                        $nextSlot = $existingCount + 1;
                                                        // On edit page, don't show any empty slots initially
                                                        $slotsToShow = 0;
                                                    @endphp

                                                    <!-- Add More Button -->
                                                    @if($existingCount < 12)
                                                    <div class="col-2 mb-3" id="addMoreSlot">
                                                        <div class="add-more-card border-2 border-dashed border-info rounded-3 d-flex align-items-center justify-content-center cursor-pointer" style="height: 120px; background-color: #f0f8ff;" onclick="addOneMoreSlot()">
                                                            <div class="text-center">
                                                                <i class="material-icons text-info" style="font-size: 2rem;">add_circle_outline</i>
                                                                <p class="text-xs text-info mb-0 fw-bold">Add More</p>
                                                                <p class="text-xs text-muted mb-0">({{ 12 - $existingCount }} more slots)</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    
                                                    <!-- Dynamic slots - initially hidden, created by "Add More" -->
                                                    @for($i = $nextSlot; $i <= 12; $i++)
                                                    <div class="col-2 mb-3 additional-slot d-none" id="slot{{ $i }}">
                                                        <div class="image-upload-slot position-relative">
                                                            <input type="file" id="image{{ $i }}" name="images[]" accept="image/*" class="d-none" onchange="handleImageUpload({{ $i }}, this)">
                                                            <label for="image{{ $i }}" class="image-slot border-2 border-dashed border-light rounded-3 d-flex align-items-center justify-content-center cursor-pointer" style="height: 120px; background-color: #f8f9fa;">
                                                                <div class="text-center">
                                                                    <i class="material-icons text-muted">add_a_photo</i>
                                                                    <p class="text-xs text-muted mb-0">Image {{ $i }}</p>
                                                                </div>
                                                            </label>
                                                            <div class="image-controls position-absolute top-0 end-0 d-none" style="margin: 5px;">
                                                                <button type="button" class="btn btn-sm btn-success me-1 rounded-circle" style="width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;" onclick="setMainImage({{ $i }})" title="Set as main image">
                                                                    <i class="material-icons" style="font-size: 14px; font-weight: bold;">star</i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger rounded-circle" style="width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;" onclick="removeImage({{ $i }})" title="Remove image">
                                                                    <i class="material-icons" style="font-size: 14px; font-weight: bold;">close</i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @error('images')
                                            <div class="text-danger text-sm mt-2">{{ $message }}</div>
                                        @enderror
                                        @error('images.*')
                                            <div class="text-danger text-sm mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Optional Fields -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group input-group-outline mb-3 @if($property->description) is-filled @endif">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" rows="3">{{ old('description', $property->description) }}</textarea>
                                            @error('description')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group input-group-outline mb-3 @if($property->address) is-filled @endif">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address', $property->address) }}">
                                            @error('address')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3 @if($property->city) is-filled @endif">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" value="{{ old('city', $property->city) }}">
                                            @error('city')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3 @if($property->state) is-filled @endif">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="state" value="{{ old('state', $property->state) }}">
                                            @error('state')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3 @if($property->pincode) is-filled @endif">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control" name="pincode" value="{{ old('pincode', $property->pincode) }}">
                                            @error('pincode')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->price) is-filled @endif">
                                            <label class="form-label">Price (₹)</label>
                                            <input type="number" class="form-control" name="price" value="{{ old('price', $property->price) }}" step="0.01" min="0">
                                            @error('price')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->area) is-filled @endif">
                                            <label class="form-label">Area (sq ft)</label>
                                            <input type="number" class="form-control" name="area" value="{{ old('area', $property->area) }}" step="0.01" min="0">
                                            @error('area')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->bedrooms) is-filled @endif">
                                            <label class="form-label">Bedrooms</label>
                                            <input type="number" class="form-control" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0">
                                            @error('bedrooms')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3 @if($property->bathrooms) is-filled @endif">
                                            <label class="form-label">Bathrooms</label>
                                            <input type="number" class="form-control" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0">
                                            @error('bathrooms')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden input to track main image changes -->
                                <input type="hidden" name="main_image_slot" id="mainImageSlot" value="1">
                                
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('properties.index') }}" class="btn btn-light me-2">Cancel</a>
                                    <button type="submit" class="btn bg-gradient-primary">Update Property</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
    
    <script>
        let currentMainImage = 1;
        let uploadedImages = {};
        let existingImages = {};
        let nextSlotToShow = {{ count($images) + 1 + 1 }}; // existing + 1 visible slot + next slot to show

        // Initialize existing images
        @if($hasImages)
            @foreach($images as $index => $image)
                existingImages[{{ $index + 1 }}] = '{{ asset("storage/" . $image) }}';
                uploadedImages[{{ $index + 1 }}] = '{{ asset("storage/" . $image) }}';
            @endforeach
            currentMainImage = 1;
        @endif

        function addOneMoreSlot() {
            // Create a temporary file input to select image
            const tempInput = document.createElement('input');
            tempInput.type = 'file';
            tempInput.accept = 'image/*';
            tempInput.style.display = 'none';
            
            tempInput.onchange = function(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showErrorMessage('Please select a valid image file.');
                    return;
                }
                
                // Find next available slot number
                let nextSlotNumber = nextSlotToShow;
                while (nextSlotNumber <= 12) {
                    const slot = document.getElementById(`slot${nextSlotNumber}`);
                    if (slot && slot.classList.contains('d-none')) {
                        break;
                    }
                    nextSlotNumber++;
                }
                
                if (nextSlotNumber > 12) {
                    showErrorMessage('Maximum 12 images allowed.');
                    return;
                }
                
                // Show the slot
                const nextSlot = document.getElementById(`slot${nextSlotNumber}`);
                if (nextSlot) {
                    nextSlot.classList.remove('d-none');
                    
                    // Set the file to the actual input
                    const realInput = nextSlot.querySelector('input[type="file"]');
                    if (realInput) {
                        // Create a new FileList with our file
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        realInput.files = dt.files;
                        
                        // Trigger the upload process
                        handleImageUpload(nextSlotNumber, realInput);
                    }
                    
                    // Update nextSlotToShow for next time
                    nextSlotToShow = nextSlotNumber + 1;
                    updateAddMoreButton();
                    moveAddMoreButtonToEnd();
                }
                
                // Clean up temp input
                document.body.removeChild(tempInput);
            };
            
            // Trigger file selection
            document.body.appendChild(tempInput);
            tempInput.click();
        }

        function updateAddMoreButton() {
            const remainingSlots = 12 - (nextSlotToShow - 1);
            const addMoreSlot = document.getElementById('addMoreSlot');
            
            if (remainingSlots > 0 && addMoreSlot) {
                addMoreSlot.innerHTML = `
                    <div class="add-more-card border-2 border-dashed border-info rounded-3 d-flex align-items-center justify-content-center cursor-pointer" style="height: 120px; background-color: #f0f8ff;" onclick="addOneMoreSlot()">
                        <div class="text-center">
                            <i class="material-icons text-info" style="font-size: 2rem;">add_circle_outline</i>
                            <p class="text-xs text-info mb-0 fw-bold">Add More</p>
                            <p class="text-xs text-muted mb-0">(${remainingSlots} more slots)</p>
                        </div>
                    </div>
                `;
            } else if (addMoreSlot) {
                addMoreSlot.style.display = 'none';
            }
        }

        function moveAddMoreButtonToEnd() {
            const addMoreSlot = document.getElementById('addMoreSlot');
            const thumbnailGrid = document.querySelector('#thumbnailGrid');
            
            if (addMoreSlot && thumbnailGrid) {
                thumbnailGrid.appendChild(addMoreSlot);
            }
        }

        function handleImageUpload(slotNumber, input) {
            const file = input.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Please upload only image files (JPG, PNG, WebP)');
                input.value = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('Image size should be less than 5MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageUrl = e.target.result;
                uploadedImages[slotNumber] = imageUrl;

                const label = document.querySelector(`label[for="image${slotNumber}"]`);
                label.style.backgroundImage = `url(${imageUrl})`;
                label.style.backgroundSize = 'cover';
                label.style.backgroundPosition = 'center';
                label.innerHTML = '';
                
                const controls = label.parentElement.querySelector('.image-controls');
                controls.classList.remove('d-none');
                
                if (Object.keys(existingImages).length === 0 && Object.keys(uploadedImages).length === 1) {
                    setMainImage(slotNumber);
                }
            };
            reader.readAsDataURL(file);
        }

        function setMainImage(slotNumber) {
            const imageUrl = uploadedImages[slotNumber] || existingImages[slotNumber];
            if (!imageUrl) {
                console.error('No image found for slot:', slotNumber);
                return;
            }

            // If this is already the first image, no need to do anything
            if (slotNumber === 1) {
                // Just ensure visual indicators are correct, but don't show toast
                updateVisualIndicators();
                console.log('Image already at position 1');
                return;
            }

            // Show success message only when actually changing main image
            showSuccessMessage('Main image set successfully!');
            console.log('Setting main image from slot', slotNumber, 'to position 1');

            // Update hidden input to track which image should be main
            document.getElementById('mainImageSlot').value = slotNumber;

            // Unified reordering for both existing and new images
            reorderAllImages(slotNumber);
            
            // Update main preview
            updateMainPreview(imageUrl);
            
            currentMainImage = 1; // After reordering, main image is always slot 1
        }

        function reorderAllImages(selectedSlotNumber) {
            const thumbnailGrid = document.getElementById('thumbnailGrid');
            if (!thumbnailGrid) {
                console.error('Thumbnail grid not found');
                return;
            }
            
            console.log('Reordering images, selected slot:', selectedSlotNumber);
            
            // Find the selected element (either existing or new)
            let selectedElement = document.getElementById(`existingSlot${selectedSlotNumber}`) || 
                                 document.getElementById(`slot${selectedSlotNumber}`);
            
            if (!selectedElement) {
                console.error('Selected element not found for slot:', selectedSlotNumber);
                return;
            }
            
            console.log('Found selected element:', selectedElement.id);
            
            // Add fade-out effect to all images
            const allImages = thumbnailGrid.querySelectorAll('.image-slot');
            allImages.forEach(img => {
                img.style.opacity = '0.3';
                img.style.transform = 'scale(0.95)';
            });
            
            // Wait for fade-out, then reorder
            setTimeout(() => {
                // Get all image elements (both existing and new) in their current order
                const allImageElements = [];
                const existingSlots = thumbnailGrid.querySelectorAll('[id^="existingSlot"]');
                const newSlots = thumbnailGrid.querySelectorAll('[id^="slot"]:not(.d-none):not(#addMoreSlot)');
                
                // Add existing images first
                existingSlots.forEach(slot => allImageElements.push(slot));
                // Then add new upload slots
                newSlots.forEach(slot => allImageElements.push(slot));
                
                console.log('Current elements before reordering:', allImageElements.map(el => el.id));
                
                // Remove the selected element from the array and put it at the beginning
                const selectedIndex = allImageElements.indexOf(selectedElement);
                if (selectedIndex > -1) {
                    allImageElements.splice(selectedIndex, 1);
                    allImageElements.unshift(selectedElement);
                }
                
                console.log('Elements after reordering:', allImageElements.map(el => el.id));
                
                // Remove all image elements from the DOM
                allImageElements.forEach(element => element.remove());
                
                // Re-add them in the new order
                allImageElements.forEach((element, index) => {
                    const newSlotNumber = index + 1;
                    
                    // Update element ID
                    if (element.id.startsWith('existingSlot')) {
                        element.id = `existingSlot${newSlotNumber}`;
                    } else {
                        element.id = `slot${newSlotNumber}`;
                        
                        // Update input and label for new slots
                        const input = element.querySelector('input[type="file"]');
                        const label = element.querySelector('label');
                        
                        if (input) input.id = `image${newSlotNumber}`;
                        if (label) label.setAttribute('for', `image${newSlotNumber}`);
                    }
                    
                    // Update button onclick handlers
                    const starBtn = element.querySelector('.btn-success, .btn-warning');
                    const removeBtn = element.querySelector('.btn-danger');
                    
                    if (starBtn) {
                        if (element.id.startsWith('existingSlot')) {
                            starBtn.setAttribute('onclick', `setMainImage(${newSlotNumber})`);
                        } else {
                            starBtn.setAttribute('onclick', `setMainImage(${newSlotNumber})`);
                        }
                    }
                    
                    if (removeBtn) {
                        if (element.id.startsWith('existingSlot')) {
                            removeBtn.setAttribute('onclick', `removeExistingImage(${newSlotNumber})`);
                        } else {
                            removeBtn.setAttribute('onclick', `removeImage(${newSlotNumber})`);
                        }
                    }
                    
                    // Insert before the Add More button
                    const addMoreButton = thumbnailGrid.querySelector('#addMoreSlot');
                    if (addMoreButton) {
                        thumbnailGrid.insertBefore(element, addMoreButton);
                    } else {
                        thumbnailGrid.appendChild(element);
                    }
                });
                
                // Update the tracking objects to reflect new positions
                const newExistingImages = {};
                const newUploadedImages = {};
                
                // Also collect the existing image values in the new order for form submission
                const reorderedExistingImageValues = [];
                
                allImageElements.forEach((element, index) => {
                    const newSlotNumber = index + 1;
                    
                    if (element.id.startsWith('existingSlot')) {
                        // For existing images
                        const img = element.querySelector('.image-slot');
                        const hiddenInput = element.querySelector('input[name="existing_images[]"]');
                        
                        if (img && img.style.backgroundImage) {
                            const imageUrl = img.style.backgroundImage.replace(/url\(["']?(.+?)["']?\)/, '$1');
                            newExistingImages[newSlotNumber] = imageUrl;
                            newUploadedImages[newSlotNumber] = imageUrl;
                        }
                        
                        // Collect the original image path for the form
                        if (hiddenInput && hiddenInput.value) {
                            reorderedExistingImageValues.push(hiddenInput.value);
                        }
                    } else {
                        // For new uploaded images
                        const input = element.querySelector('input[type="file"]');
                        if (input && input.files && input.files[0]) {
                            // Get the image URL from uploadedImages using the old slot number
                            const oldSlotNumber = selectedSlotNumber;
                            if (uploadedImages[oldSlotNumber]) {
                                newUploadedImages[newSlotNumber] = uploadedImages[oldSlotNumber];
                            }
                        }
                    }
                });
                
                // Update global tracking objects
                existingImages = newExistingImages;
                uploadedImages = { ...newUploadedImages };
                
                // Update the form's existing_images inputs to reflect the new order
                updateExistingImagesFormInputs(reorderedExistingImageValues);
                
                // Fade-in effect and update visual indicators
                setTimeout(() => {
                    const allImagesAfter = thumbnailGrid.querySelectorAll('.image-slot');
                    allImagesAfter.forEach(img => {
                        img.style.opacity = '1';
                        img.style.transform = 'scale(1)';
                    });
                    
                    // Update visual indicators
                    updateVisualIndicators();
                }, 50);
                
            }, 200); // Wait 200ms for fade-out effect
        }

        function updateExistingImagesFormInputs(reorderedImageValues) {
            // Remove all existing hidden inputs for existing_images[]
            const form = document.querySelector('form');
            const existingInputs = form.querySelectorAll('input[name="existing_images[]"]');
            existingInputs.forEach(input => input.remove());
            
            // Add new hidden inputs in the correct order
            reorderedImageValues.forEach(imageValue => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'existing_images[]';
                hiddenInput.value = imageValue;
                form.appendChild(hiddenInput);
            });
            
            console.log('Updated form existing_images order:', reorderedImageValues);
        }

        function updateVisualIndicatorsOnly() {
            // Remove all main image indicators
            document.querySelectorAll('.image-slot').forEach(slot => {
                slot.classList.remove('border-primary');
                slot.style.borderWidth = '2px';
            });

            document.querySelectorAll('.btn-success, .btn-warning').forEach(btn => {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-success');
            });

            const selectedSlot = document.querySelector(`label[for="image${currentMainImage}"], #existingSlot${currentMainImage} .image-slot`);
            if (selectedSlot) {
                selectedSlot.classList.add('border-primary');
                selectedSlot.style.borderWidth = '3px';

                const starBtn = selectedSlot.closest('.image-upload-slot').querySelector('.btn-success, .btn-warning');
                if (starBtn) {
                    starBtn.classList.remove('btn-success');
                    starBtn.classList.add('btn-warning');
                }
            }
        }

        function updateMainPreview(imageUrl) {
            const mainPreview = document.getElementById('mainImagePreview');
            mainPreview.style.backgroundImage = `url(${imageUrl})`;
            mainPreview.style.backgroundSize = 'cover';
            mainPreview.style.backgroundPosition = 'center';
            mainPreview.innerHTML = '';
        }

        function updateVisualIndicators() {
            // Remove all primary borders and warning buttons
            document.querySelectorAll('.image-slot').forEach(slot => {
                slot.classList.remove('border-primary');
                slot.style.borderWidth = '2px';
            });

            document.querySelectorAll('.btn-success, .btn-warning').forEach(btn => {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-success');
                btn.disabled = false;
                btn.innerHTML = '<i class="material-icons" style="font-size: 14px; font-weight: bold;">star</i>';
            });

            // Set the first existing image as main (primary border and warning button)
            const firstExistingSlot = document.getElementById('existingSlot1');
            if (firstExistingSlot) {
                const imageSlot = firstExistingSlot.querySelector('.image-slot');
                const starBtn = firstExistingSlot.querySelector('.btn-success');
                
                if (imageSlot) {
                    imageSlot.classList.add('border-primary');
                    imageSlot.style.borderWidth = '3px';
                }
                
                if (starBtn) {
                    starBtn.classList.remove('btn-success');
                    starBtn.classList.add('btn-warning');
                }
            }
        }

        function showSuccessMessage(message) {
            // Create toast element if it doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '1050';
                document.body.appendChild(toastContainer);
            }
            
            const toastId = 'toast-' + Date.now();
            const toastHTML = `
                <div id="${toastId}" class="toast show" role="alert">
                    <div class="toast-header bg-success text-white">
                        <i class="material-icons me-2">check_circle</i>
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                const toast = document.getElementById(toastId);
                if (toast) toast.remove();
            }, 3000);
        }

        function showErrorMessage(message) {
            // Create toast element if it doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '1050';
                document.body.appendChild(toastContainer);
            }
            
            const toastId = 'toast-error-' + Date.now();
            const toastHTML = `
                <div id="${toastId}" class="toast show" role="alert">
                    <div class="toast-header bg-danger text-white">
                        <i class="material-icons me-2">error</i>
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            
            // Auto remove after 5 seconds (longer for errors)
            setTimeout(() => {
                const toast = document.getElementById(toastId);
                if (toast) toast.remove();
            }, 5000);
        }

        function removeImage(slotNumber) {
            delete uploadedImages[slotNumber];
            
            document.getElementById(`image${slotNumber}`).value = '';
            
            const label = document.querySelector(`label[for="image${slotNumber}"]`);
            label.style.backgroundImage = '';
            label.classList.remove('border-primary');
            label.innerHTML = `
                <div class="text-center">
                    <i class="material-icons text-muted">add_a_photo</i>
                    <p class="text-xs text-muted mb-0">Image ${slotNumber}</p>
                </div>
            `;
            
            const controls = label.parentElement.querySelector('.image-controls');
            controls.classList.add('d-none');
            
            if (currentMainImage === slotNumber) {
                const remainingImages = {...existingImages, ...uploadedImages};
                const remainingKeys = Object.keys(remainingImages);
                if (remainingKeys.length > 0) {
                    setMainImage(parseInt(remainingKeys[0]));
                } else {
                    const mainPreview = document.getElementById('mainImagePreview');
                    mainPreview.style.backgroundImage = '';
                    mainPreview.innerHTML = `
                        <div class="text-center">
                            <i class="material-icons text-muted" style="font-size: 3rem;">add_photo_alternate</i>
                            <p class="text-muted mb-0">Main Property Image</p>
                            <small class="text-muted">Click on thumbnails below to set as main image</small>
                        </div>
                    `;
                }
            }
        }

        function removeExistingImage(slotNumber) {
            if (confirm('Are you sure you want to remove this image?')) {
                delete existingImages[slotNumber];
                delete uploadedImages[slotNumber];
                
                const slotElement = document.getElementById(`existingSlot${slotNumber}`);
                if (slotElement) {
                    slotElement.remove();
                }
                
                if (currentMainImage === slotNumber) {
                    const remainingImages = {...existingImages, ...uploadedImages};
                    const remainingKeys = Object.keys(remainingImages);
                    if (remainingKeys.length > 0) {
                        setMainImage(parseInt(remainingKeys[0]));
                    } else {
                        const mainPreview = document.getElementById('mainImagePreview');
                        mainPreview.style.backgroundImage = '';
                        mainPreview.innerHTML = `
                            <div class="text-center">
                                <i class="material-icons text-muted" style="font-size: 3rem;">add_photo_alternate</i>
                                <p class="text-muted mb-0">Main Property Image</p>
                                <small class="text-muted">Click on thumbnails below to set as main image</small>
                            </div>
                        `;
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var inputs = document.querySelectorAll('.input-group-outline input, .input-group-outline textarea');
            
            inputs.forEach(function(input) {
                if (input.value && input.value.trim() !== '') {
                    input.parentElement.classList.add('is-filled');
                }
                
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('is-focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('is-focused');
                    if (this.value && this.value.trim() !== '') {
                        this.parentElement.classList.add('is-filled');
                    } else {
                        this.parentElement.classList.remove('is-filled');
                    }
                });
            });
            
            // Add form submission debug
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const formData = new FormData(form);
                    console.log('=== FORM SUBMISSION DEBUG ===');
                    console.log('Main image slot value:', document.getElementById('mainImageSlot').value);
                    console.log('Existing images:', formData.getAll('existing_images[]'));
                    console.log('New images:', formData.getAll('images[]'));
                    console.log('Current images state:', { existingImages, uploadedImages });
                    console.log('=== END DEBUG ===');
                });
            }
        });
    </script>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        
        .image-slot {
            transition: all 0.3s ease;
        }
        
        .image-slot:hover {
            border-color: #e91e63 !important;
            transform: translateY(-2px);
        }
        
        .image-upload-slot {
            position: relative;
        }

        .add-more-card {
            transition: all 0.3s ease;
        }

        .add-more-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .image-controls {
            display: flex;
            gap: 2px;
        }

        .image-controls .btn {
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
    </style>
</x-layout>
