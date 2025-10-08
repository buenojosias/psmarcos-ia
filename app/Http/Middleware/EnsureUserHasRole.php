<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ?string $roles = null): Response
    {
        $user = $request->user();

        if (empty($roles)) {
            abort(403, 'Nenhuma role especificada no middleware.');
        }

        $roles = preg_split('/[,\|]/', $roles);
        $roles = array_map('trim', $roles);
        $roles = array_filter($roles);

        if (! $user->hasAnyRole($roles)) {
            abort(403, 'Você não tem permissão para acessar esta rota.');
        }

        return $next($request);
    }
}
