<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ErrorMessage implements Responsable
{

    protected $message, $error_code;

    /**
     * construct function
     *
     * @param [string] $message
     * @param integer $error_code
     */
    public function __construct($message, $error_code = 400)
    {
        $this->message = $message;
        $this->error_code = $error_code;
    }

    /**
     * toResponse function
     *
     * @param [type] $request
     * @return void
     */
    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message
        ], $this->error_code);
    }
}
