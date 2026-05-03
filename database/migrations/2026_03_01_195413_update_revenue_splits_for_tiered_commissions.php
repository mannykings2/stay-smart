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
        // Guard against fresh installs where these columns already exist.
        if (! Schema::hasTable('revenue_splits')) {
            return;
        }

        Schema::table('revenue_splits', function (Blueprint $table) {
            if (! Schema::hasColumn('revenue_splits', 'payout_id')) {
                $table->foreignId('payout_id')->nullable()->after('admin_id')->constrained('revenue_payouts')->nullOnDelete();
            }
            if (! Schema::hasColumn('revenue_splits', 'service_type')) {
                $table->string('service_type')->nullable()->after('payout_id'); // Property, Chef, Driver
            }
            if (! Schema::hasColumn('revenue_splits', 'commission_rate_applied')) {
                $table->decimal('commission_rate_applied', 5, 2)->nullable()->after('admin_net_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('revenue_splits')) {
            return;
        }

        Schema::table('revenue_splits', function (Blueprint $table) {
            if (Schema::hasColumn('revenue_splits', 'payout_id')) {
                $table->dropForeign(['payout_id']);
                $table->dropColumn('payout_id');
            }
            if (Schema::hasColumn('revenue_splits', 'service_type')) {
                $table->dropColumn('service_type');
            }
            if (Schema::hasColumn('revenue_splits', 'commission_rate_applied')) {
                $table->dropColumn('commission_rate_applied');
            }
        });
    }
};
