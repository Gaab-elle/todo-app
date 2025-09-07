<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestOAuthConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oauth:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test OAuth configuration for Google and GitHub';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔐 Testing OAuth Configuration...');
        $this->newLine();

        // Test Google OAuth
        $this->testGoogleOAuth();
        $this->newLine();

        // Test GitHub OAuth
        $this->testGitHubOAuth();
        $this->newLine();

        $this->info('✅ OAuth configuration test completed!');
    }

    private function testGoogleOAuth()
    {
        $this->info('🔵 Testing Google OAuth...');

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect');

        if (empty($clientId)) {
            $this->error('❌ GOOGLE_CLIENT_ID not found in .env');
            return;
        }

        if (empty($clientSecret)) {
            $this->error('❌ GOOGLE_CLIENT_SECRET not found in .env');
            return;
        }

        $this->info("✅ Google Client ID: " . substr($clientId, 0, 10) . '...');
        $this->info("✅ Google Client Secret: " . substr($clientSecret, 0, 10) . '...');
        $this->info("✅ Google Redirect URI: {$redirectUri}");

        // Test if the redirect URI is accessible
        try {
            $response = Http::timeout(5)->get($redirectUri);
            if ($response->successful()) {
                $this->info('✅ Google redirect URI is accessible');
            } else {
                $this->warn('⚠️  Google redirect URI returned status: ' . $response->status());
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Could not test Google redirect URI: ' . $e->getMessage());
        }
    }

    private function testGitHubOAuth()
    {
        $this->info('🐙 Testing GitHub OAuth...');

        $clientId = config('services.github.client_id');
        $clientSecret = config('services.github.client_secret');
        $redirectUri = config('services.github.redirect');

        if (empty($clientId)) {
            $this->error('❌ GITHUB_CLIENT_ID not found in .env');
            return;
        }

        if (empty($clientSecret)) {
            $this->error('❌ GITHUB_CLIENT_SECRET not found in .env');
            return;
        }

        $this->info("✅ GitHub Client ID: " . substr($clientId, 0, 10) . '...');
        $this->info("✅ GitHub Client Secret: " . substr($clientSecret, 0, 10) . '...');
        $this->info("✅ GitHub Redirect URI: {$redirectUri}");

        // Test if the redirect URI is accessible
        try {
            $response = Http::timeout(5)->get($redirectUri);
            if ($response->successful()) {
                $this->info('✅ GitHub redirect URI is accessible');
            } else {
                $this->warn('⚠️  GitHub redirect URI returned status: ' . $response->status());
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Could not test GitHub redirect URI: ' . $e->getMessage());
        }
    }
}