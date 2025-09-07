<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('session_name')->nullable(); // Nome da sessão de trabalho
            $table->text('description')->nullable(); // Descrição do que foi feito
            $table->timestamp('started_at'); // Quando começou
            $table->timestamp('ended_at')->nullable(); // Quando terminou
            $table->integer('duration_minutes')->default(0); // Duração em minutos
            $table->enum('status', ['active', 'paused', 'completed'])->default('active');
            $table->json('pause_periods')->nullable(); // Períodos de pausa [{start, end, duration}]
            $table->timestamps();
            
            // Índices para performance
            $table->index(['project_id', 'status']);
            $table->index(['user_id', 'started_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_trackings');
    }
};
