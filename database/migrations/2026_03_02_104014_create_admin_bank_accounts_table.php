<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('bank_code');          // Paystack bank code
            $table->string('account_number', 10);
            $table->string('account_name');       // Auto-resolved via Paystack
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            // One bank account per user
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_bank_accounts');
    }
};
