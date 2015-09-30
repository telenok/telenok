<?php

namespace App\Telenok\Core\Middleware;

use Closure;

class AuthBackendModule {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $key = '')
    {
        if (!app()->runningInConsole() && !app('auth')->can('read', $key))
        {
            return app('redirect')->route('error.access-denied');
        }
        
        return $next($request);
    }
}