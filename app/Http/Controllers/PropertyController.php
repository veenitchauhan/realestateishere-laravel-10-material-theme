<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('show-property');
        
        $properties = Property::with('creator')->latest()->paginate(5);
        
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('add-property');
        
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('add-property');

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'pincode' => 'required|max:10',
            'type' => 'required|in:House,Apartment,Villa,Plot,Commercial',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Pending,Sold,Rented',
            'features' => 'nullable|array',
        ]);

        $validated['added_by'] = auth()->id();

        Property::create($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $this->authorize('show-property');
        
        // Load the user relationship
        $property->load('creator');
        
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $this->authorize('edit-property');
        
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $this->authorize('edit-property');

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'pincode' => 'required|max:10',
            'type' => 'required|in:House,Apartment,Villa,Plot,Commercial',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Pending,Sold,Rented',
            'features' => 'nullable|array',
        ]);

        $property->update($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $this->authorize('delete-property');
        
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }
}
