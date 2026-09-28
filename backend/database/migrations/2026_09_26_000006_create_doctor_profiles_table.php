<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();

            // Must point to a users row whose role is doctor.
            $table->foreignId('user_id')
                ->unique('dprof_user_uq')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('specialty_id')
                ->constrained('specialties')
                ->restrictOnDelete();

            $table->string('license_number', 100)
                ->nullable()
                ->unique('dprof_license_uq');

            $table->unsignedSmallInteger('visit_duration')->default(30);
            $table->text('bio')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['specialty_id'], 'dprof_spec_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
