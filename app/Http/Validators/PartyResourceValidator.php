<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
/**
 * It is quality rather than quantity that matters. - Lucius Annaeus Seneca
 */
class PartyResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>"prohibited",
            "point" => "required",
            "check_in"=>"required"
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
            "id"=>"prohibited",
            "point" => "nullable",
            "check_in"=>"nullable"
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
