<?php

namespace App\Http\Middleware;

use App\Jobs\NewOrderEmailNotificationJob;
use Closure;
use Illuminate\Support\Facades\DB;

class EmailNotificationsMiddleware
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
        $response = $next($request);
        
        // Handle order notifications....
        $order = $response->original['data'];
        
        NewOrderEmailNotificationJob::dispatch($order);

        return $response;
    }
}
