<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create/Update Demo Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin User',
                'password' => 'password123', // No need for Hash::make() - model handles it
                'phone' => '+1234567890',
                'location' => 'Mumbai, India',
                'about' => 'Demo Admin user - Can manage all properties and users'
            ]
        );
        
        // Assign Admin role
        $adminRole = Role::findByName('Admin');
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole($adminRole);
        }

        // Create/Update Demo Dealer User
        $dealer = User::updateOrCreate(
            ['email' => 'dealer@demo.com'],
            [
                'name' => 'Dealer User',
                'password' => 'password123', // No need for Hash::make() - model handles it
                'phone' => '+1234567892',
                'location' => 'Delhi, India',
                'about' => 'Demo Dealer user - Can only view properties (read-only access)'
            ]
        );
        
        // Assign Dealer role (though it's already assigned by default in User model)
        $dealerRole = Role::findByName('Dealer');
        if (!$dealer->hasRole('Dealer')) {
            $dealer->assignRole($dealerRole);
        }

        $this->command->info('✅ Demo users created successfully!');
        $this->command->info('📧 Credentials:');
        $this->command->info('   Super Admin: superadmin@realestateishere.com / password');
        $this->command->info('   Admin: admin@demo.com / password123');
        $this->command->info('   Dealer: dealer@demo.com / password123');
        $this->command->info('');
        $this->command->info('💰 Currency: All prices will be in INR (₹)');
    }
}
