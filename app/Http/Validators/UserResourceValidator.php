<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
/**
 * It is quality rather than quantity that matters. - Lucius Annaeus Seneca
 */
class UserResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "is_active" => "required",
            "user_role" => "required",
            "point_id" => "required",
            "token" => "prohibited",
            "id"=> "prohibited",
            "phone"=>"nullable"
        ]);
        if ($validator->fails()) {
            $message = [
                "error"=>-1,
                "messages"=>$validator->errors()
            ];
            throw new HttpResponseException(response()->json($message), 422);
        }
        return $validator->validated();
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            "username" => "prohibited",
            "password" => "nullable",
            "first_name" => "nullable",
            "last_name" => "nullable",
            "is_active" => "nullable",
            "user_role" => "nullable",
            "point_id" => "nullable",
            "token" => "prohibited",
            "id"=> "prohibited",
            "phone"=>"nullable"
        ]);
        if ($validator->fails()) {
            $message = [
                "error"=>-1,
                "messages"=>$validator->errors()
            ];
            throw new HttpResponseException(response()->json($message), 422);
        }
        return $validator->validated();
    }
}
