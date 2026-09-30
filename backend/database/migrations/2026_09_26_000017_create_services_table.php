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
            $table->foreignId('service_type_id')->constrained('service_types')->cascadeOnDelete();
            $table->string('name', 190);
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->default(0.00); // التكلفة كما في الواجهة الثانية
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['service_type_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};