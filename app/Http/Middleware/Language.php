<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Language {

    public function __construct(Application $app, Redirector $redirector, Request $request)
    {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }
    
    public function handle($request, \Closure $next)
    {
        $locale = $request->route()->parameter('locale');

        if ($locale)
        {
            $this->app->session->set('app.locale', $locale);
            $this->app->setLocale($locale);
        }

        return $next($request);
    }
}