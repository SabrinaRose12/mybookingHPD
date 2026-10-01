<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuper
{
    /**
     * Handle an incoming request.
     * Deny access if the authenticated user is not an admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isSuper()) {
            abort(403, 'Unauthorized. Super access required.');
        }

        return $next($request);
    }
}
