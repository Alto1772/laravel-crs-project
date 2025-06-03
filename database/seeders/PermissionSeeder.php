<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // create essential permissions
        Permission::create(['name' => 'view all users']);
        Permission::create(['name' => 'view all roles']);
        Permission::create(['name' => 'view all permissions']);
    }
}
