<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
/**
 * It is quality rather than quantity that matters. - Lucius Annaeus Seneca
 */
class PointResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "longitude"=>"nullable",
            "latitude"=>"nullable",
            "point_type"=>"integer",
            "debt"=>"prohibited",
            "id"=>"prohibited"
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
            "name" => "nullable",
            "longitude"=>"nullable",
            "latitude"=>"nullable",
            "point_type"=>"nullable|integer",
            "debt"=>"prohibited",
            "id"=>"prohibited"
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
