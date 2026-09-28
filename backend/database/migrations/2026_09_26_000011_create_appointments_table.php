<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->string('appointment_number', 60)->unique('apt_no_uq');

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            // Doctor is a users row with role=doctor.
            $table->foreignId('doctor_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('clinic_id')
                ->constrained('clinics')
                ->restrictOnDelete();

            $table->foreignId('schedule_id')
                ->nullable()
                ->constrained('doctor_schedules')
                ->nullOnDelete();

            // Reception/admin/other employee who created the booking.
            $table->foreignId('booked_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('scheduled_at');
            $table->unsignedSmallInteger('duration_minutes')->default(30);

            /*
             * planned, unplanned, waiting, active, completed,
             * cancelled, no_show, postponed
             */
            $table->string('status', 30)->default('planned');

            // call, no_show, postpone, cancel
            $table->string('action', 30)->nullable();

            $table->string('booking_source', 30)->default('reception');

            $table->text('reason')->nullable();
            $table->text('notes')->nullable();

            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['scheduled_at', 'status'], 'apt_date_status_ix');
            $table->index(['doctor_id', 'scheduled_at'], 'apt_doc_date_ix');
            $table->index(['clinic_id', 'scheduled_at'], 'apt_cli_date_ix');
            $table->index(['patient_id', 'scheduled_at'], 'apt_pat_date_ix');
            $table->index(['booked_by', 'scheduled_at'], 'apt_booker_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
