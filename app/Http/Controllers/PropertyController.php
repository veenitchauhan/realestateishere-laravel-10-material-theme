<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        
        $user = auth()->user();
        
        // Super Admin can see all properties
        if ($user->hasRole('Super Admin')) {
            $properties = Property::with('creator')->latest()->paginate(10);
        } else {
            // Regular users can only see their own properties
            $properties = Property::with('creator')
                ->where('added_by', $user->id)
                ->latest()
                ->paginate(10);
        }
        
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
            'type' => 'required|in:House,Apartment,Villa,Plot,Commercial',
            'status' => 'required|in:Available,Pending,Sold,Rented',
            'description' => 'nullable|string',
            'address' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'pincode' => 'nullable|max:10',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'images' => 'nullable|array|max:12',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max per image
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image) {
                    // Create unique filename
                    $filename = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    
                    // Store in public/storage/properties folder
                    $path = $image->storeAs('properties', $filename, 'public');
                    $imagePaths[] = $path;
                }
            }
        }

        $validated['added_by'] = auth()->id();
        $validated['images'] = !empty($imagePaths) ? json_encode($imagePaths) : null;

        Property::create($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $this->authorize('view', $property);
        
        // Load the user relationship
        $property->load('creator');
        
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'type' => 'required|in:House,Apartment,Villa,Plot,Commercial',
            'status' => 'required|in:Available,Pending,Sold,Rented',
            'description' => 'nullable|string',
            'address' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'pincode' => 'nullable|max:10',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'images' => 'nullable|array|max:12',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max per image
            'existing_images' => 'nullable|array',
        ]);

        // Handle image updates
        $imagePaths = [];
        
        // Keep existing images that weren't removed (they should already be in the correct order from frontend)
        if ($request->has('existing_images') && is_array($request->existing_images)) {
            foreach ($request->existing_images as $existingImage) {
                if (!empty($existingImage)) {
                    // Handle both full URLs and relative paths
                    if (strpos($existingImage, 'storage/') !== false) {
                        $imagePath = str_replace(['storage/', asset('storage/')], '', $existingImage);
                        $imagePath = ltrim($imagePath, '/');
                        $imagePaths[] = $imagePath;
                    } else {
                        $imagePaths[] = $existingImage;
                    }
                }
            }
        }
        
        \Log::info('Processing existing images: ' . json_encode($request->existing_images));
        \Log::info('Processed existing image paths: ' . json_encode($imagePaths));
        
        // Add new uploaded images (these will come after existing images)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image) {
                    // Create unique filename
                    $filename = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    
                    // Store in public/storage/properties folder
                    $path = $image->storeAs('properties', $filename, 'public');
                    $imagePaths[] = $path;
                }
            }
        }

        // Delete old images that are no longer used
        $oldImages = $property->images ?? [];
        $newImagePaths = array_map(function($path) {
            return str_replace('storage/', '', parse_url($path, PHP_URL_PATH));
        }, $imagePaths);
        
        if (is_array($oldImages) && !empty($oldImages)) {
            foreach ($oldImages as $oldImage) {
                if (!in_array($oldImage, $newImagePaths)) {
                    \Storage::disk('public')->delete($oldImage);
                }
            }
        }

        // Log the final image order (frontend should have already ordered them correctly)
        \Log::info('Final image paths order: ' . json_encode($imagePaths));
        \Log::info('Main image slot requested: ' . $request->input('main_image_slot', 1));

        $validated['images'] = !empty($imagePaths) ? $imagePaths : null;

        $property->update($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        
        // Delete associated images
        if ($property->images) {
            foreach ($property->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property and associated images deleted successfully!');
    }
}
