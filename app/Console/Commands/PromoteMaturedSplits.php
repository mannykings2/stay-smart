<?php

namespace App\Console\Commands;

use App\Http\Controllers\RevenueManagementController;
use App\Models\User;
use Illuminate\Console\Command;

class PromoteMaturedSplits extends Command
{
    protected $signature = 'revenue:promote-splits';
    protected $description = 'Promote matured revenue splits from Paid to Available based on payout frequency';

    public function handle()
    {
        $controller = app(RevenueManagementController::class);
        $admins = User::role('Admin')->get();

        $promoted = 0;
        foreach ($admins as $admin) {
            $controller->runPromoteMaturedSplits($admin);
            $promoted++;
        }

        $this->info("Checked {$promoted} admin(s) for matured splits.");
        return Command::SUCCESS;
    }
}
