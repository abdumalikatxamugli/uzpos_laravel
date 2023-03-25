<?php

namespace App\Http\Requests\TransferItem;

use App\Models\PointProduct;
use App\Models\TransferItem;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
     
        return [
            "product_id"=>"required",
            "quantity"=>"required",
            "transfer_id"=>"required",
            'item' => [
                function($attribute, $item, $fail){
                    $fromPointProduct = PointProduct::where([
                        'product_id'=> $item->product_id,        
                        'division_id'=> $item->transfer->from_point_id
                    ])->first();
                        
                    if(!$fromPointProduct || $fromPointProduct->quantity < $item->quantity){
                        $fail('Warehouse or Shop does not have enough items to complete this operation');
                    }
                }
            ]
        ];
    }
    public function validated($key = null, $default = null){
        $data = parent::validated();
        unset( $data['item'] );
        return $data;
    }
    
    public function all($keys = null){
        $data = parent::all();
        $item = new TransferItem();
        $item->product_id = $data['product_id'];
        $item->quantity = $data['quantity'];
        $item->transfer_id = $data['transfer_id'];
        $data['item'] = $item;
        return $data;
    }
}

        