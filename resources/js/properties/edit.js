/**
 * Property Edit Page JavaScript
 * Edit-specific functionality for property image gallery
 * Depends on: common.js
 */

let existingImages = {};

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
                starBtn.setAttribute('onclick', `setMainImage(${newSlotNumber})`);
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

// Make functions globally available for onclick handlers
window.setMainImage = setMainImage;
window.removeImage = removeImage;
window.removeExistingImage = removeExistingImage;
window.addOneMoreSlot = addOneMoreSlot;
window.existingImages = existingImages;
