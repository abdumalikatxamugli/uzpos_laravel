<?php

namespace App\Http\Requests\Debt;

use Illuminate\Foundation\Http\FormRequest;

class RepayRequest extends FormRequest
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
            'payload'=>[
                function($attribute, $payload, $fail){
                    if($payload->payment->amount_real < $payload->amount){
                        $fail('Сумма погашения не может быть больше суммы задолженности');
                    }
                }
            ],
            'amount'=>['required']
        ];
    }
    public function all($keys=null){
        $data = parent::all();
        $data['payload']=(object) ['payment'=>$this->route('payment'), 'amount'=>$this->input('amount')];
        return $data;
    }
}
