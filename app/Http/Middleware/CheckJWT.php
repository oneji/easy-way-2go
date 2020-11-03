<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class CheckJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // Get the user from token
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'ok' => false,
                    'error' => 'Token is invalid'
                ], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'ok' => false,
                    'status' => 'Token is expired'
                ], 401);
            } else {
                return response()->json([
                    'ok' => false,
                    'status' => 'Token not found.'
                ], 401);
            }
        }

        return $next($request);
    }
}