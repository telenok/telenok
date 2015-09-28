<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Routing\Middleware;

class Language implements Middleware {

	public function __construct(Application $app, Redirector $redirector, Request $request)
	{
		$this->app = $app;
		$this->redirector = $redirector;
		$this->request = $request;
	}

	public function handle($request, Closure $next)
	{
		$localeUrl = $request->segment(1);
        $localeCurrent = $this->app->config->get('app.locale');
        $sessionLocale = $this->app->session->get('app.locale');
        
        \Illuminate\Support\Collection::make();
        
		if ($localeUrl !== $sessionLocale && in_array($localeUrl, $this->app->config->get('app.locales')->all(), true))
		{
            $this->app->session->set('app.locale', $localeUrl);
            $this->app->setLocale($localeUrl);
		}
        else if ($sessionLocale)
        {
            $this->app->setLocale($sessionLocale);    
        }
        else if (!$sessionLocale)
        {
            $this->app->session->set('app.locale', $localeCurrent);
            $this->app->setLocale($localeCurrent);
        }

        dd( $this->app->getLocale() );

		return $next($request);
	}
}