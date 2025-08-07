<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="reports"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Reports & Analytics"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">home</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Properties</p>
                                <h4 class="mb-0">{{ number_format($totalProperties) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0">
                                <span class="text-info text-sm font-weight-bolder">{{ number_format($availableProperties) }} available</span> 
                                · {{ number_format($pendingProperties) }} pending
                            </p>
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
                                <h4 class="mb-0">{{ number_format($propertiesSold) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">{{ $totalProperties > 0 ? round(($propertiesSold / $totalProperties) * 100, 1) : 0 }}% </span>
                                of total properties
                            </p>
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
                                <p class="text-sm mb-0 text-capitalize">Total Users</p>
                                <h4 class="mb-0">{{ number_format($totalUsers) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0">
                                <span class="text-info text-sm font-weight-bolder">{{ number_format($propertiesRented) }} rented</span> 
                                properties
                            </p>
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
                                <p class="text-sm mb-0 text-capitalize">Total Portfolio Value</p>
                                <h4 class="mb-0">₹{{ number_format($totalPropertyValue / 10000000, 1) }}Cr</h4>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">₹{{ number_format($soldPropertiesValue / 10000000, 1) }}Cr</span> 
                                in sales
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Property Distribution Charts -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">📊 Property Types Distribution</h6>
                        </div>
                        <div class="card-body">
                            @if(count($propertyTypes) > 0)
                                @foreach($propertyTypes as $type => $count)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-gradient-primary me-2">{{ $type }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="text-sm me-2">{{ $count }} properties</span>
                                        <span class="badge bg-gradient-secondary">{{ $totalProperties > 0 ? round(($count / $totalProperties) * 100, 1) : 0 }}%</span>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center">No properties data available</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">📈 Property Status Overview</h6>
                        </div>
                        <div class="card-body">
                            @if(count($propertyByStatus) > 0)
                                @foreach($propertyByStatus as $status => $count)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge 
                                            @if($status === 'Available') bg-gradient-success
                                            @elseif($status === 'Sold') bg-gradient-primary  
                                            @elseif($status === 'Rented') bg-gradient-info
                                            @else bg-gradient-warning
                                            @endif me-2">{{ $status }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="text-sm me-2">{{ $count }} properties</span>
                                        <span class="badge bg-gradient-secondary">{{ $totalProperties > 0 ? round(($count / $totalProperties) * 100, 1) : 0 }}%</span>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center">No status data available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Price Analysis -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">💰 Average Price by Type</h6>
                        </div>
                        <div class="card-body">
                            @if(count($avgPriceByType) > 0)
                                @foreach($avgPriceByType as $type => $avgPrice)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-sm font-weight-bold">{{ $type }}</span>
                                    <span class="badge bg-gradient-success">₹{{ number_format($avgPrice / 100000, 1) }}L</span>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center">No pricing data available</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">🏷️ Price Range Distribution</h6>
                        </div>
                        <div class="card-body">
                            @foreach($priceRanges as $range => $count)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm">{{ $range }}</span>
                                <div class="d-flex align-items-center">
                                    <span class="text-sm me-2">{{ $count }}</span>
                                    <span class="badge bg-gradient-info">{{ $totalProperties > 0 ? round(($count / $totalProperties) * 100, 1) : 0 }}%</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Cities and Recent Properties -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">🏙️ Top Cities</h6>
                        </div>
                        <div class="card-body">
                            @if($topCities->count() > 0)
                                @foreach($topCities as $city)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-sm font-weight-bold">{{ $city->city }}</span>
                                    <span class="badge bg-gradient-primary">{{ $city->count }} properties</span>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center">No city data available</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">🕒 Recent Properties</h6>
                        </div>
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            @if($recentProperties->count() > 0)
                                @foreach($recentProperties as $property)
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <div>
                                        <h6 class="text-sm mb-0">{{ $property->title }}</h6>
                                        <p class="text-xs text-muted mb-0">{{ $property->city }} • {{ $property->type }}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-gradient-{{ $property->status === 'Available' ? 'success' : ($property->status === 'Sold' ? 'primary' : 'info') }}">
                                            {{ $property->status }}
                                        </span>
                                        <p class="text-xs text-muted mb-0">{{ $property->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center">No recent properties</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
