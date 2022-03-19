<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
/**
 * It is quality rather than quantity that matters. - Lucius Annaeus Seneca
 */
class TransferResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "from_point" => "required",
            "to_point" => "required",
            "reason" => "nullable",
            "transfer_date" => "required",
            "is_accepted" => "nullable"
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
            "from_point" => "nullable",
            "to_point" => "nullable",
            "reason" => "nullable",
            "transfer_date" => "nullable",
            "is_accepted" => "nullable"
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
