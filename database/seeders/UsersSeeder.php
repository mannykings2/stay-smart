<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $userRole = Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);

        User::factory(10)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
        });

        $this->command->info('10 users have been seeded and assigned the "User" role successfully.');
    }
}