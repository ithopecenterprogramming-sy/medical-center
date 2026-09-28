<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_type_id')
                ->constrained('service_types')
                ->cascadeOnDelete();

            $table->string('name', 200);
            $table->decimal('price', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['service_type_id', 'name'], 'srv_type_name_uq');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
