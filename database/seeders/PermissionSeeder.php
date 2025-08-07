<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🧹 Cleaning existing permissions and roles...');
        
        // Option 1: Using truncate with foreign key checks disabled
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Spatie\Permission\Models\Permission::truncate();
        \Spatie\Permission\Models\Role::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Option 2: Using delete (safer, handles foreign keys automatically)
        // \Spatie\Permission\Models\Permission::query()->delete();
        // \Spatie\Permission\Models\Role::query()->delete();

        $this->command->info('🔧 Creating roles first...');
        
        // Create roles first (needed before permissions assignment)
        $roles = [
            'Super Admin' => 'Has all permissions and full system access',
            'Admin' => 'Can manage properties and users but not roles/permissions',
            'Dealer' => 'Can only view properties (read-only access)'
        ];

        foreach ($roles as $roleName => $description) {
            Role::create(['name' => $roleName, 'guard_name' => 'web']);
            $this->command->line("   ✅ Created role: {$roleName}");
        }

        // Create permissions for the application
        $this->command->info('📋 Creating application permissions...');
        $permissions = [
            // Property Management
            'add-property' => 'Add new properties',
            'edit-property' => 'Edit existing properties', 
            'show-property' => 'View property details',
            'delete-property' => 'Delete properties',
            
            // User Management
            'view-users' => 'View users list',
            'create-users' => 'Create new users',
            'edit-users' => 'Edit user details',
            'delete-users' => 'Delete users',
            
            // Role Management  
            'view-roles' => 'View roles list',
            'create-roles' => 'Create new roles',
            'edit-roles' => 'Edit role details',
            'delete-roles' => 'Delete roles',
            
            // Permission Management
            'view-permissions' => 'View permissions list',
            'create-permissions' => 'Create new permissions',
            'edit-permissions' => 'Edit permission details',
            'delete-permissions' => 'Delete permissions',
            
            // Reports
            'view-reports' => 'View system reports',
        ];

        foreach ($permissions as $permission => $description) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
            $this->command->line("   ✅ Created permission: {$permission}");
        }

        // Update role permissions
        $this->command->info('🔗 Updating role permissions...');

        // Admin - Property management + user management (but not permission/role management)
        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $adminPermissions = [
                'add-property', 'edit-property', 'show-property', 'delete-property',
                'view-users', 'create-users', 'edit-users', 'delete-users',
                'view-reports'
            ];
            $admin->syncPermissions($adminPermissions);
            $this->command->info("   🛠️  Admin: " . count($adminPermissions) . " permissions assigned");
        }

        // Dealer - Only view properties and basic access
        $dealer = Role::where('name', 'Dealer')->first();
        if ($dealer) {
            $dealerPermissions = ['show-property'];
            $dealer->syncPermissions($dealerPermissions);
            $this->command->info("   🏪 Dealer: " . count($dealerPermissions) . " permissions assigned");
        }

        $this->command->info('✅ Permission system updated successfully!');
    }
}
