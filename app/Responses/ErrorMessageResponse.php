<?php
namespace App\Responses;

class ErrorMessageResponse{
    public static function send($error, $message, $status = 200){
        return response()->json([
            'error'=>$error,
            'messaage'=>$message
        ], $status);
    }
}
