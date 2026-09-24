<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic Auth & Profile Information
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // Contact Information
            $table->string('phone')->nullable()->unique();
            $table->text('address')->nullable();

            // Personal Information
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            
            // System Role
            $table->enum('role', [
                'admin',
                'doctor',
                'reception',
            ])->default('reception')->index();

            // Account Status & Verification
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};