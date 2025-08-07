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
        // Run role and permission seeder first
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Then create additional users
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ]);

        $this->call([
            DemoUsersSeeder::class,
        ]);
    }
}
