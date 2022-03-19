<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "client_type" => "required",
            "fname" => "nullable",
            "lname" => "nullable",
            "mname" => "nullable",
            "pinfl" => "nullable",
            "pnumber" => "nullable",
            "psery" => "nullable",
            "dbirth" => "nullable",
            "phone_number" => "nullable",
            "inn" => "nullable",
            "company_name" => "nullable",
            "occupation" => "nullable",
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
            "id" => "prohibited",
            "client_type" => "nullable",
            "fname" => "nullable",
            "lname" => "nullable",
            "mname" => "nullable",
            "pinfl" => "nullable",
            "pnumber" => "nullable",
            "psery" => "nullable",
            "dbirth" => "nullable",
            "phone_number" => "nullable",
            "inn" => "nullable",
            "company_name" => "nullable",
            "occupation" => "nullable",
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
