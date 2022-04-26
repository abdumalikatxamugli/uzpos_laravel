<?php

namespace App\Http\Requests\Transfer;

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
            'transfer'=>[
                function($attribute, $value, $fail){
                    if(count($value->items)>0){
                        $fail("Transfer with items inside can not be deleted, please remove transfer items first");
                    }
                }
            ]
        ];
    }
    public function all($keys = null){
        $data = parent::all();
        $data['transfer'] = $this->route('transfer');
        return $data;
    }
}
