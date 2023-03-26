<?php

namespace App\Http\Requests\Client;

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
            "client_type"=>"required",
            "fname"=>"exclude_if:client_type,1|required",
            "lname"=>"exclude_if:client_type,1|required",
            "mname"=>"nullable",
            "dbirth"=>"nullable",
            "occupation"=>"nullable",
            "inn"=>"exclude_if:client_type,0|required",
            "company_name"=>"exclude_if:client_type,0|required",
            "phone_number"=>["required","unique:clients,phone_number,".$this->client->id,"size:9"],
            "region_id"=>"nullable"
        ];
    }
    public function all($keys = null)
    {
        $data = parent::all();
        $data['phone_number'] = cleanPhoneNumber($data['phone_number']);
        return $data;
    }
}

