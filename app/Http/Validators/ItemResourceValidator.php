<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
/**
 * It is quality rather than quantity that matters. - Lucius Annaeus Seneca
 */
class ItemResourceValidator{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "party" => "required",
            "product" => "required",
            "quantity" => "required"
        ]);
        /**
         *
         * party = models.ForeignKey(Party, on_delete=RESTRICT, related_name='items')
    product = models.ForeignKey(Product, on_delete=RESTRICT)
    quantity = models.IntegerField(null=True, default=0)
    updated_at = models.DateTimeField(auto_now=True)
         */
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
            "party" => "nullable",
            "product" => "nullable",
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
