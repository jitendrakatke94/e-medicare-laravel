<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
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
            case 'patient.quote.request.pharmacy':
                return [
                    'prescription_id' => 'required|integer|exists:prescription_med_lists,prescription_id',
                    'medicine_list' => 'required|array|min:1',
                    'medicine_list.*' => 'required|exists:prescription_med_lists,medicine_id,quote_generated,0,prescription_id,' . $this->prescription_id,
                    'pharmacy_id' => 'required|array|min:1',
                    'pharmacy_id.*' => 'required|integer|exists:pharmacies,id'

                ];
                break;
            case 'patient.quote.request.laboratory':
                return [
                    'prescription_id' => 'required|integer|exists:prescription_test_lists,prescription_id',
                    'test_list' => 'required|array|min:1',
                    'test_list.*' => 'required|exists:prescription_test_lists,lab_test_id,quote_generated,0,prescription_id,' . $this->prescription_id,
                    'laboratory_id' => 'required|array|min:1',
                    'laboratory_id.*' => 'required|integer|exists:laboratory_infos,id'

                ];
                break;
            case 'add.quote.pharmacy':
                return [
                    'quote_request_id' => 'required|integer|exists:quote_requests,id,deleted_at,NULL,type,MED',
                    'medicine_list' => 'required|array|min:1',
                    'medicine_list.*.medicine_id' => 'required|exists:medicines,id|distinct',
                    'medicine_list.*.price' => 'required|numeric',
                    'medicine_list.*.unit' => 'required|numeric',
                    'medicine_list.*.dosage' => 'present',
                    'medicine_list.*.duration' => 'present',
                    'medicine_list.*.instructions' => 'present',
                    'total' => 'required|numeric',
                    'discount' => 'present|numeric|nullable',
                    'delivery_charge' => 'present|numeric|nullable',
                    //'tax_percent' => 'present|nullable|numeric',
                    'valid_till' => 'required|date_format:Y-m-d'
                ];
                break;
            case 'add.quote.laboratory':
                return [
                    'quote_request_id' => 'required|integer|exists:quote_requests,id,deleted_at,NULL,type,LAB',
                    'test_list' => 'required|array|min:1',
                    'test_list.*.test_id' => 'required|exists:lab_tests,id|distinct',
                    'test_list.*.price' => 'required|numeric',
                    'test_list.*.instructions' => 'present',
                    'total' => 'required|numeric',
                    'discount' => 'present|numeric|nullable',
                    'delivery_charge' => 'present|numeric|nullable',
                    //'tax_percent' => 'required|numeric',
                    'valid_till' => 'required|date_format:Y-m-d'

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
            'medicine_list.*.medicine_id.required' => 'The medicine id field is required.',
            'medicine_list.*.medicine_id.exists' => 'The medicine id invalid.',
            'medicine_list.*.medicine_id.distinct' => 'The medicine id field has a duplicate value.',
            'medicine_list.*.price.required' => 'The price field is required.',
            'medicine_list.*.price.numeric' => 'The price must be a number.',
            'medicine_list.*.unit.required' => 'The unit field is required.',
            'medicine_list.*.unit.numeric' => 'The unit must be a number.',

            'medicine_list.*.quote_generated' => 'Tdamn a number.',

            'test_list.*.test_id.required' => 'The test id field is required.',
            'test_list.*.test_id.exists' => 'The test id invalid.',
            'test_list.*.test_id.distinct' => 'The test id field has a duplicate value.',
            'test_list.*.price.required' => 'The price field is required.',
            'test_list.*.price.numeric' => 'The price must be a number.',

        ];
    }
}
