<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE revenue_splits MODIFY COLUMN status ENUM('Pending', 'Paid', 'Available', 'Withdrawn') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE revenue_splits MODIFY COLUMN status ENUM('Pending', 'Available', 'Withdrawn') DEFAULT 'Pending'");
    }
};
