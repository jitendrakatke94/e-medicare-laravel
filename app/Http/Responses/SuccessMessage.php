<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class SuccessMessage implements Responsable
{

    protected $message, $success_code;

    /**
     * construct
     *
     * @param [string] $message
     * @param integer $success_code
     */
    public function __construct($message, $success_code = 200)
    {
        $this->message = $message;
        $this->success_code = $success_code;
    }

    /**
     * toResponse
     *
     * @param [type] $request
     * @return void
     */
    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message
        ], $this->success_code);
    }
}
