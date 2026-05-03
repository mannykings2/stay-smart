<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Create the new table
        Schema::create('admin_revenue_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->decimal('staff_commission_rate', 5, 2)->default(15.00);
            $table->integer('grace_period_days')->default(3);
            $table->string('payout_frequency')->default('On Demand');
            $table->timestamps();
        });

        // 2. Copy existing data from users who have revenue settings
        $users = DB::table('users')
            ->where(function ($q) {
                $q->whereNotNull('commission_rate')
                  ->orWhereNotNull('payout_frequency')
                  ->orWhereNotNull('staff_commission_rate')
                  ->orWhereNotNull('grace_period_days');
            })
            ->get();

        foreach ($users as $user) {
            DB::table('admin_revenue_configs')->insert([
                'user_id'               => $user->id,
                'commission_rate'       => $user->commission_rate ?? 10.00,
                'staff_commission_rate' => $user->staff_commission_rate ?? 15.00,
                'grace_period_days'     => $user->grace_period_days ?? 3,
                'payout_frequency'      => $user->payout_frequency ?? 'On Demand',
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }

        // 3. Drop the old columns from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'staff_commission_rate', 'grace_period_days', 'payout_frequency']);
        });
    }

    public function down()
    {
        // Re-add columns to users
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->nullable()->after('avatar');
            $table->decimal('staff_commission_rate', 5, 2)->default(15.00)->after('commission_rate');
            $table->integer('grace_period_days')->default(3)->after('staff_commission_rate');
            $table->string('payout_frequency')->nullable()->after('grace_period_days');
        });

        // Copy data back
        $configs = DB::table('admin_revenue_configs')->get();
        foreach ($configs as $config) {
            DB::table('users')->where('id', $config->user_id)->update([
                'commission_rate'       => $config->commission_rate,
                'staff_commission_rate' => $config->staff_commission_rate,
                'grace_period_days'     => $config->grace_period_days,
                'payout_frequency'      => $config->payout_frequency,
            ]);
        }

        Schema::dropIfExists('admin_revenue_configs');
    }
};
