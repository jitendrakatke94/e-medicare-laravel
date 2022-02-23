<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class PaymentService
{
    public $key_id, $key_secret;

    public function __construct()
    {
        $this->key_id = config('app.razor_pay')['key_id'];
        $this->key_secret = config('app.razor_pay')['key_secret'];
    }

    public function refund($record, $type)
    {
        $api = new Api($this->key_id, $this->key_secret);
        if ($type == 'APPOINTMENT' || $type == 'ORDER') {
            $record->payments->update(['payment_status' => 'Refund Pending']);
            try {

                $payment = $api->payment->fetch($record->payments->razorpay_payment_id);

                if ($payment->status == 'captured') {
                    $refund = $payment->refund(array('speed' => 'optimum'));

                    if ($refund->status == 'processed') {
                        $record->payments->update(['razorpay_refund_id' => $refund->id, 'payment_status' => 'Refunded']);
                    }
                }
                return;
            } catch (\Exception $exception) {
                Log::debug('Patientcontroller', ['Refund exception' => $exception->getMessage()]);
                return;
            }
        }
    }
}
