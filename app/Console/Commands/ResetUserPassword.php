<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");

            // Optional: Ask if we should create the user
            if ($this->confirm('Do you want to create this user as Super Admin?', true)) {
                $user = new User();
                $user->email = $email;
                $user->first_name = 'Super';
                $user->last_name = 'Admin';
                $user->phone_number = '0000000000'; // Placeholder
                $user->password = Hash::make($password);
                $user->save();

                $role = Role::firstOrCreate(['name' => 'Super Admin']);
                $user->assignRole($role);

                $this->info("User created and password set.");
                return 0;
            }

            return 1;
        }

        $user->password = Hash::make($password);
        $user->save();

        // Ensure they have Super Admin role just in case
        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole($role);
            $this->info("Assigned Super Admin role to the user.");
        }

        $this->info("Password for {$email} has been reset successfully.");
        return 0;
    }
}
