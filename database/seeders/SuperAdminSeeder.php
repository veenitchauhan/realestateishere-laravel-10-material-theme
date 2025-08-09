<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('👤 Creating/Updating Super Admin user...');

        // Create or update super admin user

        // Create/Update Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'veenitchauhan@gmail.com'],
            [
                'name' => 'Veenit Chauhan',
                'password' => 'V1n1_P@ssw0rd', // No need for Hash::make() - model handles it
                'phone' => '+917508122311',
                'location' => 'Panchkula, India',
                'about' => 'Super Admin user - Has all permissions and controls the entire system',
                'email_verified_at' => now(),
            ]
        );
        
        // Assign Super Admin role
        $superAdminRole = Role::findByName('Super Admin');
        if ($superAdminRole && !$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole($superAdminRole);
        }

        $this->command->info('✅ Super Admin created successfully!');
        $this->command->info('📧 Login Credentials:');
        $this->command->info('   Super Admin: veenitchauhan@gmail.com / V1n1_P@ssw0rd');
        $this->command->info('');
        $this->command->info('💡 Note: Other users can be created manually via the admin panel');
        $this->command->info('💰 Currency: All prices will be in INR (₹)');
    }
}