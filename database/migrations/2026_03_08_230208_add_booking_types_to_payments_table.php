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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('chef_booking_id')->nullable()->after('booking_id');
            $table->unsignedBigInteger('ride_booking_id')->nullable()->after('chef_booking_id');

            $table->foreign('chef_booking_id')->references('id')->on('chef_bookings')->onDelete('set null');
            $table->foreign('ride_booking_id')->references('id')->on('ride_bookings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['chef_booking_id']);
            $table->dropForeign(['ride_booking_id']);
            $table->dropColumn(['chef_booking_id', 'ride_booking_id']);
        });
    }
};
