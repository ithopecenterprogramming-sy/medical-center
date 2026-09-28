<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('action', 80);

            $table->string('auditable_type', 190)->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();

            $table->string('route', 255)->nullable();
            $table->string('method', 10)->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at'], 'aud_user_created_ix');
            $table->index(['auditable_type', 'auditable_id'], 'aud_target_ix');
            $table->index(['action', 'created_at'], 'aud_action_created_ix');
            $table->index(['ip_address', 'created_at'], 'aud_ip_created_ix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
