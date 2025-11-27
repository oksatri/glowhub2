<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        Log::info('RoleMiddleware - Checking access:', [
            'path' => $request->path(),
            'method' => $request->method(),
            'required_roles' => $roles
        ]);

        if (!Auth::check()) {
            Log::info('RoleMiddleware - User not authenticated, redirecting to login');
            return redirect()->route('login');
        }

        $user = Auth::user();

        Log::info('RoleMiddleware - User authenticated:', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'required_roles' => $roles
        ]);

        if (!in_array($user->role, $roles)) {
            Log::error('RoleMiddleware - Role mismatch:', [
                'user_role' => $user->role,
                'required_roles' => $roles,
                'user_id' => $user->id
            ]);
            abort(403, 'Unauthorized action.');
        }

        Log::info('RoleMiddleware - Access granted for user:', [
            'user_id' => $user->id,
            'user_role' => $user->role
        ]);

        return $next($request);
    }
}
