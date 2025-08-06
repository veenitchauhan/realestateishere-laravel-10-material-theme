@props(['titlePage'])

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
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {{-- <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div> --}}
                <div class="ms-3 font-weight-bold d-none d-lg-block">
                    {{ auth()->user()->name }}
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav  justify-content-end">
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
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-2 d-flex align-items-center border-radius-md bg-light"
                        id="userDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-2 text-dark"></i>
                        <span class="text-dark font-weight-bold d-none d-md-inline">{{ auth()->user()->name }}</span>
                        <i class="fa fa-chevron-down text-xs ms-2 text-dark"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4 border-radius-lg shadow-lg"
                        aria-labelledby="userDropdownButton" style="min-width: 160px;">
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
