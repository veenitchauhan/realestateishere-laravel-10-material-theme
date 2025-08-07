<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="reports"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Reports"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">home</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Properties</p>
                                <h4 class="mb-0">147</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+12% </span>from last month</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">trending_up</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Properties Sold</p>
                                <h4 class="mb-0">23</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+8% </span>from last month</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">people</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Active Clients</p>
                                <h4 class="mb-0">89</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+15% </span>from last month</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">attach_money</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Revenue</p>
                                <h4 class="mb-0">$2.4M</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+22% </span>from last month</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">📊 System Reports & Analytics</h6>
                                    <p class="text-sm mb-0">View detailed reports and analytics</p>
                                </div>
                                @can('export-data')
                                <div>
                                    <button class="btn bg-gradient-primary btn-sm">
                                        <i class="material-icons text-sm">download</i> Export Data
                                    </button>
                                </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            @can('view-reports')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-gradient-primary">
                                        <div class="card-body text-center text-white p-4">
                                            <i class="material-icons mb-3 text-white" style="font-size: 3rem;">bar_chart</i>
                                            <h6 class="text-white font-weight-bold mb-2">Sales Report</h6>
                                            <p class="text-white opacity-8 mb-0">Monthly sales analytics</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card bg-gradient-info">
                                        <div class="card-body text-center text-white p-4">
                                            <i class="material-icons mb-3 text-white" style="font-size: 3rem;">pie_chart</i>
                                            <h6 class="text-white font-weight-bold mb-2">Property Types</h6>
                                            <p class="text-white opacity-8 mb-0">Distribution by type</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card bg-gradient-success">
                                        <div class="card-body text-center text-white p-4">
                                            <i class="material-icons mb-3 text-white" style="font-size: 3rem;">timeline</i>
                                            <h6 class="text-white font-weight-bold mb-2">Performance</h6>
                                            <p class="text-white opacity-8 mb-0">Agent performance metrics</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <strong>📈 Analytics Dashboard</strong>
                                        <p class="mb-0 mt-2">This is a demo reports page. In a real application, this would show interactive charts, graphs, and detailed analytics about your real estate business performance, sales trends, and market insights.</p>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="material-icons text-danger" style="font-size: 3rem;">block</i>
                                <h6 class="text-danger">Access Denied</h6>
                                <p class="text-sm text-secondary">You don't have permission to view reports</p>
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
</x-layout>
