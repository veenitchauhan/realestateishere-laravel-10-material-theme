<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-reports');
    }

    public function index()
    {
        // Get real statistics from database
        $totalProperties = Property::count();
        $propertiesSold = Property::where('status', 'Sold')->count();
        $propertiesRented = Property::where('status', 'Rented')->count();
        $availableProperties = Property::where('status', 'Available')->count();
        $pendingProperties = Property::where('status', 'Pending')->count();
        
        // Total users (clients)
        $totalUsers = User::count();
        
        // Calculate total property values
        $totalPropertyValue = Property::sum('price');
        $soldPropertiesValue = Property::where('status', 'Sold')->sum('price');
        
        // Property distribution by type
        $propertyTypes = Property::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
            
        // Properties by status
        $propertyByStatus = Property::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        // Monthly properties added (last 6 months)
        $monthlyProperties = Property::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
            
        // Recent properties (last 10)
        $recentProperties = Property::with('creator')
            ->latest()
            ->limit(10)
            ->get();
            
        // Top property cities
        $topCities = Property::select('city', DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
            
        // Average price by property type
        $avgPriceByType = Property::select('type', DB::raw('AVG(price) as avg_price'))
            ->groupBy('type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->type => round($item->avg_price, 2)];
            });
            
        // Price range distribution
        $priceRanges = [
            'Under ₹10L' => Property::where('price', '<', 1000000)->count(),
            '₹10L - ₹50L' => Property::whereBetween('price', [1000000, 5000000])->count(),
            '₹50L - ₹1Cr' => Property::whereBetween('price', [5000000, 10000000])->count(),
            '₹1Cr - ₹2Cr' => Property::whereBetween('price', [10000000, 20000000])->count(),
            'Above ₹2Cr' => Property::where('price', '>', 20000000)->count(),
        ];

        return view('reports.index', compact(
            'totalProperties',
            'propertiesSold', 
            'propertiesRented',
            'availableProperties',
            'pendingProperties',
            'totalUsers',
            'totalPropertyValue',
            'soldPropertiesValue',
            'propertyTypes',
            'propertyByStatus',
            'monthlyProperties',
            'recentProperties',
            'topCities',
            'avgPriceByType',
            'priceRanges'
        ));
    }
}
