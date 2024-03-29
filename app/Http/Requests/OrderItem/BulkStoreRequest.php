<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'items.*.order_id'=>'required',
            'items.*.product_id'=>'required',
            'items.*.price'=>'required',
            'items.*.quantity'=>'required'
        ];
    }
    public function all($keys = null)
    {
        $data = parent::all($keys);
        foreach ($data['items'] as $key => $item)
        {
            if(empty($item['product_id']))
            {
                unset($data['items'][$key]);
            }
        }
        return $data;
    }
}
