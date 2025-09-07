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
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
        
        // Atualizar tarefas existentes para o primeiro usuário (se existir)
        $firstUser = \App\Models\User::first();
        if ($firstUser) {
            \App\Models\Task::whereNull('user_id')->update(['user_id' => $firstUser->id]);
        }
        
        // Agora tornar a coluna NOT NULL
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};