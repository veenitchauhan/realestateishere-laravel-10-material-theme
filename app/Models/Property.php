<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'city',
        'state',
        'pincode',
        'type',
        'bedrooms',
        'bathrooms',
        'area',
        'price',
        'status',
        'added_by',
        'images',
        'features'
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'price' => 'decimal:2',
        'area' => 'decimal:2'
    ];

    // Relationship with User (who created the property)
    public function creator()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    // Format price in INR
    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 0, '.', ',');
    }

    // Get property type badge class
    public function getTypeBadgeClassAttribute()
    {
        return match($this->type) {
            'House' => 'bg-gradient-primary',
            'Apartment' => 'bg-gradient-info',
            'Villa' => 'bg-gradient-success',
            'Commercial' => 'bg-gradient-warning',
            'Plot' => 'bg-gradient-secondary',
            default => 'bg-gradient-dark'
        };
    }

    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'Available' => 'bg-gradient-success',
            'Pending' => 'bg-gradient-warning',
            'Sold' => 'bg-gradient-danger',
            'Rented' => 'bg-gradient-info',
            default => 'bg-gradient-secondary'
        };
    }

    // Get main image URL
    public function getMainImageAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            return asset('storage/' . $this->images[0]);
        }
        return null;
    }

    // Get all image URLs
    public function getImageUrlsAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            return array_map(function($image) {
                return asset('storage/' . $image);
            }, $this->images);
        }
        return [];
    }
}
