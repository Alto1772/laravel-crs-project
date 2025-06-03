<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // create roles and assign created permissions
        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Admin']);

        $role = Role::create(['name' => 'Test Role']);
        $role->givePermissionTo(['create colleges', 'update colleges']);

        $role = Role::create(['name' => 'Test Role 2']);
        $role->givePermissionTo(['create colleges', 'update colleges', 'delete colleges']);
    }
}
