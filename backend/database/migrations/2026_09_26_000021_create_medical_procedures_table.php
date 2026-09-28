<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_procedures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('procedure_type_id')
                ->constrained('medical_procedure_types')
                ->restrictOnDelete();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('visit_id')
                ->nullable()
                ->constrained('visits')
                ->nullOnDelete();

            $table->foreignId('service_id')
                ->nullable()
                ->constrained('services')
                ->nullOnDelete();

            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('performed_at')->nullable();
            $table->string('status', 30)->default('planned');
            $table->text('notes')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'scheduled_at'], 'mpr_pat_date_ix');
            $table->index(['doctor_id', 'scheduled_at'], 'mpr_doc_date_ix');
            $table->index(['procedure_type_id', 'status'], 'mpr_type_status_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_procedures');
    }
};
