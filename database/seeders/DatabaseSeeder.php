<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create roles first
        $superAdminRole = \Spatie\Permission\Models\Role::create(['name' => 'Super Admin']);
        $adminRole = \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        $dealerRole = \Spatie\Permission\Models\Role::create(['name' => 'Dealer']);

        // Run other seeders
        $this->call([
            PermissionSeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}
