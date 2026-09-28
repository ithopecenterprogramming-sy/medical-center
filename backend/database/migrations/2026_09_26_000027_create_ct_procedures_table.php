<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ct_procedures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            // Doctor is a users row with role=doctor.
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('imaging_type_id')
                ->constrained('ct_imaging_types')
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('scheduled_at')->nullable();

            // Kept because CT staff requirement explicitly asks for image type.
            $table->string('image_type', 150)->nullable();

            $table->boolean('has_injection')->default(false);
            $table->decimal('creatinine', 8, 3)->nullable();

            $table->text('health_problem')->nullable();
            $table->text('imaging_notes')->nullable();

            $table->string('status', 30)->default('planned');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['scheduled_at', 'status'], 'ctp_date_status_ix');
            $table->index(['patient_id', 'scheduled_at'], 'ctp_pat_date_ix');
            $table->index(['doctor_id', 'scheduled_at'], 'ctp_doc_date_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ct_procedures');
    }
};
