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
        Schema::table('properties', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->nullable()->after('price_per_night'); // Percentage, e.g., 10.00%
            $table->enum('commission_type', ['Fixed', 'Percentage'])->default('Percentage')->after('commission_rate');
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'commission_type']);
        });
    }
};
