<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "name"=>"required",
            "bar_code"=>"required",
            "bulk_price"=>"required",
            "one_price"=>"required",
            "alert_limit"=>"required",
            "category_id"=>"nullable",
            "brand_id"=>"nullable",
            "metric_id"=>"nullable"
        ];
    }
}

