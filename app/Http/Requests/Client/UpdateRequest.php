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
            "phone_number"=>"required|unique:uzpos_sales_client,phone_number,".$this->client->id,
            "region"=>"nullable"
        ];
    }
}

