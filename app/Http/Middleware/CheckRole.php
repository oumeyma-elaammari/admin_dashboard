<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }

        $parsed = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $parsed[] = strtolower(trim($r));
            }
        }

        if (!in_array(strtolower($user->role), $parsed)) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        return $next($request);
    }
}
