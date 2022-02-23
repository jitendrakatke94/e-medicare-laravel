<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdministratorRequest extends FormRequest
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
            case 'administrator.add.patient':
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
                    'blood_group' => 'nullable|present',
                    'height' => 'nullable|present',
                    'weight' => 'nullable|present',
                    'marital_status' => [
                        'nullable',
                        Rule::in(['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']),
                        'present'
                    ],
                    'occupation' => 'nullable|present',
                    'mobile_number' => 'required|string|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                    'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
                    'country_code' => 'required',
                    'profile_photo' => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'nullable|required_with:alt_mobile_number|present',
                    'national_health_id' => 'nullable|present',
                    'pincode' => 'sometimes|required|digits:6|present',
                    'street_name'  => 'sometimes|required|string|present',
                    'city_village'  => 'sometimes|required|string|present',
                    'district'   => 'sometimes|required|string|present',
                    'state'   => 'sometimes|required|string|present',
                    'country' => 'sometimes|required|string|present',
                    'address_type' => [
                        'required',
                        Rule::in(['HOME', 'WORK', 'OTHERS']),
                        'present'
                    ],
                    'current_medication' => 'nullable|string|present',
                    'bpl_file_number' => 'nullable|present',
                    'bpl_file' => 'required_with:bpl_file_number|file|mimes:pdf,jpg,jpeg,png|max:2048',
                    'first_name_primary' => 'sometimes|required|string|present',
                    'middle_name_primary' => 'nullable|string|present',
                    'last_name_primary' => 'sometimes|required|string|present',
                    'mobile_number_primary' => 'sometimes|required|string|present',
                    'country_code_primary' => 'sometimes|required|present',
                    'relationship_primary' => [
                        'sometimes',
                        'required',
                        Rule::in(['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER', 'BROTHER', 'OTHERS']),
                        'present'
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
            case 'administrator.add.doctor':
                return [
                    'first_name' => 'required|max:50|present',
                    'middle_name' => 'nullable|max:50|present',
                    'last_name' => 'required|max:50|present',
                    'gender' => [
                        'required',
                        Rule::in(['MALE', 'FEMALE', 'OTHERS']),
                    ],
                    'date_of_birth' => 'required|date_format:Y-m-d',
                    'age' => 'required',
                    'qualification' => 'required',
                    'specialization' => 'required|array|min:1',
                    'years_of_experience' => 'required',
                    'mobile_number' => 'required|string|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                    'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
                    'country_code' => 'required',
                    'profile_photo' => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    //home adress
                    'clinic_name' => 'nullable|present',

                    'pincode' => 'present|digits:6|nullable',
                    'street_name'  => 'present|string|nullable',
                    'city_village'  => 'present|string|nullable',
                    'district'   => 'present|string|nullable',
                    'state'   => 'present|string|nullable',
                    'country' => 'present|string|nullable',

                    //clinic address
                    'address' => 'required|array|min:1',
                    'address.*.clinic_name' => 'required|string',
                    'address.*.pincode' => 'required|digits:6',
                    'address.*.street_name'  => 'required|string',
                    'address.*.city_village'  => 'required|string',
                    'address.*.district'   => 'required|string',
                    'address.*.state'   => 'required|string',
                    'address.*.country' => 'required|string',
                    'address.*.contact_number' => 'nullable|present',
                    'address.*.country_code' => 'required_with:contact_number|present',

                    'address.*.pharmacy_list' => 'nullable|array',
                    'address.*.pharmacy_list.*' => ['integer', 'distinct', 'exists:pharmacies,id,deleted_at,NULL'],
                    'address.*.laboratory_list' => 'nullable|array',
                    'address.*.laboratory_list.*' => ['integer', 'distinct', 'exists:laboratory_infos,id,deleted_at,NULL'],


                    'address.*.latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                    'address.*.longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                    'career_profile' => 'required|string',
                    'education_training' => 'required|string',
                    'clinical_focus' => 'nullable|present',
                    'awards_achievements' => 'nullable|present',
                    'memberships' => 'nullable|present',
                    'experience' => 'nullable|string|present',
                    'service' => [
                        'required',
                        Rule::in(['INPATIENT', 'OUTPATIENT', 'BOTH'])
                    ],
                    'appointment_type_online' => 'nullable|boolean|present',
                    'appointment_type_offline' => 'nullable|boolean|present',
                    'currency_code' => 'required|string',
                    'consulting_online_fee' => 'required_if:appointment_type_online,1|regex:/^\d+(\.\d{1,2})?$/',
                    'consulting_offline_fee' => 'required_if:appointment_type_offline,1|regex:/^\d+(\.\d{1,2})?$/|present',
                    'emergency_fee' => 'numeric|regex:/^\d+(\.\d{1,2})?$/|present',
                    'emergency_appointment' => 'nullable|numeric|present',
                    'no_of_followup' => 'required|numeric|between:1,10',
                    'followups_after' => 'required|numeric|between:1,4',
                    'cancel_time_period' => 'nullable|numeric|in:0,2,4,6,8,12,24,48|present',
                    'reschedule_time_period' =>
                    'nullable|numeric|in:0,2,4,6,8,12,24,48|present',
                    'registration_number' => 'present',

                    'bank_account_number' => 'present|nullable',
                    'bank_account_holder' => 'present|required_with:bank_account_number|nullable',
                    'bank_name' => 'present|required_with:bank_account_number|nullable',
                    'bank_city' => 'present|required_with:bank_account_number|nullable',
                    'bank_ifsc' => 'present|required_with:bank_account_number|nullable',
                    'bank_account_type' => 'present|required_with:bank_account_number|nullable',
                ];
                break;
            case 'administrator.add.pharmacy':
                return [
                    'pharmacy_name' => 'required',
                    'country_code' => 'required',
                    'mobile_number' => 'required|string|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                    'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
                    'gstin' => 'required',
                    'dl_number' => 'required',
                    'dl_issuing_authority' => 'required',
                    'dl_date_of_issue' => 'required|date_format:Y-m-d',
                    'dl_valid_upto' => 'required|date_format:Y-m-d',
                    'dl_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

                    'pincode' => 'required|digits:6',
                    'street_name'  => 'required|string',
                    'city_village'  => 'required|string',
                    'district'   => 'required|string',
                    'state'   => 'required|string',
                    'country' => 'required|string',
                    'home_delivery' => 'required|boolean',
                    'order_amount' => 'required_if:home_delivery,1',
                    'currency_code' => 'required|string',
                    'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],  'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],

                    'pharmacist_name' => 'required',
                    'course' => 'required',
                    'pharmacist_reg_number' => 'required',
                    'issuing_authority' => 'required',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    'reg_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                    'reg_date' => 'required|date_format:Y-m-d',
                    'reg_valid_upto' => 'required|date_format:Y-m-d',

                    'bank_account_number' => 'present|nullable',
                    'bank_account_holder' => 'present|required_with:bank_account_number|nullable',
                    'bank_name' => 'present|required_with:bank_account_number|nullable',
                    'bank_city' => 'present|required_with:bank_account_number|nullable',
                    'bank_ifsc' => 'present|required_with:bank_account_number|nullable',
                    'bank_account_type' => 'present|required_with:bank_account_number|nullable',
                ];
                break;
            case 'administrator.add.laboratory':
                return [
                    'laboratory_name' => 'required',
                    'country_code' => 'required',
                    'mobile_number' => 'required|string|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                    'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    'gstin' => 'required',
                    'lab_reg_number' => 'required',
                    'lab_issuing_authority' => 'required',
                    'lab_date_of_issue' => 'required|date_format:Y-m-d',
                    'lab_valid_upto' => 'required|date_format:Y-m-d',
                    'lab_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                    'pincode' => 'required|digits:6',
                    'street_name'  => 'required|string',
                    'city_village'  => 'required|string',
                    'district'   => 'required|string',
                    'state'   => 'required|string',
                    'country' => 'required|string',
                    'sample_collection' => 'required|boolean',
                    'order_amount' => 'required_if:sample_collection,1',
                    'currency_code' => 'required|string',
                    'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],  'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                    'row'    => 'nullable|array',
                    'row.*.id' => ['required', 'distinct', 'integer', 'exists:lab_tests,id,deleted_at,NULL'],
                    'row.*.sample_collect' => ['required', 'boolean'],

                    'bank_account_number' => 'present|nullable',
                    'bank_account_holder' => 'present|required_with:bank_account_number|nullable',
                    'bank_name' => 'present|required_with:bank_account_number|nullable',
                    'bank_city' => 'present|required_with:bank_account_number|nullable',
                    'bank_ifsc' => 'present|required_with:bank_account_number|nullable',
                    'bank_account_type' => 'present|required_with:bank_account_number|nullable',
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
            'clinic_name.unique' => 'The clinic name already exists.',
            'no_of_followup.required' => 'The number of followup field is required',
            'followups_after.required' => 'The number of followup after field is required',
            'gstin.required' => 'GSTIN (Goods and Services Tax Identification Number) is required.',
            'dl_number.required' => 'Drug licence number is required.',
            'dl_issuing_authority.required' => 'Drug licence Issuing Authority is required.',
            'dl_date_of_issue.required' => 'Drug licence date of issue is required.',
            'dl_valid_upto.required' => 'Drug licence valid upto is required.',
            'dl_file.required' => 'Drug licence image file is required.',
            'pharmacist_reg_number.required' => 'Pharmacist Registration Number is required.',
            'alt_mobile_number.required' => 'Alternative Mobile field is required.',
            'reg_certificate.required' => 'Registration certification file is required.',
            'reg_date.required' => 'Registration date field is required.',
            'reg_valid_upto.required' => 'Registration valid up to is required.',
            'lab_reg_number.required' => 'Laboratory Registraton number is required.',
            'lab_issuing_authority.required' => 'Laboratory Registraton Issuing Authority is required.',
            'lab_date_of_issue.required' => 'Laboratory Registraton date of issue is required.',
            'lab_valid_upto.required' => 'Laboratory Registraton valid upto is required.',
            'lab_file.required' => 'Laboratory Registraton image file is required.',
            'alt_country_code.required_with' => 'The Alternative country code field is required when Alternative mobile number is present.',

            'sample_collection.required' => 'Sample collection from home field is required.',
            'order_amount.required_if' => 'Order amount is required when Sample collection from home field is yes.',

        ];
    }
}
