<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HealthAssociateRequest extends FormRequest
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
        switch ($this->route()->getName()) {
            case 'health.basicinfo':
                return
                    [
                        'first_name' => 'required|max:50',
                        'middle_name' => 'nullable|max:50|present',
                        'last_name' => 'required|max:50',
                        'father_first_name' => 'required|max:50',
                        'father_middle_name' => 'nullable|max:50|present',
                        'father_last_name' => 'required|max:50',
                        'gender' => [
                            'required',
                            Rule::in(['MALE', 'FEMALE', 'OTHERS']),
                        ],
                        'date_of_birth' => 'required|date_format:Y-m-d',
                        'age' => 'required|numeric',
                        'country_code' => 'required',
                        'mobile_number' => 'required|string|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                        'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
                        'resume' => 'required|file|mimes:doc,pdf,docx,zip|max:2048'
                    ];
                break;
            case 'health.address':
                return
                    [
                        'data_id' => 'required|integer',
                        'pincode' => 'required|digits:6',
                        'street_name'  => 'required|string',
                        'city_village'  => 'required|string',
                        'district'   => 'required|string',
                        'state'   => 'required|string',
                        'country' => 'required|string',
                    ];
                break;
            case 'edit.health.address':
                return
                    [
                        'address_id' => 'required|integer|exists:addresses,id,user_id,' . auth()->user()->id,
                        'pincode' => 'required|digits:6',
                        'street_name'  => 'required|string',
                        'city_village'  => 'required|string',
                        'district'   => 'required|string',
                        'state'   => 'required|string',
                        'country' => 'required|string',
                    ];
                break;
            case 'edit.health.profile':
                return [
                    'email' => [
                        'required',
                        Rule::unique('users')->ignore(auth()->user()->id),
                        'email:rfc,strict,filter',
                    ],
                    'mobile_number' => [
                        'required',
                        Rule::unique('users')->ignore(auth()->user()->id),
                    ],
                    'country_code' => 'required',
                ];
                break;
            default:
                return [];
                break;
        }
    }
    public function messages()
    {
        return [
            'resume.mimes' => 'The resume must be of file type doc,pdf,docx.'
        ];
    }
}
