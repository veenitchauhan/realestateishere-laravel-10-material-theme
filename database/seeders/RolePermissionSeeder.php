<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing permissions and roles to start fresh
        $this->command->info('🧹 Clearing existing permissions and roles...');
        Permission::query()->delete();
        Role::query()->delete();
        
        // Create the 3 roles as specified
        $this->command->info('👥 Creating roles...');
        $roles = [
            'Super Admin' => 'Has full access to everything',
            'Admin' => 'Can manage properties and users',
            'Dealer' => 'Basic property access'
        ];

        foreach ($roles as $roleName => $description) {
            Role::create(['name' => $roleName, 'guard_name' => 'web']);
            $this->command->line("   ✅ Created role: {$roleName}");
        }

        // Create the 4 property permissions as specified
        $this->command->info('📋 Creating property permissions...');
        $permissions = [
            'add-property' => 'Add new properties',
            'edit-property' => 'Edit existing properties', 
            'show-property' => 'View property details',
            'delete-property' => 'Delete properties',
        ];

        foreach ($permissions as $permission => $description) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
            $this->command->line("   ✅ Created permission: {$permission}");
        }

        // Assign permissions to roles
        $this->command->info('🔗 Assigning permissions to roles...');

        // Super Admin - Gets ALL permissions automatically via Gate::before()
        $this->command->info("   👑 Super Admin: Has ALL permissions by default (via Gate::before())");

        // Admin - All property permissions
        $admin = Role::findByName('Admin');
        $adminPermissions = ['add-property', 'edit-property', 'show-property', 'delete-property'];
        $admin->syncPermissions($adminPermissions);
        $this->command->info("   🛠️  Admin: " . count($adminPermissions) . " permissions assigned");

        // Dealer - Only show property permission
        $dealer = Role::findByName('Dealer');
        $dealerPermissions = ['show-property'];
        $dealer->syncPermissions($dealerPermissions);
        $this->command->info("   � Dealer: " . count($dealerPermissions) . " permissions assigned");

        // Create Super Admin user
        $this->command->info('👑 Creating Super Admin user...');
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@realestateishere.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');
        $this->command->info("   ✅ Super Admin user created: {$superAdmin->email}");

        $this->command->info('');
        $this->command->info('🎉 Role & Permission system setup completed!');
        $this->command->info('📊 Summary:');
        $this->command->info('   • Roles: Super Admin, Admin, Dealer');
        $this->command->info('   • Permissions: add-property, edit-property, show-property, delete-property');
        $this->command->info('   • Super Admin user: superadmin@realestateishere.com (password: password)');
        $this->command->info('   • Currency: INR (to be used in property pricing)');
    }
}
