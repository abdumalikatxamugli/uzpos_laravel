<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        UnexpectedErrorException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
        $this->renderable(function (UnexpectedErrorException $e) {
            return response()->json([
                'error'=>-1,
                'message'=>'unexpected error occured'
            ], 500);
        });
        $this->renderable(function (WrongCredentialsException $e) {
            return response()->json([
                'error'=>-1,
                'message'=>'Wrong credentials'
            ], 400);
        });
        $this->renderable(function (UnauthorizedException $e) {
            return response()->json([
                'error'=>-1,
                'message'=>'Unauthorized'
            ], 400);
        });
        $this->renderable(function (WrongContentTypeException $e) {
            return response()->json([
                'error'=>-1,
                'message'=>'Set content type to application/json'
            ], 500);
        });
        $this->renderable(function (NotFoundException $e) {
            return response()->json([
                'error'=>-1,
                'message'=>'Not found'
            ], 404);
        });
    }
}
