<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            case 'employeeBasicInfo':
            case 'editEmployeeBasicInfo':
                $validate =  [
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
                    'age' => 'required',
                    'country_code' => 'required',
                    'mobile_number' => 'required|string|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                    'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
                    'date_of_joining' => 'nullable|date_format:Y-m-d',
                    'role' => 'required|array|min:1',
                    'role.*' => 'required|integer|exists:roles,id'
                ];
                if ($this->route()->getName() == 'editEmployeeBasicInfo') {
                    $validate['mobile_number'] =  [
                        'required',
                        Rule::unique('users')->ignore($this->id),
                    ];
                    $validate['email'] = [
                        'required',
                        Rule::unique('users')->ignore($this->id),
                    ];
                }

                return $validate;
                break;
            case 'employeeAddress':
            case 'editEmployeeAddress':
                $validate = [
                    'user_id' => 'required|integer',
                    'pincode' => 'required|digits:6',
                    'street_name'  => 'required|string',
                    'city_village'  => 'required|string',
                    'district'   => 'required|string',
                    'state'   => 'required|string',
                    'country' => 'required|string',
                ];
                if ($this->route()->getName() == 'editEmployeeAddress') {
                    unset($validate['user_id']);
                }
                return $validate;
                break;
            default:
                return [];
                break;
        }
    }
}
