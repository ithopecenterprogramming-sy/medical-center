<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
             $table->id();

            // Basic Auth & Profile
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // Contact
            $table->string('phone')->nullable()->unique();
            $table->text('address')->nullable();

            // Personal
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();

            // Every employee exists here.
            $table->enum('role', [
                'admin',
                'doctor',
                'reception',
                'ct_staff',
            ])->default('reception')->index();

            // Department is shared by employees.
            // Admin may leave it NULL.
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['department_id', 'role'], 'usr_dep_role_ix');
            $table->index(['role', 'is_active'], 'usr_role_active_ix');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
