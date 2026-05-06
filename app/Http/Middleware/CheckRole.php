<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur a le bon rôle
     * CDC : F24 - Rôle distinct employé / manager
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Vérifie si l'utilisateur a le bon rôle
        if (auth()->user()->role !== $role) {
            return redirect('/dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}