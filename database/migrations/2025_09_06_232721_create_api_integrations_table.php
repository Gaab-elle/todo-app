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
        Schema::create('api_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('provider', ['github', 'gitlab']); // Provedor da API
            $table->string('repository_owner'); // Usuário/organização do repositório
            $table->string('repository_name'); // Nome do repositório
            $table->string('repository_full_name'); // owner/repo
            $table->string('access_token'); // Token de acesso (criptografado)
            $table->string('webhook_secret')->nullable(); // Secret para webhooks
            $table->string('webhook_url')->nullable(); // URL do webhook configurado
            $table->boolean('is_active')->default(true); // Se a integração está ativa
            $table->boolean('auto_tracking')->default(true); // Se deve fazer tracking automático
            $table->boolean('sync_commits')->default(true); // Se deve sincronizar commits
            $table->boolean('sync_issues')->default(false); // Se deve sincronizar issues
            $table->boolean('sync_pull_requests')->default(false); // Se deve sincronizar PRs
            $table->json('settings')->nullable(); // Configurações adicionais
            $table->timestamp('last_sync_at')->nullable(); // Última sincronização
            $table->timestamps();
            
            // Índices
            $table->index(['project_id', 'provider']);
            $table->index(['user_id', 'is_active']);
            $table->unique(['project_id', 'repository_full_name', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_integrations');
    }
};
