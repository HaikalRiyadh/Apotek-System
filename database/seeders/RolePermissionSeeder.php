<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Medicine permissions
            'view medicines',
            'create medicines',
            'edit medicines',
            'delete medicines',

            // Category & Unit
            'manage categories',
            'manage units',

            // Supplier
            'view suppliers',
            'manage suppliers',

            // Purchase
            'view purchases',
            'create purchases',

            // Sales
            'view sales',
            'create sales',

            // Reports
            'view reports',

            // Dashboard
            'view dashboard',

            // Users
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

        $apoteker = Role::create(['name' => 'Apoteker']);
        $apoteker->givePermissionTo([
            'view medicines',
            'create medicines',
            'edit medicines',
            'manage categories',
            'manage units',
            'view suppliers',
            'manage suppliers',
            'view purchases',
            'create purchases',
            'view sales',
            'view reports',
            'view dashboard',
        ]);

        $kasir = Role::create(['name' => 'Kasir']);
        $kasir->givePermissionTo([
            'view medicines',
            'view sales',
            'create sales',
            'view dashboard',
        ]);
    }
}
