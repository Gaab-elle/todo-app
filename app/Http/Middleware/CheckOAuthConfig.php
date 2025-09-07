<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOAuthConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se as configurações OAuth estão presentes
        $googleConfigured = !empty(config('services.google.client_id')) && !empty(config('services.google.client_secret'));
        $githubConfigured = !empty(config('services.github.client_id')) && !empty(config('services.github.client_secret'));

        // Compartilhar o status das configurações com todas as views
        view()->share('googleOAuthConfigured', $googleConfigured);
        view()->share('githubOAuthConfigured', $githubConfigured);

        return $next($request);
    }
}