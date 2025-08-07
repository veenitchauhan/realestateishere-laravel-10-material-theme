<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🧹 Cleaning existing properties...');
        
        // Truncate properties table
        Property::truncate();

        $this->command->info('🏠 Creating sample properties...');

        // Get a user to assign as property creator (preferably super admin)
        $superAdmin = User::where('email', 'superadmin@realestateishere.com')->first();
        $userId = $superAdmin ? $superAdmin->id : User::first()->id;

        $properties = [
            [
                'title' => 'Luxury Villa in Bandra',
                'description' => 'Stunning 4BHK villa with sea view, private garden, and modern amenities. Located in the heart of Bandra West.',
                'address' => '123 Hill Road',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400050',
                'type' => 'Villa',
                'bedrooms' => 4,
                'bathrooms' => 5,
                'area' => 3500.00,
                'price' => 85000000.00, // 8.5 Crore
                'status' => 'Available',
                'features' => ['Sea View', 'Swimming Pool', 'Gym', 'Security', 'Parking', 'Garden'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Modern Apartment in Gurgaon',
                'description' => '3BHK apartment in premium society with all modern facilities. Great connectivity to Delhi and Noida.',
                'address' => '456 Cyber City',
                'city' => 'Gurgaon',
                'state' => 'Haryana',
                'pincode' => '122001',
                'type' => 'Apartment',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'area' => 1800.00,
                'price' => 12500000.00, // 1.25 Crore
                'status' => 'Available',
                'features' => ['Elevator', 'Security', 'Parking', 'Power Backup', 'Park'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Family House in Pune',
                'description' => 'Spacious 3BHK independent house with terrace garden. Perfect for families looking for peaceful environment.',
                'address' => '789 FC Road',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'pincode' => '411005',
                'type' => 'House',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 2200.00,
                'price' => 9800000.00, // 98 Lakhs
                'status' => 'Sold',
                'features' => ['Terrace', 'Garden', 'Parking', 'Independent'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Commercial Plot in Bangalore',
                'description' => 'Prime commercial plot suitable for office complex or retail development. Excellent location with high footfall.',
                'address' => '321 MG Road',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'pincode' => '560001',
                'type' => 'Plot',
                'bedrooms' => null,
                'bathrooms' => null,
                'area' => 5000.00,
                'price' => 35000000.00, // 3.5 Crore
                'status' => 'Available',
                'features' => ['Commercial', 'Main Road', 'Metro Access', 'High Footfall'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Studio Apartment in Chennai',
                'description' => 'Compact yet comfortable studio apartment perfect for working professionals. Fully furnished with modern amenities.',
                'address' => '654 Anna Nagar',
                'city' => 'Chennai',
                'state' => 'Tamil Nadu',
                'pincode' => '600040',
                'type' => 'Apartment',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'area' => 650.00,
                'price' => 4500000.00, // 45 Lakhs
                'status' => 'Rented',
                'features' => ['Furnished', 'AC', 'WiFi', 'Security', 'Metro Access'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Penthouse in Delhi',
                'description' => 'Luxurious penthouse with panoramic city views. Features include private terrace, jacuzzi, and premium finishes.',
                'address' => '987 Connaught Place',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110001',
                'type' => 'Apartment',
                'bedrooms' => 4,
                'bathrooms' => 4,
                'area' => 4200.00,
                'price' => 125000000.00, // 12.5 Crore
                'status' => 'Pending',
                'features' => ['Penthouse', 'City View', 'Jacuzzi', 'Terrace', 'Premium Finishes', 'Elevator'],
                'added_by' => $userId,
            ],
            // Additional properties for better pagination demo
            [
                'title' => 'Sea-facing Apartment in Marine Drive',
                'description' => '2BHK apartment with stunning sea views and premium amenities in South Mumbai.',
                'address' => '42 Marine Drive',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400002',
                'type' => 'Apartment',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'area' => 1200.00,
                'price' => 18000000.00, // 1.8 Crore
                'status' => 'Available',
                'features' => ['Sea View', 'Premium Location', 'Security', 'Gym', 'Swimming Pool'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Independent Villa in Whitefield',
                'description' => 'Spacious 5BHK villa with private garden in IT corridor of Bangalore.',
                'address' => '78 Whitefield Main Road',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'pincode' => '560066',
                'type' => 'Villa',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 4200.00,
                'price' => 25000000.00, // 2.5 Crore
                'status' => 'Pending',
                'features' => ['Private Garden', 'IT Corridor', 'Security', 'Parking', 'Modern Kitchen'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Affordable House in Sector 62',
                'description' => '3BHK house in well-developed sector with good connectivity to metro.',
                'address' => '156 Sector 62',
                'city' => 'Noida',
                'state' => 'Uttar Pradesh',
                'pincode' => '201309',
                'type' => 'House',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 1600.00,
                'price' => 8500000.00, // 85 Lakhs
                'status' => 'Available',
                'features' => ['Metro Access', 'Schools Nearby', 'Parks', 'Shopping Mall'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Luxury Penthouse in Koramangala',
                'description' => 'Ultra-modern penthouse with rooftop terrace in prime Koramangala location.',
                'address' => '23 Koramangala 4th Block',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'pincode' => '560034',
                'type' => 'Apartment',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 3200.00,
                'price' => 22000000.00, // 2.2 Crore
                'status' => 'Rented',
                'features' => ['Rooftop Terrace', 'Prime Location', 'Modern Amenities', 'Parking'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Budget Studio in Powai',
                'description' => 'Compact studio apartment perfect for young professionals in Powai.',
                'address' => '89 Hiranandani Gardens',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400076',
                'type' => 'Apartment',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'area' => 500.00,
                'price' => 6500000.00, // 65 Lakhs
                'status' => 'Sold',
                'features' => ['Compact Living', 'IT Hub', 'Lake View', 'Modern Amenities'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Commercial Space in Cyber Hub',
                'description' => 'Premium office space in the heart of Gurgaon\'s business district.',
                'address' => '12 Cyber Hub',
                'city' => 'Gurgaon',
                'state' => 'Haryana',
                'pincode' => '122002',
                'type' => 'Commercial',
                'bedrooms' => null,
                'bathrooms' => 4,
                'area' => 2800.00,
                'price' => 28000000.00, // 2.8 Crore
                'status' => 'Available',
                'features' => ['Prime Business Location', 'Modern Office', 'Parking', 'Metro Access'],
                'added_by' => $userId,
            ],
            [
                'title' => 'Riverside Villa in Haridwar',
                'description' => 'Beautiful villa with river view, perfect for peaceful living away from city.',
                'address' => '34 Ganga View Road',
                'city' => 'Haridwar',
                'state' => 'Uttarakhand',
                'pincode' => '249401',
                'type' => 'Villa',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 3800.00,
                'price' => 15000000.00, // 1.5 Crore
                'status' => 'Available',
                'features' => ['River View', 'Peaceful Location', 'Garden', 'Temple Nearby'],
                'added_by' => $userId,
            ],
        ];

        foreach ($properties as $propertyData) {
            Property::create($propertyData);
            $this->command->line("   ✅ Created property: {$propertyData['title']}");
        }

        $this->command->info('🎉 Sample properties created successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   • Total Properties: ' . count($properties));
        $this->command->info('   • Available: ' . collect($properties)->where('status', 'Available')->count());
        $this->command->info('   • Sold: ' . collect($properties)->where('status', 'Sold')->count());
        $this->command->info('   • Rented: ' . collect($properties)->where('status', 'Rented')->count());
        $this->command->info('   • Pending: ' . collect($properties)->where('status', 'Pending')->count());
    }
}
