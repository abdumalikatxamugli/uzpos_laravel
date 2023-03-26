<?php

namespace App\Http\Requests\User;

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
            "first_name"=>"required",
            "last_name"=>"required",
            "username"=>["required","unique:users"],
            "password"=>"required",
            "is_active"=>"required",
            "division_id"=>"required",
            "password"=>"required",
            "phone"=>["required", "size:9"],
            "user_role"=>"required",
        ];
    }
    public function all($keys = null)
    {
        $data = parent::all();
        $data['phone'] = cleanPhoneNumber($data['phone']);
        return $data;
    }
}

