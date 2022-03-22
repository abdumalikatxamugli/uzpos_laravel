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
            "mname"=>"exclude_if:client_type,1|required",
            "dbirth"=>"exclude_if:client_type,1|required",
            "occupation"=>"exclude_if:client_type,1|required",
            "inn"=>"exclude_if:client_type,0|required",
            "company_name"=>"exclude_if:client_type,0|required",
            "phone_number"=>"required",
        ];
    }
}

