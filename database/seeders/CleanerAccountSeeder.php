<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CleanerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure Cleaner role exists
        $role = Role::firstOrCreate(['name' => 'Cleaner']);

        // Create Cleaner User
        $user = User::firstOrCreate(
            ['email' => 'cleaner@staysmart.com'],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'gender' => 'Male',
                'phone_number' => '08012345678',
                'password' => Hash::make('password'),
            ]
        );

        // Assign Role
        if (!$user->hasRole('Cleaner')) {
            $user->assignRole($role);
        }
    }
}
