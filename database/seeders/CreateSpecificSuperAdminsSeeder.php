<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateSpecificSuperAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            'admin@staysmartbookings.com',
            'staysmartservices@gmail.com'
        ];

        // Ensure Super Admin role exists
        if (!Role::where('name', 'Super Admin')->exists()) {
            Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        }

        foreach ($admins as $email) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'first_name' => 'Super',
                    'last_name' => 'Admin',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            // Assign role if not already assigned
            if (!$user->hasRole('Super Admin')) {
                $user->assignRole('Super Admin');
            }
        }
    }
}
