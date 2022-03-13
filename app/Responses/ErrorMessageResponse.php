<?php
namespace App\Responses;

class ErrorMessageResponse{
    public static function send($error, $message){
        return response()->json([
            'error'=>$error,
            'messaage'=>$message
        ], 200);
    }
}
