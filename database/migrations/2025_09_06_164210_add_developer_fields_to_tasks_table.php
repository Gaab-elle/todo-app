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
            $table->string('task_type')->nullable()->after('is_favorite');
            $table->string('programming_language')->nullable()->after('task_type');
            $table->integer('estimated_time')->nullable()->after('programming_language'); // em minutos
            $table->integer('actual_time')->default(0)->after('estimated_time'); // em minutos
            $table->string('complexity')->nullable()->after('actual_time');
            $table->string('repository_branch')->nullable()->after('complexity');
            $table->string('issue_number')->nullable()->after('repository_branch');
            $table->string('pull_request_url')->nullable()->after('issue_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'task_type',
                'programming_language',
                'estimated_time',
                'actual_time',
                'complexity',
                'repository_branch',
                'issue_number',
                'pull_request_url'
            ]);
        });
    }
};
