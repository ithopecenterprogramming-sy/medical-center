<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedule_templates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('clinic_id')
                ->constrained('clinics')
                ->cascadeOnDelete();

            // 0 = Sunday ... 6 = Saturday
            $table->unsignedTinyInteger('day_of_week');

            $table->time('start_time');
            $table->time('end_time');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Short explicit name prevents MySQL 1059.
            $table->unique(
                ['doctor_id', 'clinic_id', 'day_of_week', 'start_time', 'end_time'],
                'dst_uq'
            );

            $table->index(['doctor_id', 'day_of_week', 'is_active'], 'dst_doc_day_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedule_templates');
    }
};
