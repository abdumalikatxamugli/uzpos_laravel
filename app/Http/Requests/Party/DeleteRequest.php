<?php

namespace App\Http\Requests\Party;

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
            'party'=>[
                function($attribute, $value, $fail){
                    if(count($value->items)>0){
                        $fail("Party with items inside can not be deleted, please remove items first");
                    }
                }
            ]
        ];
    }
    public function all($keys = null){
        $data = parent::all();
        $data['party'] = $this->route('party');
        return $data;
    }
}
