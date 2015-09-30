<?php

namespace App\Telenok\Core\Middleware;

use Closure;
use Illuminate\Session\Store;

class AuthBackend {

    public function getSpecialRoutes()
    {
        return [
				'error.access-denied', 
				'telenok.login.process',
                'telenok.validate.session',
				'telenok.password.reset.email.process', 
				'telenok.password.reset.token',
				'telenok.password.reset.token.process'
			];
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
        $routeName = $request->route()->getName();

		if (!in_array($routeName, $this->getSpecialRoutes(), true) && !app()->runningInConsole())
		{
            if (config('app.acl.enabled'))
            {
                $accessControlPanel = app('auth')->can('read', 'control_panel');
            }
            else
            {
                $accessControlPanel = app('auth')->hasRole('super_administrator');
            }

            if (!$accessControlPanel && $routeName != 'telenok.login.control-panel')
            {
                if ($request->ajax())
                {
                    return response()->json(['error' => 'Unauthorized'], 403 /* Denied */);
                }
                else if (app('auth')->guest())
                {
                    return redirect()->route('telenok.login.control-panel');
                }
                else
                {
                    return redirect()->route('error.access-denied');
                }
            }
            else if ($routeName != 'telenok.login.control-panel' && (\Request::is('telenok', 'telenok/*')) && app('auth')->guest())
            {
                return redirect()->route('telenok.login.control-panel');
            }
            else if (\Request::is('telenok/login') && !app('auth')->guest() && $accessControlPanel)
            {
                return redirect()->route('telenok.content');
            }
        }

        return $next($request);
    }
}