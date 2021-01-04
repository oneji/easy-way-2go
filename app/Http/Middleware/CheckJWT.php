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
            $payload = JWTAuth::parseToken()->getPayload();

            $request->merge([ 'authUser' => $payload['user'] ]);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'success' => false,
                    'message' => 'Token is invalid'
                ], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'success' => false,
                    'message' => 'Token is expired'
                ], 401);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Token is not provided'
                ], 401);
            }
        }

        return $next($request);
    }
}
