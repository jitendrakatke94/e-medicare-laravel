<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaboratoryRegistrationRequest extends FormRequest
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

            case 'laboratory.basicinfo':
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
                    'lab_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
                ];
            case 'laboratory.address':
                return [
                    'data_id' => 'required|integer|exists:app_options,id,deleted_at,NULL',
                    'pincode' => 'required|digits:6',
                    'street_name'  => 'required|string',
                    'city_village'  => 'required|string',
                    'district'   => 'required|string',
                    'state'   => 'required|string',
                    'country' => 'required|string',
                    'currency_code' => 'required|string',
                    'sample_collection' => 'required|boolean',
                    'order_amount' => 'required_if:sample_collection,1',
                    'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],  'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                ];
                break;
            case 'laboratory.testlist':
                return [
                    'data_id' => 'required|integer|exists:app_options,id,deleted_at,NULL',
                    'row'    => 'nullable|array',
                    'row.*.id' => ['required', 'distinct', 'integer', 'exists:lab_tests,id,deleted_at,NULL'],
                    'row.*.sample_collect' => ['required', 'boolean'],
                ];
                break;
            case 'laboratory.bankdetails':
                return [
                    'data_id' => 'required|integer|exists:app_options,id,deleted_at,NULL',
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
    /**
     * change validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gstin.required' => 'GSTIN (Goods and  Tax Identification Number) is required.',
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
