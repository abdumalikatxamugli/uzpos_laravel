<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class FinishRequest extends FormRequest
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
            'transfer'=>function($attribute, $transfer, $fail){
                foreach($transfer->items as $item){
                    $item->validateStore($fail);
                }
            }
        ];
    }
    public function all($keys = null){
        $data = parent::all();
        $data['transfer'] = $this->route('transfer');
        return $data;
    }
}
