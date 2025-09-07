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
        Schema::create('repository_commits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('api_integration_id')->constrained()->onDelete('cascade');
            $table->string('commit_sha'); // SHA do commit
            $table->string('commit_message'); // Mensagem do commit
            $table->text('commit_description')->nullable(); // Descrição detalhada
            $table->string('author_name'); // Nome do autor
            $table->string('author_email'); // Email do autor
            $table->string('author_username')->nullable(); // Username do autor
            $table->timestamp('committed_at'); // Data/hora do commit
            $table->string('branch_name')->nullable(); // Branch do commit
            $table->json('files_changed')->nullable(); // Arquivos modificados
            $table->integer('lines_added')->default(0); // Linhas adicionadas
            $table->integer('lines_deleted')->default(0); // Linhas removidas
            $table->integer('files_changed_count')->default(0); // Número de arquivos
            $table->boolean('is_merge_commit')->default(false); // Se é merge commit
            $table->string('parent_sha')->nullable(); // SHA do commit pai
            $table->json('metadata')->nullable(); // Metadados adicionais
            $table->timestamps();
            
            // Índices
            $table->index(['project_id', 'committed_at']);
            $table->index(['api_integration_id', 'commit_sha']);
            $table->index(['author_email', 'committed_at']);
            $table->unique(['api_integration_id', 'commit_sha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repository_commits');
    }
};
