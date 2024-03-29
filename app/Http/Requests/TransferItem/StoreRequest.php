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
            "transfer_id"=>"required"
        ];
    }
}

        