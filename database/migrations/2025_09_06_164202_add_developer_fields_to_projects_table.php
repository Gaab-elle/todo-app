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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_type')->nullable()->after('is_favorite');
            $table->json('programming_languages')->nullable()->after('project_type');
            $table->json('technologies_used')->nullable()->after('programming_languages');
            $table->string('repository_url')->nullable()->after('technologies_used');
            $table->string('development_status')->default('planning')->after('repository_url');
            $table->integer('time_spent')->default(0)->after('development_status'); // em minutos
            $table->date('start_date')->nullable()->after('time_spent');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('category')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'project_type',
                'programming_languages',
                'technologies_used',
                'repository_url',
                'development_status',
                'time_spent',
                'start_date',
                'end_date',
                'category'
            ]);
        });
    }
};
