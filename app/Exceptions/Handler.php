<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthenticationException || $e instanceof AuthorizationException)
        {
            if ($request->expectsJson())
            {
                return response()->json([
                    'status' => 'unauthorized',
                    'message' => 'ابتدا وارد سابت شوید'
                ]);
            }
           parent::render($request, $e);
        }

        parent::render($request, $e);
    }

}
