<?php

namespace App\Telenok\Core\Middleware;

use Closure; 

class SessionTimeout {

    protected $timeout = 1200;

    public function __construct()
    {
        $this->timeout = config('auth.logout.period', 20);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('lastActivityTime'))
        {
            session(['lastActivityTime' => time()]);
        }
        elseif (time() - session('lastActivityTime') > $this->timeout * 60)
        {
            session()->forget('lastActivityTime');
            
            app('auth')->logout();
        }
        else
        {
            session(['lastActivityTime' => time()]);
        }
    
        return $next($request);
    }

}
