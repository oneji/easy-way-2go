<?php

namespace App\Http\Middleware;

use Closure;

class CheckDriver
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
        if(!auth('client')->check()) {
            return response()->json([
                'ok' => false,
                'message' => 'Fuck off!'
            ]);
        }

        return $next($request);
    }
}
