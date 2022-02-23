<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionsRequest extends FormRequest
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
            case 'add.prescription':
                return [
                    'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
                    'info' => 'required|array',
                    'info.address' => 'nullable|present|string',
                    'info.body_temp' => 'nullable|present|string',
                    'info.age' => 'required',
                    'info.pulse_rate' => 'nullable|present|numeric',
                    'info.bp_diastolic' => 'nullable|present',
                    'info.bp_systolic' => 'nullable|present',
                    'info.height' => 'nullable|present',
                    'info.weight' => 'nullable|present',
                    'info.case_summary' => 'required|string',
                    'info.symptoms' => 'required|string',
                    'info.diagnosis' => 'required|string',

                    'info.note_to_patient' => 'nullable|present|string',
                    'info.diet_instruction' => 'nullable|present|string',
                    'info.despencing_details' => 'nullable|present|string',
                    'info.investigation_followup' => 'nullable|present|string',

                    'medicine_list' => 'nullable|array',
                    'medicine_list.*.dosage' => 'required',
                    'medicine_list.*.no_of_refill' => 'required|numeric',
                    'medicine_list.*.duration' => 'required|string',
                    'medicine_list.*.substitution_allowed' => 'required|in:0,1',
                    'medicine_list.*.instructions' => 'nullable|present|string',
                    'medicine_list.*.status' => 'required|in:0,1,2',
                    'medicine_list.*.medicine_id' => 'required|numeric|exists:medicines,id,deleted_at,NULL|distinct',
                    'medicine_list.*.pharmacy_id' => 'nullable|present|numeric|required_if:medicine_list.*.status,1|exists:pharmacies,id',
                    'medicine_list.*.note' => 'nullable|present|string',

                    'test_list' => 'nullable|array',
                    'test_list.*.status' => 'required|in:0,1,2',
                    'test_list.*.test_id' => 'required|numeric|exists:lab_tests,id,deleted_at,NULL|distinct',
                    'test_list.*.laboratory_id' => 'nullable|present|numeric|required_if:test_list.*.status,1|exists:laboratory_infos,id',
                    'test_list.*.instructions' => 'nullable|present|string',
                    'test_list.*.note' => 'nullable|present|string',

                    'followup_date' => 'present|nullable|date_format:Y-m-d',

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
            'info.case_summary.required' => 'The case summary field is required.',
            'info.symptoms.required' => 'The current symptoms field is required.',
            'info.diagnosis.required' => 'The diagnosis field is required.',
            'medicine_list.*.dosage.required' => 'The dosage field is required.',
            'medicine_list.*.no_of_refill.required' => 'The Number of refill field is required.',
            'medicine_list.*.no_of_refill.numeric' => 'The Number of refill field must be a number.',

            'medicine_list.*.duration.required' => 'The duration field is required.',
            'medicine_list.*.substitution_allowed.required' => 'The substitution allowed field is required.',
            'medicine_list.*.substitution_allowed.in' => 'The substitution allowed field is invalid.',

            'medicine_list.*.status.required' => 'The status field is required.',

            'medicine_list.*.medicine_id.required' => 'The medicine id field is required.',
            'medicine_list.*.medicine_id.exists' => 'The medicine id invalid.',
            'medicine_list.*.medicine_id.distinct' => 'The medicine id field has a duplicate value.',

            'medicine_list.*.pharmacy_id.required_if' => 'The pharmacy id field is required when status is 1.',
            'medicine_list.*.pharmacy_id.exists' => 'The pharmacy id is invalid.',

            'test_list.*.status.required' => 'The status field is required.',

            'test_list.*.test_id.required' => 'The test id field is required.',
            'test_list.*.test_id.exists' => 'The test id invalid.',
            'test_list.*.test_id.distinct' => 'The test id field has a duplicate value.',

            'test_list.*.test_id.required_if' => 'The Laboratory id field is required when status is 1.',
            'test_list.*.laboratory_id.exists' => 'The Laboratory id is invalid.',

        ];
    }
}
