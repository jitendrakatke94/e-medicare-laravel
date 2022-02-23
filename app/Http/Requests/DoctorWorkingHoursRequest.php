<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorWorkingHoursRequest extends FormRequest
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
            'working_hours' => 'required|array|min:1',
            'day' => [
                'required',
                Rule::in(['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'])
            ],
            'working_hours.*.slot_start' => 'required|date_format:H:i|distinct',
            'working_hours.*.slot_end' => 'required|date_format:H:i|distinct',
            'shift' => [
                'required',
                Rule::in(['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT'])
            ],
            'type' => [
                'required',
                Rule::in(['OFFLINE', 'ONLINE', 'BOTH'])
            ],
            'doctor_clinic_id' => 'required|integer|exists:doctor_clinic_details,id,deleted_at,NULL'

        ];
    }
    public function messages()
    {
        return [
            'working_hours.*.slot_start.distinct' => 'The working hours has duplicate value.',
            'working_hours.*.slot_end.distinct' => 'The working hours has duplicate value.',
            'no_of_followup.required' => 'The number of followup field is required',
            'followups_after.required' => 'The number of followup after field is required',
        ];
    }
}
