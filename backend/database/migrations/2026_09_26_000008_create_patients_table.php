<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('patient_number', 60)->unique('pat_no_uq');

            $table->string('first_name', 100);
            $table->string('last_name', 100);

            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('phone', 50)->nullable();
            $table->string('email', 190)->nullable();
            $table->string('national_id', 100)->nullable()->unique('pat_nid_uq');

            $table->string('city', 120)->nullable();
            $table->text('address')->nullable();

            $table->text('primary_complaint')->nullable();
            $table->text('notes')->nullable();

            $table->timestamp('registered_at')->useCurrent();

            // Employee who registered the patient.
            $table->foreignId('registered_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name'], 'pat_name_ix');
            $table->index(['city'], 'pat_city_ix');
            $table->index(['date_of_birth', 'gender'], 'pat_age_gender_ix');
            $table->index(['registered_by'], 'pat_regby_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
