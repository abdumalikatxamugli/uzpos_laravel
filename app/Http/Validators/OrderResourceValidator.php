<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "client" => "required",
            "shop" => "required",
            "order_type" => "required",
            "collector" => "nullable",
            "deliver" => "nullable",
            "address" => "nullable",
            "status" => "nullable",
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
            "client" => "nullable",
            "shop" => "nullable",
            "order_type" => "nullable",
            "collector" => "nullable",
            "deliver" => "nullable",
            "address" => "nullable",
            "status" => "nullable",
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
