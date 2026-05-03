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
        // 1. Staff Capacity
        Schema::table('chefs', function (Blueprint $table) {
            $table->integer('max_guests')->default(10)->after('image');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->integer('max_occupants')->default(4)->after('image');
        });

        // 2. Pivot Table Tiered Pricing
        Schema::table('chef_service_types', function (Blueprint $table) {
            $table->decimal('base_price', 10, 2)->nullable()->after('price');
            $table->decimal('per_unit_price', 10, 2)->nullable()->after('base_price');
        });

        Schema::table('driver_service_types', function (Blueprint $table) {
            $table->decimal('base_price', 10, 2)->nullable()->after('price');
            $table->decimal('per_unit_price', 10, 2)->nullable()->after('base_price');
        });

        // 3. Booking Requirements & Detailed Pricing
        Schema::table('chef_bookings', function (Blueprint $table) {
            $table->integer('number_of_guests')->default(1)->after('service_time');
            $table->text('dietary_requirements')->nullable()->after('number_of_guests');
            $table->text('menu_notes')->nullable()->after('dietary_requirements');
            $table->decimal('booking_base_price', 10, 2)->nullable()->after('price');
            $table->decimal('booking_per_unit_price', 10, 2)->nullable()->after('booking_base_price');
        });

        Schema::table('ride_bookings', function (Blueprint $table) {
            $table->integer('luggage_count')->default(0)->after('ride_time');
            $table->text('special_instructions')->nullable()->after('luggage_count');
            $table->integer('ride_duration_mins')->nullable()->after('special_instructions');
            $table->decimal('ride_distance_km', 10, 2)->nullable()->after('ride_duration_mins');
            $table->decimal('booking_base_price', 10, 2)->nullable()->after('price');
            $table->decimal('booking_per_unit_price', 10, 2)->nullable()->after('booking_base_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chefs', function (Blueprint $table) {
            $table->dropColumn('max_guests'); });
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('max_occupants'); });
        Schema::table('chef_service_types', function (Blueprint $table) {
            $table->dropColumn(['base_price', 'per_unit_price']); });
        Schema::table('driver_service_types', function (Blueprint $table) {
            $table->dropColumn(['base_price', 'per_unit_price']); });
        Schema::table('chef_bookings', function (Blueprint $table) {
            $table->dropColumn(['number_of_guests', 'dietary_requirements', 'menu_notes', 'booking_base_price', 'booking_per_unit_price']);
        });
        Schema::table('ride_bookings', function (Blueprint $table) {
            $table->dropColumn(['luggage_count', 'special_instructions', 'ride_duration_mins', 'ride_distance_km', 'booking_base_price', 'booking_per_unit_price']);
        });
    }
};
