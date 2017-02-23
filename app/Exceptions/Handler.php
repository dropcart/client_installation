<?php

namespace App\Exceptions;

use Dropcart\ClientException;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $dcException = \Dropcart\ClientException::class;
        if($e instanceof $dcException)
        {
            // DropCart Client / Error
            $logger = app('Psr\Log\LoggerInterface');
            $logger->critical($e);
        }
        else {
            parent::report($e);
        }
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
        try {
            return response()->make(view('error'), 404);
        } catch (\Exception $e)
        {
            return parent::render($request, $e);
        }
    }
}
