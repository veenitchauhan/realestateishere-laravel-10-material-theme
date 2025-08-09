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
                            @can('add-property')
                            <form id="propertyForm" action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <!-- Required Fields -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group input-group-outline mb-3 @error('title') is-invalid @enderror">
                                            <label class="form-label">Property Title *</label>
                                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required autocomplete="off">
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
                                                <option value="" disabled {{ old('type') ? '' : 'selected' }}>--Select Property Type--</option>
                                                <option value="House" {{ old('type') == 'House' ? 'selected' : '' }}>House</option>
                                                <option value="Apartment" {{ old('type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                                <option value="Villa" {{ old('type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                                                <option value="Plot" {{ old('type') == 'Plot' ? 'selected' : '' }}>Plot</option>
                                                <option value="Commercial" {{ old('type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
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
                                                <option value="" disabled {{ old('status') ? '' : 'selected' }}>--Select Status--</option>
                                                <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Sold" {{ old('status') == 'Sold' ? 'selected' : '' }}>Sold</option>
                                                <option value="Rented" {{ old('status') == 'Rented' ? 'selected' : '' }}>Rented</option>
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
                                                <div id="mainImagePreview" class="border-2 border-dashed border-light rounded-3 d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa;">
                                                    <div class="text-center">
                                                        <i class="material-icons text-muted" style="font-size: 3rem;">add_photo_alternate</i>
                                                        <p class="text-muted mb-0">Main Property Image</p>
                                                        <small class="text-muted">Click on thumbnails below to set as main image</small>
                                                    </div>
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
                                                    <!-- Initial single slot + Add More button -->
                                                    <div class="col-2 mb-3" id="slot1">
                                                        <div class="image-upload-slot position-relative">
                                                            <input type="file" id="image1" name="images[]" accept="image/*" class="d-none" onchange="handleImageUpload(1, this)">
                                                            <label for="image1" class="image-slot border-2 border-dashed border-light rounded-3 d-flex align-items-center justify-content-center cursor-pointer" style="height: 120px; background-color: #f8f9fa;">
                                                                <div class="text-center">
                                                                    <i class="material-icons text-muted">add_a_photo</i>
                                                                    <p class="text-xs text-muted mb-0">Image 1</p>
                                                                </div>
                                                            </label>
                                                            <div class="image-controls position-absolute top-0 end-0 d-none" style="margin: 5px;">
                                                                <button type="button" class="btn btn-sm btn-success me-1 rounded-circle" style="width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;" onclick="setMainImage(1)" title="Set as main image">
                                                                    <i class="material-icons" style="font-size: 14px; font-weight: bold;">star</i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger rounded-circle" style="width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;" onclick="removeImage(1)" title="Remove image">
                                                                    <i class="material-icons" style="font-size: 14px; font-weight: bold;">close</i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Add More Button -->
                                                    <div class="col-2 mb-3" id="addMoreSlot">
                                                        <div class="add-more-card border-2 border-dashed border-info rounded-3 d-flex align-items-center justify-content-center cursor-pointer" style="height: 120px; background-color: #f0f8ff;" onclick="addOneMoreSlot()">
                                                            <div class="text-center">
                                                                <i class="material-icons text-info" style="font-size: 2rem;">add_circle_outline</i>
                                                                <p class="text-xs text-info mb-0 fw-bold">Add More</p>
                                                                <p class="text-xs text-muted mb-0">(11 more slots)</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- All additional slots (2-12) - initially hidden -->
                                                    @for($i = 2; $i <= 12; $i++)
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
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" rows="3" autocomplete="off">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" autocomplete="off">
                                            @error('address')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" autocomplete="off">
                                            @error('city')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="state" value="{{ old('state') }}" autocomplete="off">
                                            @error('state')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control" name="pincode" value="{{ old('pincode') }}" autocomplete="off">
                                            @error('pincode')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Price (₹)</label>
                                            <input type="number" class="form-control" name="price" value="{{ old('price') }}" step="0.01" min="0" autocomplete="off">
                                            @error('price')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Area (sq ft)</label>
                                            <input type="number" class="form-control" name="area" value="{{ old('area') }}" step="0.01" min="0" autocomplete="off">
                                            @error('area')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Bedrooms</label>
                                            <input type="number" class="form-control" name="bedrooms" value="{{ old('bedrooms') }}" min="0" autocomplete="off">
                                            @error('bedrooms')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Bathrooms</label>
                                            <input type="number" class="form-control" name="bathrooms" value="{{ old('bathrooms') }}" min="0" autocomplete="off">
                                            @error('bathrooms')
                                                <div class="text-danger text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden input to track main image -->
                                <input type="hidden" name="main_image_slot" id="mainImageSlot" value="1">
                                
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
        let currentMainImage = 1;
        let uploadedImages = {};
        let nextSlotToShow = 2; // Start from slot 2 (slot 1 is already visible)

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
                    alert('Please select a valid image file.');
                    return;
                }
                
                // Find next available slot number
                let nextSlotNumber = 2;
                while (nextSlotNumber <= 12 && uploadedImages[nextSlotNumber]) {
                    nextSlotNumber++;
                }
                
                if (nextSlotNumber > 12) {
                    alert('Maximum 12 images allowed.');
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
            
            if (remainingSlots > 0) {
                addMoreSlot.innerHTML = `
                    <div class="add-more-card border-2 border-dashed border-info rounded-3 d-flex align-items-center justify-content-center cursor-pointer" style="height: 120px; background-color: #f0f8ff;" onclick="addOneMoreSlot()">
                        <div class="text-center">
                            <i class="material-icons text-info" style="font-size: 2rem;">add_circle_outline</i>
                            <p class="text-xs text-info mb-0 fw-bold">Add More</p>
                            <p class="text-xs text-muted mb-0">(${remainingSlots} more slots)</p>
                        </div>
                    </div>
                `;
            } else {
                // Hide the add more button when all slots are visible
                addMoreSlot.style.display = 'none';
            }
        }

        function moveAddMoreButtonToEnd() {
            const addMoreSlot = document.getElementById('addMoreSlot');
            const thumbnailGrid = document.querySelector('#thumbnailGrid');
            
            // Move the "Add More" button to the end
            thumbnailGrid.appendChild(addMoreSlot);
        }

        function handleImageUpload(slotNumber, input) {
            const file = input.files[0];
            if (!file) return;

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please upload only image files (JPG, PNG, WebP)');
                input.value = '';
                return;
            }

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('Image size should be less than 5MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageUrl = e.target.result;
                uploadedImages[slotNumber] = imageUrl;

                // Update the thumbnail
                const label = document.querySelector(`label[for="image${slotNumber}"]`);
                label.style.backgroundImage = `url(${imageUrl})`;
                label.style.backgroundSize = 'cover';
                label.style.backgroundPosition = 'center';
                label.innerHTML = '';
                
                // Show control buttons
                const controls = label.parentElement.querySelector('.image-controls');
                controls.classList.remove('d-none');
                
                // If this is the first image uploaded, make it the main image
                if (Object.keys(uploadedImages).length === 1) {
                    setMainImage(slotNumber);
                }
            };
            reader.readAsDataURL(file);
        }

        function setMainImage(slotNumber) {
            const imageUrl = uploadedImages[slotNumber];
            if (!imageUrl) return;

            // If this is already the first image, no need to do anything
            if (slotNumber === 1) {
                // Just ensure visual indicators are correct, but don't show toast
                updateVisualIndicators();
                return;
            }

            // Show success message only when actually changing main image
            showSuccessMessage('Main image set successfully!');

            // Reorder images: move selected image to first position
            reorderImagesInCreateMode(slotNumber);
            
            // Update main preview with the new main image
            updateMainPreview(imageUrl);
            
            // Update visual indicators
            updateVisualIndicators();

            // Update hidden input - first slot is now main
            document.getElementById('mainImageSlot').value = 1;
            currentMainImage = 1;
        }

        function reorderImagesInCreateMode(newMainSlotNumber) {
            const thumbnailGrid = document.getElementById('thumbnailGrid');
            const selectedSlot = document.getElementById(`slot${newMainSlotNumber}`);
            const firstSlot = document.getElementById('slot1');
            
            if (!selectedSlot || !firstSlot || !thumbnailGrid) return;
            
            // Get the selected image data
            const selectedImage = uploadedImages[newMainSlotNumber];
            const selectedInput = selectedSlot.querySelector('input[type="file"]');
            const selectedFiles = selectedInput ? selectedInput.files : null;
            
            // Get the first slot image data  
            const firstImage = uploadedImages[1];
            const firstInput = firstSlot.querySelector('input[type="file"]');
            const firstFiles = firstInput ? firstInput.files : null;
            
            // Swap the images in uploadedImages object
            uploadedImages[1] = selectedImage;
            uploadedImages[newMainSlotNumber] = firstImage;
            
            // Swap the files in the inputs
            if (selectedFiles && firstInput) {
                const dt1 = new DataTransfer();
                if (selectedFiles[0]) dt1.items.add(selectedFiles[0]);
                firstInput.files = dt1.files;
            }
            
            if (firstFiles && selectedInput) {
                const dt2 = new DataTransfer();
                if (firstFiles[0]) dt2.items.add(firstFiles[0]);
                selectedInput.files = dt2.files;
            } else if (selectedInput) {
                // Clear the selected input if first slot was empty
                selectedInput.value = '';
            }
            
            // Update the visual display of both slots
            updateSlotDisplay(1, selectedImage);
            updateSlotDisplay(newMainSlotNumber, firstImage);
        }

        function updateSlotDisplay(slotNumber, imageUrl) {
            const slot = document.getElementById(`slot${slotNumber}`);
            if (!slot) return;
            
            const imageSlot = slot.querySelector('.image-slot');
            const removeBtn = slot.querySelector('.btn-danger');
            
            if (imageUrl && imageSlot) {
                // Show image
                imageSlot.style.backgroundImage = `url(${imageUrl})`;
                imageSlot.style.backgroundSize = 'cover';
                imageSlot.style.backgroundPosition = 'center';
                imageSlot.innerHTML = '';
                if (removeBtn) removeBtn.style.display = 'block';
            } else if (imageSlot) {
                // Clear image
                imageSlot.style.backgroundImage = 'none';
                imageSlot.innerHTML = `
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center">
                            <i class="material-icons text-muted mb-2" style="font-size: 2rem;">add_photo_alternate</i>
                            <p class="text-xs text-muted mb-0">Click to upload</p>
                        </div>
                    </div>
                `;
                if (removeBtn) removeBtn.style.display = 'none';
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
            // Remove all main image indicators
            document.querySelectorAll('.image-slot').forEach(slot => {
                slot.classList.remove('border-primary');
                slot.style.borderWidth = '2px';
            });

            document.querySelectorAll('.btn-success, .btn-warning').forEach(btn => {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-success');
                if (btn.querySelector('i')) {
                    btn.querySelector('i').textContent = 'star';
                }
            });

            // Set first slot as main (it now has the main image)
            const firstSlot = document.getElementById('slot1');
            if (firstSlot && uploadedImages[1]) {
                const imageSlot = firstSlot.querySelector('.image-slot');
                const starBtn = firstSlot.querySelector('.btn-success');
                
                if (imageSlot) {
                    imageSlot.classList.add('border-primary');
                    imageSlot.style.borderWidth = '3px';
                }
                
                if (starBtn) {
                    starBtn.classList.remove('btn-success');
                    starBtn.classList.add('btn-warning');
                    if (starBtn.querySelector('i')) {
                        starBtn.querySelector('i').textContent = 'star';
                    }
                }
            }
        }

        function showSuccessMessage(message) {
            // Create toast element if it doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
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

        function removeImage(slotNumber) {
            // Clear the uploaded image
            delete uploadedImages[slotNumber];
            
            // Reset the input
            document.getElementById(`image${slotNumber}`).value = '';
            
            // Reset the thumbnail
            const label = document.querySelector(`label[for="image${slotNumber}"]`);
            label.style.backgroundImage = '';
            label.classList.remove('border-primary');
            label.innerHTML = `
                <div class="text-center">
                    <i class="material-icons text-muted">add_a_photo</i>
                    <p class="text-xs text-muted mb-0">Image ${slotNumber}</p>
                </div>
            `;
            
            // Hide control buttons
            const controls = label.parentElement.querySelector('.image-controls');
            controls.classList.add('d-none');

            // Reset star button
            const starBtn = controls.querySelector('.btn-success, .btn-warning');
            starBtn.classList.remove('btn-warning');
            starBtn.classList.add('btn-success');
            starBtn.querySelector('i').textContent = 'star';
            
            // If this was the main image, update main preview
            if (currentMainImage === slotNumber) {
                const remainingImages = Object.keys(uploadedImages);
                if (remainingImages.length > 0) {
                    // Set first available image as main
                    setMainImage(parseInt(remainingImages[0]));
                } else {
                    // No images left, reset main preview
                    const mainPreview = document.getElementById('mainImagePreview');
                    mainPreview.style.backgroundImage = '';
                    mainPreview.innerHTML = `
                        <div class="text-center">
                            <i class="material-icons text-muted" style="font-size: 3rem;">add_photo_alternate</i>
                            <p class="text-muted mb-0">Main Property Image</p>
                            <small class="text-muted">Click on thumbnails below to set as main image</small>
                        </div>
                    `;
                    currentMainImage = 1;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Material Dashboard form elements for outline inputs only
            var inputs = document.querySelectorAll('.input-group-outline input, .input-group-outline textarea');
            
            // Handle inputs and textareas with outline styling
            inputs.forEach(function(input) {
                // Check if field has value on load
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
            
            // Static inputs (like selects) don't need special handling
            // They work with default browser styling
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
