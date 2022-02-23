<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentsRequest extends FormRequest
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
            case 'appointments.confirm':
                $rules = [
                    'doctor_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1,user_type,DOCTOR',
                    'address_id' => 'required|integer|exists:addresses,id',
                    'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1,user_type,PATIENT',
                    'consultation_type' => 'required|in:INCLINIC,ONLINE,EMERGENCY',
                    'time_slot_id' => [
                        'nullable',
                        'required_if:consultation_type,INCLINIC,ONLINE',
                        'integer',
                        'exists:doctor_time_slots,id,deleted_at,NULL,user_id,' . $this->doctor_id,
                    ],
                    'date' => 'required|date_format:Y-m-d',
                    'shift' => 'nullable|in:MORNING,AFTERNOON,EVENING,NIGHT|required_if:consultation_type,EMERGENCY',
                    'followup_id' => 'nullable|integer|exists:followups,id,deleted_at,NULL',
                    'patient_info' => 'array|min:1',
                    'patient_info.mobile_code' => 'required',
                    'patient_info.mobile' => 'required',
                    'patient_info.first_name' => 'required',
                    'patient_info.middle_name' => 'nullable',
                    'patient_info.last_name' => 'required',
                    'patient_info.patient_mobile_code' => 'required',
                    'patient_info.patient_mobile' => 'required',
                    'patient_info.email' => 'nullable|present',
                    'patient_info.case' => 'required|in:0,1,2',
                    'patient_info.id' => 'nullable|integer|required_if:patient_info.case,1,2|present',
                ];

                if (isset($this->patient_info['case']) && $this->patient_info['case'] == 2) {
                    $rules['patient_info.id'] = 'required|integer|exists:patient_family_members,id,deleted_at,NULL,user_id,' . auth()->user()->id;
                } elseif (isset($this->patient_info['case']) &&  $this->patient_info['case'] == 1) {
                    $rules['patient_info.id'] = 'required|integer|exists:users,id,deleted_at,NULL,id,' . auth()->user()->id;
                }
                return $rules;
                break;
            case 'appointments.details':
                return [
                    'doctor_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1,user_type,DOCTOR',
                    'address_id' => 'required|integer|exists:addresses,id',
                    'consultation_type' => 'required|in:INCLINIC,ONLINE,EMERGENCY',
                    'time_slot_id' => [
                        'nullable',
                        'required_if:consultation_type,INCLINIC,ONLINE',
                        'integer',
                        'exists:doctor_time_slots,id,deleted_at,NULL,user_id,' . $this->doctor_id,
                    ],
                    'date' => 'required|date_format:Y-m-d',
                    'shift' => 'nullable|in:MORNING,AFTERNOON,EVENING,NIGHT|required_if:consultation_type,EMERGENCY',
                    'followup_id' => 'nullable|integer|exists:followups,id,deleted_at,NULL',
                    'timezone' => 'required|timezone'
                ];
                break;
            default:
                return [];
                break;
        }
    }
    /**
     * change validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'patient_info.mobile_code.required' => 'The Country code field is required.',
            'patient_info.mobile.required' => 'The  Mobile number field is required.',
            'patient_info.first_name.required' => 'The First name field is required.',
            'patient_info.last_name.required' => 'The Last name field is required.',
            'patient_info.patient_mobile_code.required' => 'The Country code field is required.',
            'patient_info.patient_mobile.required' => 'The  Phone number field is required.',
        ];
    }
}
