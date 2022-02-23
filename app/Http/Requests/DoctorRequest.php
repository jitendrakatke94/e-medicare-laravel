<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
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
            case 'doctor.profile.edit':
            case 'doctorEditProfile':
                $rules = [
                    'first_name' => 'required|max:50',
                    'middle_name' => 'nullable|max:50|present',
                    'last_name' => 'required|max:50',
                    'gender' => [
                        'required',
                        Rule::in(['MALE', 'FEMALE', 'OTHERS']),
                    ],
                    'date_of_birth' => 'required',
                    'age' => 'required',
                    'qualification' => 'required',
                    'specialization' => 'required|array',
                    'years_of_experience' => 'required',
                    'mobile_number' => [
                        'required',
                        Rule::unique('users')->ignore(auth()->user()->id),
                    ],
                    'country_code' => 'required',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    'email' => [
                        'required',
                        Rule::unique('users')->ignore(auth()->user()->id),
                    ],
                    'clinic_name' => 'nullable|present',
                    'pincode' => 'required|digits:6',
                    'street_name'  => 'required|string',
                    'city_village'  => 'required|string',
                    'district'   => 'required|string',
                    'state'   => 'required|string',
                    'country' => 'required|string',
                ];
                if ($this->route()->getName() == 'doctorEditProfile') {
                    $rules['email'] = [
                        'required',
                        Rule::unique('users')->ignore($this->id),
                    ];
                    $rules['mobile_number'] = [
                        'required',
                        Rule::unique('users')->ignore($this->id),
                    ];
                    $rules['pincode'] = ['present', 'nullable', 'digits:6'];
                    $rules['street_name'] = ['present', 'nullable', 'string'];
                    $rules['city_village'] = ['present', 'nullable', 'string'];
                    $rules['district'] = ['present', 'nullable', 'string'];
                    $rules['state'] = ['present', 'nullable', 'string'];
                    $rules['country'] = ['present', 'nullable', 'string'];
                }
                return $rules;
                break;
            case 'doctor.address.add':
            case 'doctor.address.edit':
            case 'editDoctorAddress':
                return [
                    'pincode' => 'required|digits:6',
                    'street_name'  => 'required|string',
                    'city_village'  => 'required|string',
                    'district'   => 'required|string',
                    'state'   => 'required|string',
                    'country' => 'required|string',
                    'contact_number' => 'nullable|present',
                    'country_code' => 'required_with:contact_number|present',
                    'clinic_name' => 'required',
                    'pharmacy_list' => 'nullable|array',
                    'pharmacy_list.*' => ['integer', 'distinct', 'exists:pharmacies,id,deleted_at,NULL'],
                    'laboratory_list' => 'nullable|array',
                    'laboratory_list.*' => ['integer', 'distinct', 'exists:laboratory_infos,id,deleted_at,NULL'],
                    'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],  'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                ];
            case 'doctor.profile.additionalinformation':
            case 'editAdditionalInformation';
                return [
                    'career_profile' => 'required|string',
                    'education_training' => 'required|string',
                    'clinical_focus' => 'nullable|present',
                    'awards_achievements' => 'nullable|present',
                    'memberships' => 'nullable|present',
                    'experience' => 'nullable|string|present',
                    'profile_photo' => 'file|mimes:jpg,jpeg,png|max:2048',
                    'service' => [
                        'required',
                        Rule::in(['INPATIENT', 'OUTPATIENT', 'BOTH'])
                    ],
                    'appointment_type_online' => 'nullable|boolean|present',
                    'appointment_type_offline' => 'nullable|boolean|present',
                    'currency_code' => 'required|string',
                    'consulting_online_fee' => 'required_if:appointment_type_online,1|regex:/^\d+(\.\d{1,2})?$/|present',
                    'consulting_offline_fee' => 'required_if:appointment_type_offline,1|regex:/^\d+(\.\d{1,2})?$/|present',
                    'emergency_fee' => 'numeric|regex:/^\d+(\.\d{1,2})?$/|present',
                    'emergency_appointment' => 'nullable|numeric|present',
                    'no_of_followup' => 'required|numeric|between:0,10',
                    'followups_after' => 'required|numeric|between:1,4',
                    'cancel_time_period' => 'nullable|numeric|in:0,2,4,6,8,12,24,48|present',
                    'reschedule_time_period' =>
                    'nullable|numeric|in:0,2,4,6,8,12,24,48|present',
                    'payout_period' => 'required|in:0,1',
                    'registration_number' => 'required',
                    'time_intravel' => 'nullable|integer|max:60'
                ];
                break;
            case 'doctor.timeslot.add':
                return [
                    'row' => 'required|array|min:1',
                    'row.*.day' => [
                        'required',
                        Rule::in(['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'])
                    ],
                    'row.*.slot_start' => 'required|date_format:H:i|distinct',
                    'row.*.slot_end' => 'required|date_format:H:i|distinct',
                    'row.*.type' => [
                        'required',
                        Rule::in(['OFFLINE', 'ONLINE', 'BOTH'])
                    ],
                    'row.*.shift' => [
                        'required',
                        Rule::in(['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT'])
                    ],
                    'row.*.doctor_clinic_id' => 'required|integer|exists:doctor_clinic_details,id,deleted_at,NULL'
                ];
                break;
            case 'doctor.bankdetails':
            case 'addBankDetails':
                return [
                    'bank_account_number' => 'nullable',
                    'bank_account_holder' => 'required_with:bank_account_number|nullable',
                    'bank_name' => 'required_with:bank_account_number|nullable',
                    'bank_city' => 'required_with:bank_account_number|nullable',
                    'bank_ifsc' => 'required_with:bank_account_number|nullable',
                    'bank_account_type' => 'required_with:bank_account_number|nullable',
                ];
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
        ];
    }
}
