<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();

            if ($user && !$user->is_active) {
                Auth::logout();

                // Return JSON for API requests
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'message' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.'
                    ], 403);
                }

                // Redirect for web requests
                return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.');
            }
        }

        return $next($request);
    }
}
