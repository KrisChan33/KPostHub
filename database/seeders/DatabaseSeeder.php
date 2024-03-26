<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '123',
        ]);

        Permission::factory()->create([
            'name' => 'Create',
            'description' => 'Create permission',
        ]);

        Permission::factory()->create([
            'name' => 'Update',
            'description' => 'Update permission',
        ]);

        Permission::factory()->create([
            'name' => 'Delete',
            'description' => 'Delete permission',
        ]);
    }
}
