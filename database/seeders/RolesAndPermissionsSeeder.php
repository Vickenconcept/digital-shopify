<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',
            'publish products',
            'feature products',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Order permissions
            'view orders',
            'manage orders',
            'view own orders',
            
            // User permissions
            'view users',
            'edit users',
            'delete users',
            
            // Content permissions
            'upload content',
            'download content',
            'preview content',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'publish products',
            'feature products',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view orders',
            'manage orders',
            'view users',
            'edit users',
            'upload content',
            'download content',
            'preview content',
        ]);

        $role = Role::create(['name' => 'content-creator']);
        $role->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'upload content',
            'download content',
            'preview content',
            'view own orders',
        ]);

        $role = Role::create(['name' => 'customer']);
        $role->givePermissionTo([
            'view products',
            'view own orders',
            'download content',
            'preview content',
        ]);
    }
}
