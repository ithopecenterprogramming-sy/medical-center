<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('clinic_id')
                ->constrained('clinics')
                ->cascadeOnDelete();

            $table->foreignId('template_id')
                ->nullable()
                ->constrained('doctor_schedule_templates')
                ->nullOnDelete();

            $table->date('schedule_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->string('status', 30)->default('open');
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['doctor_id', 'clinic_id', 'schedule_date', 'start_time', 'end_time'],
                'ds_uq'
            );

            $table->index(['schedule_date', 'status'], 'ds_date_status_ix');
            $table->index(['doctor_id', 'schedule_date'], 'ds_doc_date_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
