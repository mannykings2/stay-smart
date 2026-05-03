<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('revenue_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->string('entity_type');  // 'property', 'chef', 'driver', 'global'
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('field_changed');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revenue_audit_logs');
    }
};
