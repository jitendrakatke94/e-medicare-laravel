<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcommerceRequest extends FormRequest
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
            case 'ecommerce.register':
                return [
                    'first_name' => 'required|max:50',
                    'last_name' => 'required|max:50',
                    'password' => ['required', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
                    'email' => 'required|email:rfc,strict,filter|unique:users,email,NULL,id,deleted_at,NULL',
                ];
                break;
            case 'ecommerce.checkout':
                return [
                    'cart_id' => 'required|exists:carts,id,deleted_at,NULL',
                    'prescription_file' => 'file|nullable|mimes:jpg,jpeg,png,pdf|max:2048',
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
