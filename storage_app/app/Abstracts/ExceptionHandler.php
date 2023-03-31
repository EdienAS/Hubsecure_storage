<?php

namespace App\Abstracts;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ExceptionHandler
 * @package App\Abstracts
 */
class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
//        AuthenticationException::class,
//        AuthorizationException::class,
//        HttpException::class,
//        TokenMismatchException::class,
//        HttpException::class,
//        ModelNotFoundException::class,
//        ValidationException::class,
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
    public function report(Exception $exception)
    {
        parent::report($exception);
    }
    
    
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ExceptionHttp) {
            return $exception->render();
        }

        if($request->isJson() || $request->expectsJson()) {
            return $this->returnJsonResponse(
                $exception->getMessage(),
                method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : $exception->getCode()
            );
        }
        
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->isJson() || $request->expectsJson()) {
            return $this->returnJsonResponse('Unauthenticated.', 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * @param $message
     * @param $code
     *
     * @return \Illuminate\Http\Response
     */
    private function returnJsonResponse($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }
}
