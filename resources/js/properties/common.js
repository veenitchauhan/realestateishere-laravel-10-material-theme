/**
 * Common Property Image Gallery Functionality
 * Shared between create and edit property pages
 */

// Global state - make sure these are on window for cross-module access
window.currentMainImage = 1;
window.uploadedImages = {};
window.nextSlotToShow = 2;

/**
 * Common utility functions
 */
function updateAddMoreButton() {
    const remainingSlots = 12 - (window.nextSlotToShow - 1);
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
        showErrorMessage('Please upload only image files (JPG, PNG, WebP)');
        input.value = '';
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        showErrorMessage('Image size should be less than 5MB');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const imageUrl = e.target.result;
        window.uploadedImages[slotNumber] = imageUrl;

        const label = document.querySelector(`label[for="image${slotNumber}"]`);
        label.style.backgroundImage = `url(${imageUrl})`;
        label.style.backgroundSize = 'cover';
        label.style.backgroundPosition = 'center';
        label.innerHTML = '';
        
        const controls = label.parentElement.querySelector('.image-controls');
        controls.classList.remove('d-none');
        
        // Auto-set as main image if it's the first one
        if (Object.keys(window.uploadedImages).length === 1) {
            setMainImage(slotNumber);
        }
    };
    reader.readAsDataURL(file);
}

function updateMainPreview(imageUrl) {
    const mainPreview = document.getElementById('mainImagePreview');
    if (mainPreview) {
        mainPreview.style.backgroundImage = `url(${imageUrl})`;
        mainPreview.style.backgroundSize = 'cover';
        mainPreview.style.backgroundPosition = 'center';
        mainPreview.innerHTML = '';
    }
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
        const icon = btn.querySelector('i');
        if (icon) icon.textContent = 'star';
    });

    // Set the main image visual indicators
    const mainSlot = document.getElementById('slot1') || document.getElementById('existingSlot1');
    if (mainSlot && (window.uploadedImages[1] || (window.existingImages && window.existingImages[1]))) {
        const imageSlot = mainSlot.querySelector('.image-slot');
        const starBtn = mainSlot.querySelector('.btn-success');
        
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

function initializeMaterialInputs() {
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
}

function addFormSubmissionDebug() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const formData = new FormData(form);
            console.log('=== FORM SUBMISSION DEBUG ===');
            console.log('Main image slot value:', document.getElementById('mainImageSlot')?.value || 'N/A');
            console.log('Existing images:', formData.getAll('existing_images[]'));
            console.log('New images:', formData.getAll('images[]'));
            console.log('Current images state:', { uploadedImages: window.uploadedImages, existingImages: window.existingImages });
            console.log('=== END DEBUG ===');
        });
    }
}

// Initialize common functionality when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeMaterialInputs();
    addFormSubmissionDebug();
});

// Make common functions globally available for onclick handlers
window.updateAddMoreButton = updateAddMoreButton;
window.moveAddMoreButtonToEnd = moveAddMoreButtonToEnd;
window.handleImageUpload = handleImageUpload;
window.updateMainPreview = updateMainPreview;
window.updateVisualIndicators = updateVisualIndicators;
window.showSuccessMessage = showSuccessMessage;
window.showErrorMessage = showErrorMessage;
