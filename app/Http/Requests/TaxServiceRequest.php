<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaxServiceRequest extends FormRequest
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
            case 'taxservice.add':
                return [
                    'name' => 'required|string|unique:tax_services,name,NULL,id,deleted_at,NULL',
                    'taxes' => 'nullable|array',
                    'taxes.*' => ['required', 'integer', 'distinct', 'exists:taxes,id,deleted_at,NULL']
                ];
                break;
            case 'taxservice.edit':
                return [
                    'name' => [
                        'required',
                        Rule::unique('tax_services')->ignore($this->id),
                    ],
                    'taxes' => 'nullable|array',
                    'taxes.*' => ['required', 'integer', 'distinct', 'exists:taxes,id,deleted_at,NULL']
                ];
                break;
            case 'commission.edit':
                return [
                    'commission' => 'required|numeric'
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
            'taxes.*.required' => 'The taxes field is required.',
            'taxes.*.integer' => 'The taxes must be an integer.',
            'taxes.*.distinct' => 'The taxes has duplicate value.',
            'taxes.*.exists' => 'The selected taxes is invalid.',
        ];
    }
}
