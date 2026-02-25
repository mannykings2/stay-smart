<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CleanerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the Cleaner role
        $cleanerRole = Role::firstOrCreate(['name' => 'Cleaner']);

        // Define permissions for the Cleaner
        $permissions = [
            'view cleaning schedule',
            'update cleaning status',
        ];

        // Create permissions and assign to role
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $cleanerRole->givePermissionTo($permission);
        }
    }
}
