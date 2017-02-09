<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Application;

class UrlGeneratorParameters {

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // available in Laravel 5.4
        //$this->app->url->setDefaultNamedParameters("telenok_domain", $request->server->get('HTTP_HOST'));

        return $next($request);
    }
}
