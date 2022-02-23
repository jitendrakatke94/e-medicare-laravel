<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminEditRequest extends FormRequest
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
            case 'laboratoryBasicInfo':
                return [
                    'laboratory_name' => 'required',
                    'country_code' => 'required',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    'email' => 'required',
                    'mobile_number' => 'required',
                    'gstin' => 'required',
                    'lab_reg_number' => 'required',
                    'lab_issuing_authority' => 'required',
                    'lab_date_of_issue' => 'required|date_format:Y-m-d',
                    'lab_valid_upto' => 'required|date_format:Y-m-d',
                    'lab_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
                ];
                break;
            case 'laboratoryAddress':
                return [
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
                ];
                break;

            case 'laboratoryAddTestList':
                return [
                    'row'    => 'nullable|array',
                    'row.*.id' => ['required', 'distinct', 'integer', 'exists:lab_tests,id,deleted_at,NULL'],
                    'row.*.sample_collect' => ['required', 'boolean'],
                ];
                break;
            case 'laboratoryAddBankDetails':
                return [
                    'bank_account_number' => 'present|nullable',
                    'bank_account_holder' => 'present|required_with:bank_account_number|nullable',
                    'bank_name' => 'present|required_with:bank_account_number|nullable',
                    'bank_city' => 'present|required_with:bank_account_number|nullable',
                    'bank_ifsc' => 'present|required_with:bank_account_number|nullable',
                    'bank_account_type' => 'present|required_with:bank_account_number|nullable',
                ];
                break;
            case 'pharmacyBasicInfo':
                return [
                    'pharmacy_name' => 'required',
                    'country_code' => 'required',
                    'mobile_number' => 'required',
                    'email' => 'required',
                    'gstin' => 'required',
                    'dl_number' => 'required',
                    'dl_issuing_authority' => 'required',
                    'dl_date_of_issue' => 'required|date_format:Y-m-d',
                    'dl_valid_upto' => 'required|date_format:Y-m-d',
                    'dl_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
                ];
            case 'pharmacyAddress':
                return [
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
                ];
                break;
            case 'pharmacyAdditionaldetails':
                return [
                    'pharmacist_name' => 'required',
                    'course' => 'required',
                    'pharmacist_reg_number' => 'required',
                    'issuing_authority' => 'required',
                    'alt_mobile_number' => 'nullable|present',
                    'alt_country_code' => 'required_with:alt_mobile_number|present',
                    'reg_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
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
            default:
                return [];
                break;
        }
    }
    /**
     * change validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gstin.required' => 'GSTIN (Goods and Services Tax Identification Number) is required.',
            'lab_reg_number.required' => 'Laboratory Registraton number is required.',
            'lab_issuing_authority.required' => 'Laboratory Registraton Issuing Authority is required.',
            'lab_date_of_issue.required' => 'Laboratory Registraton date of issue is required.',
            'lab_valid_upto.required' => 'Laboratory Registraton valid upto is required.',
            'lab_file.required' => 'Laboratory Registraton image file is required.',
            'alt_country_code.required_with' => 'The Alternative country code field is required when Alternative mobile number is present.',

            'home_delivery.required' => 'Home delivery field is required.',
            'order_amount.required_if' => 'The order amount is required when Home delivery field is yes.',
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
        ];
    }
}
