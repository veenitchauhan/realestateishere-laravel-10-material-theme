<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Property;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RollbackSeeders extends Command
{
    protected $signature = 'seed:rollback 
                            {--properties : Only rollback properties}
                            {--users : Only rollback demo users}  
                            {--permissions : Only rollback permissions}
                            {--all : Rollback everything}';

    protected $description = 'Rollback seeded data selectively or completely';

    public function handle()
    {
        if ($this->option('all')) {
            $this->rollbackAll();
        } elseif ($this->option('properties')) {
            $this->rollbackProperties();
        } elseif ($this->option('users')) {
            $this->rollbackDemoUsers();
        } elseif ($this->option('permissions')) {
            $this->rollbackPermissions();
        } else {
            $this->showMenu();
        }

        return 0;
    }

    private function showMenu()
    {
        $this->info('🔄 Seeder Rollback Menu');
        $this->info('');
        
        $choice = $this->choice('What would you like to rollback?', [
            'properties' => 'Properties only',
            'users' => 'Demo users only',
            'permissions' => 'Permissions only', 
            'all' => 'Everything (destructive)',
            'cancel' => 'Cancel'
        ], 'cancel');

        switch ($choice) {
            case 'properties':
                $this->rollbackProperties();
                break;
            case 'users':
                $this->rollbackDemoUsers();
                break;
            case 'permissions':
                $this->rollbackPermissions();
                break;
            case 'all':
                if ($this->confirm('⚠️  This will remove ALL seeded data. Are you sure?')) {
                    $this->rollbackAll();
                }
                break;
            default:
                $this->info('✋ Operation cancelled.');
        }
    }

    private function rollbackProperties()
    {
        $this->info('🏠 Rolling back properties...');
        
        $count = Property::count();
        if ($count > 0) {
            Property::truncate();
            $this->info("   ✅ Removed {$count} properties");
        } else {
            $this->info("   ℹ️  No properties to remove");
        }
    }

    private function rollbackDemoUsers()
    {
        $this->info('👥 Rolling back demo users...');
        
        $demoEmails = ['admin@demo.com', 'dealer@demo.com'];
        $removed = 0;
        
        foreach ($demoEmails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->delete();
                $removed++;
                $this->info("   ✅ Removed user: {$email}");
            }
        }
        
        if ($removed === 0) {
            $this->info("   ℹ️  No demo users to remove");
        } else {
            $this->info("   🎉 Removed {$removed} demo users");
        }
    }

    private function rollbackPermissions()
    {
        $this->info('🔐 Rolling back permissions...');
        
        // Keep essential users but remove their roles
        $superAdmin = User::where('email', 'superadmin@realestateishere.com')->first();
        $admin = User::where('email', 'admin@material.com')->first();
        
        // Remove all permissions
        $permissionCount = Permission::count();
        Permission::query()->delete();
        $this->info("   ✅ Removed {$permissionCount} permissions");
        
        // Remove all roles
        $roleCount = Role::count();
        Role::query()->delete();
        $this->info("   ✅ Removed {$roleCount} roles");
        
        $this->warn('   ⚠️  You may need to re-run: php artisan db:seed --class=DatabaseSeeder');
    }

    private function rollbackAll()
    {
        $this->error('💥 DESTRUCTIVE ROLLBACK - Removing ALL seeded data!');
        
        // Properties
        $this->rollbackProperties();
        
        // Demo users  
        $this->rollbackDemoUsers();
        
        // Remove main users (except keep one for access)
        $this->info('👤 Keeping Super Admin, removing others...');
        User::where('email', '!=', 'superadmin@realestateishere.com')->delete();
        
        // Permissions & Roles
        $this->rollbackPermissions();
        
        $this->info('');
        $this->error('🔥 COMPLETE ROLLBACK FINISHED!');
        $this->info('💡 To restore: php artisan db:seed');
    }
}
