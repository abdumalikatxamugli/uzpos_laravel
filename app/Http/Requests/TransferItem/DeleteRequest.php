<?php

namespace App\Http\Requests\TransferItem;

use App\Models\PointProduct;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
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
            // 'item' => [
            //     function($attribute, $item, $fail){
                    
            //         $toPointProduct = PointProduct::where([
            //             'product_id'=> $item->product_id,        
            //             'point_id'=> $item->transfer->to_point_id
            //         ])->first();
              
            //         if($toPointProduct->quantity < $item->quantity){
            //             $fail('Warehouse or shop does not have enough items to cancel the record');   
            //         }
                    
            //     }
            // ]
        ];
    }
    public function all($keys = null){
        $data = parent::all();
        $data['item'] = $this->route('transferItem');
        return $data;
    }
}
