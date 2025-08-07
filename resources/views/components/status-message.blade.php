<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    @if (Session::has('success'))
        <div class="toast align-items-center text-white bg-success border-0 fade" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000" style="display: none;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center py-3 px-3">
                    <i class="material-icons me-2">check_circle</i>
                    <span>{!! Session::get('success') !!}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (Session::has('warning'))
        <div class="toast align-items-center text-white bg-warning border-0 fade" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000" style="display: none;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center py-3 px-3">
                    <i class="material-icons me-2">warning</i>
                    <span>{{ Session::get('warning') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="toast align-items-center text-white bg-danger border-0 fade" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000" style="display: none;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center py-3 px-3">
                    <i class="material-icons me-2">error</i>
                    <span>{{ Session::get('error') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (Session::has('info'))
        <div class="toast align-items-center text-white bg-info border-0 fade" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000" style="display: none;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center py-3 px-3">
                    <i class="material-icons me-2">info</i>
                    <span>{{ Session::get('info') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize and show all toasts
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    toastElList.forEach(function(toastEl) {
        // Make the toast visible first
        toastEl.style.display = 'block';
        
        // Initialize Bootstrap toast
        var toast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 3000
        });
        
        // Show the toast
        toast.show();
        
        // Clean up after toast is hidden (but don't remove from DOM)
        toastEl.addEventListener('hidden.bs.toast', function() {
            // Just hide it, don't remove from DOM
            toastEl.style.display = 'none';
        });
    });
});
</script>
