<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Step 1: Widen the enum to include both old and new values (safe for all rows)
        DB::statement("ALTER TABLE revenue_payouts MODIFY COLUMN status ENUM('Pending', 'Pending Approval', 'Paid') NOT NULL DEFAULT 'Pending'");

        // Step 2: Rename old 'Pending' rows to 'Pending Approval'
        DB::statement("UPDATE revenue_payouts SET status = 'Pending Approval' WHERE status = 'Pending'");

        // Step 3: Narrow the enum to only the new valid values
        DB::statement("ALTER TABLE revenue_payouts MODIFY COLUMN status ENUM('Pending Approval', 'Paid') NOT NULL DEFAULT 'Pending Approval'");

        // Step 4: Add new tracking columns
        Schema::table('revenue_payouts', function (Blueprint $table) {
            $table->string('payment_reference')->nullable()->after('payment_method');
            $table->text('admin_note')->nullable()->after('payment_reference');
        });
    }

    public function down(): void
    {
        // Revert rows back to 'Pending'
        DB::statement("UPDATE revenue_payouts SET status = 'Pending' WHERE status = 'Pending Approval'");
        DB::statement("ALTER TABLE revenue_payouts MODIFY COLUMN status ENUM('Pending', 'Paid') NOT NULL DEFAULT 'Pending'");

        Schema::table('revenue_payouts', function (Blueprint $table) {
            $table->dropColumn(['payment_reference', 'admin_note']);
        });
    }
};
