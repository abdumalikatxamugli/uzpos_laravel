<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;


class TransferItemResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "product_id" => "required",
            "transfer_id" => "required",
            "quantity" => "required"
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
            "product_id" => "nullable",
            "transfer_id" => "nullable",
            "quantity" => "nullable"
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
