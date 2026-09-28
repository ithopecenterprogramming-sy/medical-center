<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_checks', function (Blueprint $table) {
            $table->id();

            $table->string('name', 200);
            $table->string('category', 100)->nullable();
            $table->string('status', 30);

            $table->text('message')->nullable();
            $table->text('details')->nullable();

            $table->timestamp('checked_at');

            $table->timestamps();

            $table->index(['checked_at', 'status'], 'syschk_checked_status_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_checks');
    }
};
