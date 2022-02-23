<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LaboratoryRequest extends FormRequest
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
            case 'laboratory.profile':
                return [
                    'laboratory_name' => 'required',
                    'country_code' => 'required',
                    'mobile_number' => [
                        'required',
                        'string',
                        Rule::unique('users')->ignore(auth()->user()->id),
                    ],
                    'email' => [
                        'required',
                        'email:rfc,strict,filter',
                        Rule::unique('users')->ignore(auth()->user()->id),
                    ],
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    'gstin' => 'required',
                    'lab_reg_number' => 'required',
                    'lab_issuing_authority' => 'required',
                    'lab_date_of_issue' => 'required|date_format:Y-m-d',
                    'lab_valid_upto' => 'required|date_format:Y-m-d',
                    'payout_period' => 'required|in:0,1',
                    'lab_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

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

                    'bank_account_number' => 'required',
                    'bank_account_holder' => 'required',
                    'bank_name' => 'required',
                    'bank_city' => 'required',
                    'bank_ifsc' => 'required',
                    'bank_account_type' => 'required',
                ];
                break;

            case 'laboratory.add.test':
                return [
                    'lab_tests'    => 'nullable|array',
                    'lab_tests.*.id' => ['required', 'distinct', 'integer', 'exists:lab_tests,id,deleted_at,NULL'],
                    'lab_tests.*.sample_collect' => ['required', 'boolean'],
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
