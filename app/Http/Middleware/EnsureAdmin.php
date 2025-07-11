<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::user();
        if (!$user->is_admin) { 
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}