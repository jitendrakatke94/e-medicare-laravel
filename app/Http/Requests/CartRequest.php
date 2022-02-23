<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            case 'cart.create':
                return [
                    'type' => 'required|in:MED,LAB'
                ];
                break;
            case 'cart.add.product':
                return [
                    'item_id' => 'required|integer',
                    'quantity' => 'required|integer',
                ];
                break;
            case 'cart.add.product.single':
                if ($this->type == 'MED') {
                    $rules['item_id'] = 'required|integer|exists:medicines,id,deleted_at,NULL';
                } else {
                    $rules['item_id'] = 'required|integer|exists:lab_tests,id,deleted_at,NULL';
                }
                $rules['quantity'] = 'required|integer';
                $rules['type'] = 'required|in:MED,LAB';
                return $rules;
                break;
            case 'cart.update.product':
                return [
                    'cart_item_id' => 'required|integer|exists:cart_items,id',
                    'quantity' => 'required|integer'
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
