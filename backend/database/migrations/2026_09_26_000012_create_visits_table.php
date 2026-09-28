<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('appointment_id')
                ->nullable()
                ->unique('vis_apt_uq')
                ->constrained('appointments')
                ->nullOnDelete();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('clinic_id')
                ->nullable()
                ->constrained('clinics')
                ->nullOnDelete();

            $table->foreignId('opened_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();

            $table->string('status', 30)->default('active');

            $table->text('chief_complaint')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('clinical_notes')->nullable();
            $table->text('prescription_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'created_at'], 'vis_pat_created_ix');
            $table->index(['doctor_id', 'created_at'], 'vis_doc_created_ix');
            $table->index(['status', 'created_at'], 'vis_status_created_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
