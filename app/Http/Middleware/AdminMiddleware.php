<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie que l'utilisateur est connecté et qu'il est admin
        if (! $request->user() || ! $request->user()->is_admin) {
            // Redirige vers la page d'accueil ou autre
            return redirect('dashboard')->WithErrors('Acces Denied');
        }

        return $next($request);
    }
}
