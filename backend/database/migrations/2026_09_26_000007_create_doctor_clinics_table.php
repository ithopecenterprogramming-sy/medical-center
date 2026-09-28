<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_clinics', function (Blueprint $table) {
            $table->id();

            // References users.id, not doctors.id.
            $table->foreignId('doctor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('clinic_id')
                ->constrained('clinics')
                ->cascadeOnDelete();

            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            // Explicit short name avoids MySQL 1059.
            $table->unique(['doctor_id', 'clinic_id'], 'dcli_uq');
            $table->index(['doctor_id'], 'dcli_doc_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_clinics');
    }
};
