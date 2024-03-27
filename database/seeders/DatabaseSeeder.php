<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::create([
            'id' => 1, // Add this line
            'role' => 'admin',
            'description' => 'Admin role',
        ]);
        Role::create([
            'id' => 2, // Add this line
            'role' => 'member',
            'description' => 'Admin role',
        ]);

        Permission::create([
            'name' => 'Create',
            'description' => 'Create permission',
        ]);

        Permission::create([
            'name' => 'Update',
            'description' => 'Update permission',
        ]);

        Permission::create([
            'name' => 'Delete',
            'description' => 'Delete permission',
        ]);

        User::factory(10)->create();
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => '123',
        ]);

        User::factory()->create([
            'name' => 'member',
            'email' => 'member@gmail.com',
            'role_id' => 2,
            'password' => '123',
        ]);
    }
}
