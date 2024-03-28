<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
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

        $role = Role::create([
            // 'id' => 1, // Add this line
            'role' => 'admin',
            'description' => 'Admin role',
        ]);

        Role::create([
            // 'id' => 2, // Add this line
            'role' => 'member',
            'description' => 'Admin role',
        ]);

        //Permissions

        Permission::create([
            'name' => 'ViewAny',
            'description' => 'ViewAny permission',
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
            'name' => 'View',
            'description' => 'View permission',
        ]);

        Permission::create([
            'name' => 'Delete',
            'description' => 'Delete permission',
        ]);

        Permission::create([
            'name' => 'forceDelete',
            'description' => 'forceDelete permission',
        ]);

        Permission::create([
            'name' => 'forceDeleteAny',
            'description' => 'forceDeleteAny permission',
        ]);
        Permission::create([
            'name' => 'restore',
            'description' => 'restore permission',
        ]);
        Permission::create([
            'name' => 'reorder',
            'description' => 'reorder permission',
        ]);

        //Categories
        Category::create([
            'name' => 'Coding',
            'description' => 'Tasks related to code.',
        ]);

        Category::create([
            'name' => 'Documentation',
            'description' => 'Tasks related to creating or updating documents.',
        ]);

        Category::create([
            'name' => 'Research',
            'description' => 'Tasks related to exploring new tech or methods',
        ]);

        Category::create([
            'name' => 'Project Management',
            'description' => 'Tasks related to managing project resources.',
        ]);


        Category::create([
            'name' => 'Learning & Development',
            'description' => 'Tasks related to learning new skills or technologies',
        ]);


        $user1 = User::factory(10)->create();
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => '123',
        ]);
        $user1->assignRole('admin');

        $user2 = User::factory()->create([
            'name' => 'member',
            'email' => 'member@gmail.com',
            'password' => '123',
        ]);
        $user2->assignRole('member');
    }
}
