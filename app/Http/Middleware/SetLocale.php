<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se existe um locale na sessão
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            
            // Verificar se o locale é válido
            if (in_array($locale, config('app.available_locales', ['en', 'pt']))) {
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}