<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
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
            case 'patient.profile.edit':
            case 'editPatientProfile':
                $rules =  [
                    'title' => 'required',
                    'first_name' => 'required|max:50',
                    'middle_name' => 'nullable|max:50|present',
                    'last_name' => 'required|max:50',
                    'gender' => [
                        'required',
                        Rule::in(['MALE', 'FEMALE', 'OTHERS']),
                    ],
                    'date_of_birth' => 'required',
                    'age' => 'required',
                    'blood_group' => 'nullable|present',
                    'height' => 'nullable|present',
                    'weight' => 'nullable|present',
                    'marital_status' => [
                        'nullable',
                        Rule::in(['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']),
                        'present'
                    ],
                    'occupation' => 'nullable|present',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    'email' => [
                        'required',
                        Rule::unique('users')->ignore(auth()->user()->id),
                    ],
                    'mobile_number' => [
                        'required',
                        Rule::unique('users')->ignore(auth()->user()->id),
                    ],
                    'country_code' => 'required',
                    'profile_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                    'national_health_id' => 'nullable|string'
                ];
                if ($this->route()->getName() == 'editPatientProfile') {
                    $rules['email'] = [
                        'required',
                        Rule::unique('users')->ignore($this->id),
                    ];
                    $rules['mobile_number'] = [
                        'required',
                        Rule::unique('users')->ignore($this->id),
                    ];
                }
                return $rules;
                break;

            case 'patient.address.add':
            case 'patient.address.edit':
            case 'admin.patient.address.edit':
                return [
                    'pincode' => 'required|digits:6',
                    'street_name'  => 'required|string',
                    'city_village'  => 'required|string',
                    'district'   => 'required|string',
                    'state'   => 'required|string',
                    'country' => 'required|string',
                    'contact_number' => 'present',
                    'country_code' => 'present',
                    'land_mark' => 'present',
                    'address_type' => [
                        'required',
                        Rule::in(['HOME', 'WORK', 'OFFICE', 'OTHERS']),
                    ],

                ];
                break;
            case 'patient.contact.emergency':
            case 'admin.patient.emergency':
                return [
                    'current_medication' => 'nullable|string|present',
                    'bpl_file_number' => 'nullable|present',
                    'bpl_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                    'first_name_primary' => 'required|string',
                    'middle_name_primary' => 'nullable|string|present',
                    'last_name_primary' => 'required|string',
                    'mobile_number_primary' => 'required|string',
                    'country_code_primary' => 'required',
                    'relationship_primary' => [
                        'required',
                        Rule::in(['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER', 'BROTHER', 'OTHERS']),
                    ],
                    'first_name_secondary' => 'nullable|string|present',
                    'middle_name_secondary' => 'nullable|string|present',
                    'last_name_secondary' => 'nullable|string|present',
                    'mobile_number_secondary' => 'nullable|string|present',
                    'country_code_secondary' => 'required_with:mobile_number_secondary|present',
                    'relationship_secondary' => [
                        'nullable',
                        Rule::in(['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER', 'BROTHER', 'OTHERS']),
                        'present'
                    ],
                ];
                break;
            case 'patient.family.add':
            case 'patient.family.edit':
            case 'admin.patient.family.edit':
                return [
                    'title' => 'required',
                    'first_name' => 'required|max:50',
                    'middle_name' => 'nullable|max:50|present',
                    'last_name' => 'required|max:50',
                    'gender' => [
                        'required',
                        Rule::in(['MALE', 'FEMALE', 'OTHERS']),
                    ],
                    'date_of_birth' => 'required|date_format:Y-m-d',
                    'age' => 'required',
                    'height' => 'nullable|present',
                    'weight' => 'nullable|present',
                    'marital_status' => [
                        'nullable',
                        Rule::in(['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']),
                        'present'
                    ],
                    'relationship' => [
                        'required',
                        Rule::in(['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER', 'BROTHER', 'OTHERS']),
                    ],
                    'occupation' => 'nullable|present',
                    'current_medication' => 'nullable|present',
                    'country_code' => 'nullable|present',
                    'contact_number' => 'nullable|present',
                    'national_health_id' => 'nullable|string'
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
