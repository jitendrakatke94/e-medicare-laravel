<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            case 'category.store':
                return [
                    'parent_id' => 'nullable|exists:categories,id,deleted_at,NULL',
                    'name' => 'required|string|unique:categories,name,NULL,id,deleted_at,NULL',
                    'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                ];
                break;
            case 'category.update':
                return [
                    'parent_id' => 'nullable|exists:categories,id,deleted_at,NULL',
                    'name' => [
                        'required',
                        'string',
                        Rule::unique('categories')->ignore($this->id)->whereNull('deleted_at')
                    ],
                    'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
