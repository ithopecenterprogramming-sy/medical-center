<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_medications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('visit_id')
                ->constrained('visits')
                ->cascadeOnDelete();

            $table->foreignId('medication_id')
                ->constrained('medications')
                ->restrictOnDelete();

            $table->string('dose', 100)->nullable();
            $table->string('frequency', 100)->nullable();
            $table->string('duration', 100)->nullable();
            $table->text('instructions')->nullable();

            // true = previous medication shown in patient history.
            $table->boolean('is_previous')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['visit_id', 'is_previous'], 'vm_visit_previous_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_medications');
    }
};
