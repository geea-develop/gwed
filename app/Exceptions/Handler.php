<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\TokenMismatchException;
use MongoDB\Operation\Executable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function render($request, Exception $exception)//
    {
        if ($this->isTokenMismatch($exception) && $request->route()->uri() === 'logout')
            return redirect()->guest(route('login'));

        if ($this->isInvalidFields($exception))
            return $this->handleInvalidFieldsException($exception);


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

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    private function isTokenMismatch($exception)
    {
        return ($exception instanceof TokenMismatchException);
    }

    private function isInvalidFields($exception)
    {
        return ($exception instanceof InvalidFieldsException);
    }

    /**
     * @param $exception InvalidFieldsException | \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleInvalidFieldsException($exception)
    {
        return response()->json(['file' => [ 0 => "File upload failed. {$exception->getMessage()}. Please check the file or documentation and try again."]], 422);
    }
}
