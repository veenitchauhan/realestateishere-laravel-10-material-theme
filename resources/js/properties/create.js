/**
 * Property Create Page JavaScript
 * Create-specific functionality for property image gallery
 * Depends on: common.js
 */

// Import common functionality
import './common.js';

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
        let nextSlotNumber = 2;
        while (nextSlotNumber <= 12 && window.uploadedImages[nextSlotNumber]) {
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
            window.nextSlotToShow = nextSlotNumber + 1;
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
    const imageUrl = window.uploadedImages[slotNumber];
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
    const mainImageSlot = document.getElementById('mainImageSlot');
    if (mainImageSlot) {
        mainImageSlot.value = 1;
    }
    window.currentMainImage = 1;
}

function reorderImagesInCreateMode(newMainSlotNumber) {
    const thumbnailGrid = document.getElementById('thumbnailGrid');
    const selectedSlot = document.getElementById(`slot${newMainSlotNumber}`);
    const firstSlot = document.getElementById('slot1');
    
    if (!selectedSlot || !firstSlot || !thumbnailGrid) return;
    
    // Get the selected image data
    const selectedImage = window.uploadedImages[newMainSlotNumber];
    const selectedInput = selectedSlot.querySelector('input[type="file"]');
    const selectedFiles = selectedInput ? selectedInput.files : null;
    
    // Get the first slot image data  
    const firstImage = window.uploadedImages[1];
    const firstInput = firstSlot.querySelector('input[type="file"]');
    const firstFiles = firstInput ? firstInput.files : null;
    
    // Swap the images in uploadedImages object
    window.uploadedImages[1] = selectedImage;
    window.uploadedImages[newMainSlotNumber] = firstImage;
    
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
    const controls = slot.querySelector('.image-controls');
    
    if (imageUrl && imageSlot) {
        // Show image
        imageSlot.style.backgroundImage = `url(${imageUrl})`;
        imageSlot.style.backgroundSize = 'cover';
        imageSlot.style.backgroundPosition = 'center';
        imageSlot.innerHTML = '';
        if (controls) controls.classList.remove('d-none');
    } else if (imageSlot) {
        // Clear image
        imageSlot.style.backgroundImage = 'none';
        imageSlot.innerHTML = `
            <div class="text-center">
                <i class="material-icons text-muted">add_a_photo</i>
                <p class="text-xs text-muted mb-0">Image ${slotNumber}</p>
            </div>
        `;
        if (controls) controls.classList.add('d-none');
    }
}

function removeImage(slotNumber) {
    // Clear the uploaded image
    delete window.uploadedImages[slotNumber];
    
    // Reset the input
    const input = document.getElementById(`image${slotNumber}`);
    if (input) input.value = '';
    
    // Reset the thumbnail
    const label = document.querySelector(`label[for="image${slotNumber}"]`);
    if (label) {
        label.style.backgroundImage = '';
        label.classList.remove('border-primary');
        label.innerHTML = `
            <div class="text-center">
                <i class="material-icons text-muted">add_a_photo</i>
                <p class="text-xs text-muted mb-0">Image ${slotNumber}</p>
            </div>
        `;
    }
    
    // Hide control buttons
    const controls = label?.parentElement.querySelector('.image-controls');
    if (controls) controls.classList.add('d-none');
    
    // If this was the main image, update main preview
    if (window.currentMainImage === slotNumber) {
        const remainingImages = Object.keys(window.uploadedImages);
        if (remainingImages.length > 0) {
            // Set first available image as main
            setMainImage(parseInt(remainingImages[0]));
        } else {
            // No images left, reset main preview
            const mainPreview = document.getElementById('mainImagePreview');
            if (mainPreview) {
                mainPreview.style.backgroundImage = '';
                mainPreview.innerHTML = `
                    <div class="text-center">
                        <i class="material-icons text-muted" style="font-size: 3rem;">add_photo_alternate</i>
                        <p class="text-muted mb-0">Main Property Image</p>
                        <small class="text-muted">Click on thumbnails below to set as main image</small>
                    </div>
                `;
            }
            window.currentMainImage = 1;
        }
    }
}

// Initialize create page specific settings
window.nextSlotToShow = 2; // Start from slot 2 (slot 1 is already visible)

// Make functions globally available for onclick handlers
window.setMainImage = setMainImage;
window.removeImage = removeImage;
window.addOneMoreSlot = addOneMoreSlot;
