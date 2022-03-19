<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderItemResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "order" => "required",
            "product" => "required",
            "price" => "required",
            "quantity" => "required",
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
            "order" => "nullable",
            "product" => "nullable",
            "price" => "nullable",
            "quantity" => "nullable",
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
