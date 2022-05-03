<?php

namespace App\Http\Requests\Payment;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order_id'=>'required',
            'payment_type'=>'required',
            'payment_date'=>'required',
            'amount'=>'required',
            'currency'=>'required',
            'currency_kurs'=>'required',
            'amount_real'=>'required',
        ];
    }
}
