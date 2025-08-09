<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Build base query with SAAS logic
        $baseQuery = Property::query();
        if (!$user->hasRole('Super Admin')) {
            // Regular users (dealers) see only their own properties
            $baseQuery->where('added_by', $user->id);
        }
        
        // Get real statistics from database (filtered by user if not Super Admin)
        $totalProperties = (clone $baseQuery)->count();
        $propertiesSold = (clone $baseQuery)->where('status', 'Sold')->count();
        $propertiesRented = (clone $baseQuery)->where('status', 'Rented')->count();
        $availableProperties = (clone $baseQuery)->where('status', 'Available')->count();
        $pendingProperties = (clone $baseQuery)->where('status', 'Pending')->count();
        
        // Total users (only Super Admin sees all users, dealers don't need this)
        if ($user->hasRole('Super Admin')) {
            $totalUsers = User::count();
        } else {
            $totalUsers = null; // Dealers don't need user count
        }
        
        // Calculate total property values (filtered)
        $totalPropertyValue = (clone $baseQuery)->sum('price') ?? 0;
        $soldPropertiesValue = (clone $baseQuery)->where('status', 'Sold')->sum('price') ?? 0;
        
        // Property distribution by type (filtered)
        $propertyTypes = (clone $baseQuery)
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
            
        // Properties by status (filtered)
        $propertyByStatus = (clone $baseQuery)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        // Monthly properties added (last 6 months, filtered)
        $monthlyProperties = (clone $baseQuery)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
            
        // Recent properties (last 10, filtered)
        $recentProperties = (clone $baseQuery)
            ->with('creator')
            ->latest()
            ->limit(10)
            ->get();
            
        // Top property cities (filtered)
        $topCities = (clone $baseQuery)
            ->select('city', DB::raw('count(*) as count'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
            
        // Average price by property type (filtered)
        $avgPriceByType = (clone $baseQuery)
            ->select('type', DB::raw('AVG(price) as avg_price'))
            ->whereNotNull('price')
            ->groupBy('type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->type => round($item->avg_price, 2)];
            });
            
        // Price range distribution (filtered)
        $priceRanges = [
            'Under ₹10L' => (clone $baseQuery)->where('price', '<', 1000000)->count(),
            '₹10L - ₹50L' => (clone $baseQuery)->whereBetween('price', [1000000, 5000000])->count(),
            '₹50L - ₹1Cr' => (clone $baseQuery)->whereBetween('price', [5000000, 10000000])->count(),
            '₹1Cr - ₹2Cr' => (clone $baseQuery)->whereBetween('price', [10000000, 20000000])->count(),
            'Above ₹2Cr' => (clone $baseQuery)->where('price', '>', 20000000)->count(),
        ];

        return view('dashboard.index', compact(
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
