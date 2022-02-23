<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaceBookController extends Controller
{
    public function deletionCallback(Request $request)
    {
        header('Content-Type: application/json');

        $signed_request = $_POST['signed_request'];
        $data = $this->parse_signed_request($signed_request);
        //$user_id = $data['user_id'];

        // Start data deletion
        $status_url = url('/') . '/facebook/deletionconfirm?id=' . time(); // URL to track the deletion
        $confirmation_code = time(); // unique code for the deletion request

        $data = array(
            'url' => $status_url,
            'confirmation_code' => $confirmation_code
        );
        return response()->json($data, 200);
    }

    public function parse_signed_request($signed_request)
    {

        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        $secret = config('app.facebook')['app_secret'];

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            return response()->json(['message' => 'Bad Signed JSON signature!'], 403);
        }
        return $data;
    }

    public function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function deletionConfirm(Request $request)
    {

        $data = array(
            'message' => 'Your account details has been deactivated. Please contact administrator for more information.',
        );
        return response()->json($data, 200);
    }
}
