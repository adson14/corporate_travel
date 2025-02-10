<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated - Please log in'], 401);
        }

        // Verifica se o usuário tem a permissão passada como parâmetro
        if (!Auth::user()->hasPermission($permission)) {
            return response()->json(['message' => 'Unauthorized - You do not have permission to perform this action'], 403);
        }
        return $next($request);
    }
}
