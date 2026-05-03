<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role_type')->default('cleaner'); // 'cleaner' or 'admin'
            $table->timestamps();
            $table->unique(['property_id', 'user_id', 'role_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_user');
    }
};
