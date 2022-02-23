<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MedicineRequest extends FormRequest
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
            case 'medicine.store':
                return [
                    'category_id' => 'required|integer|exists:categories,id',
                    'composition' => 'required|string',
                    'weight' => 'required|numeric',
                    'weight_unit' => 'required|string',
                    'name' => 'required|string|unique:medicines,name,NULL,id,deleted_at,NULL',
                    'manufacturer' => 'required|string',
                    'medicine_type' => 'required|string',
                    'drug_type' => 'required|in:Generic,Branded',
                    'currency_code' => 'required|string',
                    'price_per_strip' => 'required|numeric',
                    'qty_per_strip' => 'required|numeric',
                    'rate_per_unit' => 'required|numeric',
                    'rx_required' => 'required|in:0,1',
                    'short_desc' => 'nullable|present',
                    'long_desc' => 'nullable|present',
                    'cart_desc' => 'nullable|present',
                    'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                ];
                break;
            case 'medicine.update':
                return [
                    'category_id' => 'required|integer|exists:categories,id',
                    'composition' => 'required|string',
                    'weight' => 'required|numeric',
                    'weight_unit' => 'required|string',
                    'name' => [
                        'required',
                        'string',
                        Rule::unique('medicines')->ignore($this->id)->whereNull('deleted_at')
                    ],
                    'manufacturer' => 'required|string',
                    'medicine_type' => 'required|string',
                    'drug_type' => 'required|in:Generic,Branded',
                    'currency_code' => 'required|string',
                    'price_per_strip' => 'required|numeric',
                    'qty_per_strip' => 'required|numeric',
                    'rate_per_unit' => 'required|numeric',
                    'rx_required' => 'required|in:0,1',
                    'short_desc' => 'nullable|present',
                    'long_desc' => 'nullable|present',
                    'cart_desc' => 'nullable|present',
                    'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
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
            'qty_per_strip.required' => 'Quantity per strip is required.',
        ];
    }
}
