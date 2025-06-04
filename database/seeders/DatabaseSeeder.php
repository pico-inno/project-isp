<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        // Create features
        $userFeature = Feature::create(['name' => 'User']);
        $roleFeature = Feature::create(['name' => 'Role']);
        $routerFeature = Feature::create(['name' => 'Router']);
        // Add more features as needed

        // Create permissions for each feature
        $permissions = [
            'create', 'read', 'update', 'delete'
        ];

        foreach ([$userFeature, $roleFeature, $routerFeature] as $feature) {
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'feature_id' => $feature->id
                ]);
            }
        }

        // Create roles
        $admin = Role::create(['name' => 'Admin']);
        $editor = Role::create(['name' => 'Editor']);
        $viewer = Role::create(['name' => 'Viewer']);

        // Assign permissions to roles
        $admin->permissions()->attach(Permission::pluck('id'));

        $editorPermissions = Permission::whereIn('name', ['create', 'read', 'update'])->pluck('id');
        $editor->permissions()->attach($editorPermissions);

        $viewerPermissions = Permission::where('name', 'read')->pluck('id');
        $viewer->permissions()->attach($viewerPermissions);


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
            'role_id' => $admin->id,
        ]);
    }
}
