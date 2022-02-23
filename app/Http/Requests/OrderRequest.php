<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            case 'order.checkout':
                return [
                    'quote_id' => 'required|integer',
                    'tax' => 'required|numeric',
                    'subtotal' => 'required|numeric',
                    'discount' => 'required|numeric',
                    'commission' => 'required|numeric',
                    'delivery_charge' => 'required|numeric',
                    'total' => 'required|numeric',
                    'shipping_address_id' => 'present|integer|nullable',
                    'pharma_lab_id' => 'required',
                    'type' => 'required|in:LAB,MED',
                    'order_items' => 'required|array|min:1',
                    'order_items.*.item_id' => 'required|integer',
                    'order_items.*.price' => 'required|numeric',
                    'order_items.*.quantity' => 'required|integer',
                    'need_delivery' => 'required|in:0,1'
                ];
                break;
            case 'order.confirm':
            case 'appointments.confirmpayment':
                return [
                    'razorpay_payment_id' => 'required',
                    'razorpay_order_id' => 'required',
                    'razorpay_signature' => 'required',
                ];
                break;
            case 'appointments.checkout':
                return [
                    'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
                    'tax' => 'required|numeric',
                    'total' => 'required|numeric',
                    'commission' => 'required|numeric',
                    //'minutes' => 'required|integer|max:10'
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
