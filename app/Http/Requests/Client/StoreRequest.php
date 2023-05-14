<?php

namespace App\Http\Requests\Client;

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
            "client_type"=>"required",
            "first_name"=>"exclude_if:client_type,1|required",
            "last_name"=>"exclude_if:client_type,1|required",
            "middle_name"=>"nullable",
            "pinfl"=>"nullable",
            "passport_sery"=>"nullable",
            "passport_number"=>"nullable",
            "date_birth"=>"nullable",
            "occupation"=>"nullable",
            "inn"=>"exclude_if:client_type,0|required",
            "company_name"=>"exclude_if:client_type,0|required",
            "phone_number"=>["required", "unique:clients", "size:9"],
            "region_id"=>'nullable'
        ];
    }
    public function all($keys = null)
    {
        $data = parent::all();
        $data['phone_number'] = cleanPhoneNumber($data['phone_number']);
        return $data;
    }
}

