<?php

namespace App\Traits;

trait sendMobileOTPTrait
{
    public function send($mobile_number, $message)
    {
        $api_key = config('app.text_local')['api_key'];
        $sender_id = config('app.text_local')['sender_id'];

        // Message details
        $numbers = array($mobile_number);
        $sender = urlencode($sender_id);
        $message = rawurlencode($message);

        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        $data = array('apikey' => $api_key, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        \Log::info(['TEXT_LOCAL_SMS_RESULT' => $result]);
        return $result;
    }
}
