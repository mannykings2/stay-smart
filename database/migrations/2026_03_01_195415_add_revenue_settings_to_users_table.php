<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $hasCommissionRate = Schema::hasColumn('users', 'commission_rate');

        Schema::table('users', function (Blueprint $table) use ($hasCommissionRate) {
            if (! Schema::hasColumn('users', 'staff_commission_rate')) {
                $column = $table->decimal('staff_commission_rate', 5, 2)->default(15.00); // Different rate for Staff
                if ($hasCommissionRate) {
                    $column->after('commission_rate');
                }
            }
            if (! Schema::hasColumn('users', 'grace_period_days')) {
                $column = $table->integer('grace_period_days')->default(3);
                if (Schema::hasColumn('users', 'staff_commission_rate')) {
                    $column->after('staff_commission_rate');
                }
            }
        });
    }

    public function down()
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $dropColumns = [];
            if (Schema::hasColumn('users', 'staff_commission_rate')) {
                $dropColumns[] = 'staff_commission_rate';
            }
            if (Schema::hasColumn('users', 'grace_period_days')) {
                $dropColumns[] = 'grace_period_days';
            }
            if (! empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
