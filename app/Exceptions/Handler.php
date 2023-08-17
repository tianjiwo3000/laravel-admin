<?php

namespace App\Exceptions;

use App\Library\Y;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Throwable $exception)
    {
        if($request->route()) {
            switch ($request->route()->getPrefix()) {
                case 'admin':
                    if ($request->expectsJson()) {
                        return Y::error($exception->getMessage(), 'error');
                    }
                case 'api':
                    if ($request->expectsJson()) {
                        return prompt($exception->getMessage(), 'error');
                    }
                    break;
                case 'web':
                    break;
            }
        }
        return parent::render($request, $exception);
    }
}
