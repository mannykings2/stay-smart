<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->enum('payout_frequency', ['Monthly', 'Quarterly', 'Yearly', 'On Demand'])
                ->nullable()
                ->after('commission_type')
                ->comment('Override payout frequency for this property. Null = inherit global default.');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('payout_frequency');
        });
    }
};
