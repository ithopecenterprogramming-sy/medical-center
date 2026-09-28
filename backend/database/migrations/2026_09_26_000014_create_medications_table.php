<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();

            $table->string('name', 200);
            $table->string('generic_name', 200)->nullable();
            $table->string('strength', 100)->nullable();
            $table->string('form', 100)->nullable();
            $table->string('unit', 50)->nullable();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'is_active'], 'med_name_active_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
