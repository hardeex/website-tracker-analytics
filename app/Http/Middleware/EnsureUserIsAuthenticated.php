<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class EnsureUserIsAuthenticated
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not authenticated. Please login.'], 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired. Please login again.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid token. Please login again.'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'Authorization token not found. Please login.'], 401);
        }

        return $next($request);
    }
}
