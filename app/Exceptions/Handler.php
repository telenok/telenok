<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (\Config::get('app.debug'))
        {
            $whoops = new \Whoops\Run;

            if ($request->ajax())
            {
                $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
            }
            else
            {
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
            }

            return new Response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
        }
        else
        {
            $statusCode = $this->isHttpException($e) ? $e->getStatusCode() : '';

            switch ($statusCode)
            {
                case '404':
                    return response()->view('errors/404');
                case '503':
                default:
                    return response()->view('errors/503');
            }
        }

        return parent::render($request, $e);
    }
}
