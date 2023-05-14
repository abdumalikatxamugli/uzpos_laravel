<?php

namespace App\Exceptions;

use App\Responses\ErrorMessageResponse;
use Illuminate\Database\QueryException;
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
            return ErrorMessageResponse::send(-1, 'unexpected error occured', 500);
        });
        $this->renderable(function (WrongCredentialsException $e) {
            return ErrorMessageResponse::send(-1, 'Wrong credentials', 400);
        });
        $this->renderable(function (UnauthorizedException $e) {
            return ErrorMessageResponse::send(-1, 'Unauthorized', 400);
        });
        $this->renderable(function (WrongContentTypeException $e) {
            return ErrorMessageResponse::send(-1, 'Set content type to application/json', 500);
        });
        $this->renderable(function (NotFoundException $e) {
            return ErrorMessageResponse::send(-1, 'Not found', 400);
        });
        $this->renderable(function (QueryException $e){
            if($e->getCode() == "23000")
            {
                session()->flash('queryException', 'Ограничение целостности будет нарушено, если вы удалите элемент, поэтому система остановила действие удаления.');
                return redirect()->back();
            }
        });
    }
}
