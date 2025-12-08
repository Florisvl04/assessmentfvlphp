<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRole;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()->role === UserRole::ADMIN) {
            return $next($request);
        }

        if (!$request->user() || $request->user()->role->value !== $role) {
            abort(403, 'Je hebt geen toegang tot deze pagina. Jij hebt niet de role: ' . $role);
        }
        return $next($request);
    }
}
