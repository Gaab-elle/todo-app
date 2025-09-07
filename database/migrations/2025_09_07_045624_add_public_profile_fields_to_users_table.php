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
        Schema::table('users', function (Blueprint $table) {
            // Profile visibility and type
            $table->boolean('is_public')->default(false)->after('avatar');
            $table->enum('profile_type', ['professional', 'personal'])->default('professional')->after('is_public');
            
            // Basic profile information
            $table->text('bio')->nullable()->after('profile_type');
            $table->string('location')->nullable()->after('bio');
            $table->string('website')->nullable()->after('location');
            
            // Social links
            $table->string('linkedin')->nullable()->after('website');
            $table->string('twitter')->nullable()->after('linkedin');
            $table->string('github_username')->nullable()->after('twitter');
            
            // Skills and experience
            $table->json('skills')->nullable()->after('github_username');
            $table->json('experience')->nullable()->after('skills');
            
            // GitHub integration
            $table->string('github_access_token')->nullable()->after('experience');
            $table->timestamp('github_synced_at')->nullable()->after('github_access_token');
            
            // Profile customization
            $table->string('profile_theme')->default('default')->after('github_synced_at');
            $table->json('profile_settings')->nullable()->after('profile_theme');
            
            // SEO and discovery
            $table->string('username')->unique()->nullable()->after('profile_settings');
            $table->text('meta_description')->nullable()->after('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_public',
                'profile_type',
                'bio',
                'location',
                'website',
                'linkedin',
                'twitter',
                'github_username',
                'skills',
                'experience',
                'github_access_token',
                'github_synced_at',
                'profile_theme',
                'profile_settings',
                'username',
                'meta_description'
            ]);
        });
    }
};