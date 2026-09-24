<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_avatars', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key pointing to users table
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('file_path'); // C:\storage\app\public\avatars\...
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable(); // image/png, image/jpeg
            $table->integer('file_size')->nullable(); // KB or Bytes

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_avatars');
    }
};