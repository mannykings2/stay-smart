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
        Schema::create('chef_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chef_id')->constrained()->cascadeOnDelete();
            // Added later after chef_service_types exists
            $table->foreignId('booking_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('reference')->nullable();
            $table->date('service_date');
            $table->time('service_time');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled'])->default('Scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chef_bookings');
    }
};
