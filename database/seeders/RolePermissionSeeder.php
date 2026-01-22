<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //cacheni tozalash
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //permissionlar yaratish (sanctum guard bilan)
        $permissions = [
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'create-factories',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'sanctum']);
        }
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'sanctum']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'sanctum']);
        $adminRole->givePermissionTo(Permission::where('name', '!=', 'create-factories')->get());


        $userRole = Role::create(['name' => 'User', 'guard_name' => 'sanctum']);
        $userRole->givePermissionTo('view-products', 'view-factories');
    }
}
