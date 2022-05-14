<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientAppendValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "client_type"=>"required",
            "fname"=>"exclude_if:client_type,1|required",
            "lname"=>"exclude_if:client_type,1|required",
            "mname"=>"nullable",
            "pinfl"=>"nullable",
            "psery"=>"nullable",
            "pnumber"=>"nullable",
            "dbirth"=>"nullable",
            "occupation"=>"exclude_if:client_type,1|required",
            "inn"=>"exclude_if:client_type,0|required",
            "company_name"=>"exclude_if:client_type,0|required",
            "phone_number"=>"required|unique:uzpos_sales_client",
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
            "client_type"=>"required",
            "fname"=>"exclude_if:client_type,1|required",
            "lname"=>"exclude_if:client_type,1|required",
            "mname"=>"nullable",
            "pinfl"=>"nullable",
            "psery"=>"nullable",
            "pnumber"=>"nullable",
            "dbirth"=>"nullable",
            "occupation"=>"exclude_if:client_type,1|required",
            "inn"=>"exclude_if:client_type,0|required",
            "company_name"=>"exclude_if:client_type,0|required",
            "phone_number"=>"required|unique:uzpos_sales_client",
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