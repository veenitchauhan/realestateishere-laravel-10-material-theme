@props(['titlePage'])

<style>
.dropdown-arrow {
    position: absolute;
    top: -8px;
    right: 30px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid #ffffff;
    z-index: 1001;
}
.dropdown-arrow::before {
    content: '';
    position: absolute;
    top: 1px;
    left: -9px;
    width: 0;
    height: 0;
    border-left: 9px solid transparent;
    border-right: 9px solid transparent;
    border-bottom: 9px solid rgba(0,0,0,0.15);
}
</style>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $titlePage }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $titlePage }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            {{-- Impersonation Notice - Compact Version --}}
            @if(session()->has('impersonate_original_id'))
                <div class="me-3">
                    <a href="{{ route('stop-impersonating') }}" class="btn btn-sm bg-gradient-warning px-2 py-1" 
                       style="font-size: 0.7rem; line-height: 1.2;">
                        <i class="material-icons text-white me-1" style="font-size: 0.9rem;">warning</i>
                        <span class="text-white font-weight-bold">Stop Impersonating</span>
                    </a>
                </div>
            @endif
            
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {{-- <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div> --}}
            </div>

            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown d-flex align-items-center">
                    <a href="javascript:;" class="btn {{ session()->has('impersonate_original_id') ? 'btn-warning' : 'btn-light' }} btn-sm d-flex align-items-center"
                        id="userDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons {{ session()->has('impersonate_original_id') ? 'text-white' : 'text-dark' }}" style="font-size: 18px;">person</i>
                        <span class="{{ session()->has('impersonate_original_id') ? 'text-white' : 'text-dark' }} font-weight-bold ms-2 d-none d-lg-inline">
                            {{ auth()->user()->name }}
                            @if(auth()->user()->roles->count() > 0)
                                <small>({{ auth()->user()->roles->first()->name }})</small>
                            @endif
                        </span>
                        @if(session()->has('impersonate_original_id'))
                            <span class="text-white font-weight-bold ms-2 d-lg-none">Impersonating</span>
                        @endif
                        <i class="material-icons {{ session()->has('impersonate_original_id') ? 'text-white' : 'text-dark' }} ms-1" style="font-size: 16px;">keyboard_arrow_down</i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4 border-radius-lg shadow-lg"
                        aria-labelledby="userDropdownButton" style="min-width: 200px;">
                        <!-- Dropdown Arrow -->
                        <div class="dropdown-arrow"></div>
                        @if(session()->has('impersonate_original_id'))
                            <li class="mb-2">
                                <div class="dropdown-item-text border-radius-md py-2 text-sm d-flex align-items-center bg-gradient-warning">
                                    <i class="material-icons text-white me-2" style="font-size: 1rem;">warning</i>
                                    <span class="text-white font-weight-bold text-xs">Impersonating {{ auth()->user()->name }}</span>
                                </div>
                            </li>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md py-2 text-sm d-flex align-items-center bg-gradient-warning"
                                    href="{{ route('stop-impersonating') }}">
                                    <i class="material-icons text-white me-2" style="font-size: 1rem;">logout</i>
                                    <span class="text-white font-weight-bold">Stop Impersonating</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li class="mb-1">
                            <a class="dropdown-item border-radius-md py-2 text-sm d-flex align-items-center"
                                href="{{ route('user-profile') }}">
                                <i class="ni ni-single-02 me-2 text-dark opacity-6"></i>
                                <span class="text-dark font-weight-normal">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md py-2 text-sm" href="javascript:;"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="ni ni-user-run me-2 text-dark opacity-6"></i>
                                <span class="text-dark font-weight-normal">Log out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
