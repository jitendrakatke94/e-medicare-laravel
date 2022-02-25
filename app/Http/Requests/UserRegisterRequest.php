<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRegisterRequest extends FormRequest
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
        dd("abcd");
        return [
            'first_name' => 'required|max:50',
            'middle_name' => 'nullable|max:50|present',
            'last_name' => 'required|max:50',
            'password' => ['required', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'confirmed'],
            'country_code' => 'required',
            'mobile_number' => 'required|string|unique:users,mobile_number,NULL,id,deleted_at,NULL',
            'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
            'username' => 'required|min:4|max:15|unique:users,username,NULL,id,deleted_at,NULL',
            'user_type' => [
                'required',
                Rule::in(['PATIENT', 'DOCTOR']),
            ],
            'login_type' => [
                'required',
                Rule::in(['WEB', 'FACEBOOK', 'GOOGLE']),
            ],
        ];
    }
}
