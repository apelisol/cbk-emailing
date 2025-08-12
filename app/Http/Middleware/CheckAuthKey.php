<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthKey
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validKey = config('app.auth_key');
        
        // If no key is set, allow access (for development)
        if (empty($validKey) || $validKey === 'default-secret-key-change-me') {
            return $next($request);
        }
        $providedKey = $request->query('auth_key');
        
        if (!$validKey || $providedKey !== $validKey) {
            abort(404);
        }

        return $next($request);
    }
}
