<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->foreignId('forwarded_to_user_id')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium')->after('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropForeign(['forwarded_to_user_id']);
            $table->dropColumn(['forwarded_to_user_id', 'priority']);
        });
    }
};
