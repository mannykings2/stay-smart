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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->unsignedBigInteger('inviter_id');
            $table->string('role')->default('Cleaner');
            $table->timestamp('expires_at');
            $table->timestamp('claimed_at')->nullable();
            $table->unsignedBigInteger('claimed_by')->nullable();
            $table->timestamps();

            $table->foreign('inviter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('claimed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
};
