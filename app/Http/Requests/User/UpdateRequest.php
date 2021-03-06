<?php

namespace App\Http\Requests\User;

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
            "first_name"=>"required",
            "last_name"=>"required",
            "username"=>"required",
            "password"=>"required",
            "is_active"=>"required",
            "point_id"=>"required",
            "password"=>"nullable",
            "phone"=>"required",
            "user_role"=>"required",
        ];
    }
}

