<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PharmacyRequest extends FormRequest
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
            'pharmacy_name' => 'required',
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
            'gstin' => 'required',
            'dl_number' => 'required',
            'dl_issuing_authority' => 'required',
            'dl_date_of_issue' => 'required|date_format:Y-m-d',
            'dl_valid_upto' => 'required|date_format:Y-m-d',
            'dl_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'payout_period' => 'required|in:0,1',

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
            'reg_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'reg_date' => 'required|date_format:Y-m-d',
            'reg_valid_upto' => 'required|date_format:Y-m-d',

            'bank_account_number' => 'required',
            'bank_account_holder' => 'required',
            'bank_name' => 'required',
            'bank_city' => 'required',
            'bank_ifsc' => 'required',
            'bank_account_type' => 'required',
        ];
    }
    /**
     * change validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
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
        ];
    }
}
