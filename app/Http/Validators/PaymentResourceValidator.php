<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaymentResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "order" => "required",
            "payment_type" => "required",
            "amount" => "required",
            "currency" => "required",
            "currency_kurs" => "required",
            "amount_real" => "required"
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
            "order" => "prohibited",
            "payment_type" => "prohibited",
            "amount" => "nullable",
            "currency" => "nullable",
            "currency_kurs" => "nullable",
            "amount_real" => "nullable"
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
