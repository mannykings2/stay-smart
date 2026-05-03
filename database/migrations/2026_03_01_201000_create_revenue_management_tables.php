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
        // 1. Create revenue_splits table
        Schema::create('revenue_splits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); // The Home-owner
            $table->foreignId('payout_id')->nullable()->constrained('revenue_payouts')->nullOnDelete();
            $table->string('service_type')->nullable(); // Property, Chef, Driver
            $table->decimal('total_amount', 12, 2);
            $table->decimal('platform_fee_amount', 12, 2);
            $table->decimal('admin_net_amount', 12, 2);
            $table->decimal('commission_rate_applied', 5, 2)->nullable();
            $table->enum('status', ['Pending', 'Paid', 'Available', 'Withdrawn'])->default('Pending');
            $table->timestamps();
        });

        // 2. Add payout and commission settings to users table
        Schema::table('users', function (Blueprint $table) {
            $table->enum('payout_frequency', ['Monthly', 'Quarterly', 'Yearly', 'On Demand'])->default('On Demand')->after('role');
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('payout_frequency'); // Percentage, e.g., 10.00%
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revenue_splits');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['payout_frequency', 'commission_rate']);
        });
    }
};
