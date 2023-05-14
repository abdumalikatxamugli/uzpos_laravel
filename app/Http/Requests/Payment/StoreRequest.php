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
            'payed_amount'=>'required',
            'payed_currency_type'=>'required',
            'payed_currency_rate'=>'required',
            'change_amount'=>'required',
            'change_currency_type'=>'required',
            'change_currency_rate'=>'required'
        ];
    }
}
