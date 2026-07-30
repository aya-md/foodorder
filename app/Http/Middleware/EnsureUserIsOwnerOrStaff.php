<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOwnerOrStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! in_array($request->user()->role, ['owner', 'staff'])) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
