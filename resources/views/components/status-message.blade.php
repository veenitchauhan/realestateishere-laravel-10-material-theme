<div class="col-11 mx-auto">
    @if (Session::has('success'))
        <div class="alert text-white alert-success py-1">
            {!! Session::get('success') !!}
        </div>
    @endif

    @if (Session::has('warning'))
        <div class="alert text-white alert-warning py-1">
            {{ Session::get('warning') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert text-white alert-danger py-1">
            {{ Session::get('error') }}
        </div>
    @endif

    @if (Session::has('info'))
        <div class="alert text-white alert-info py-1">
            {{ Session::get('info') }}
        </div>
    @endif
</div>
