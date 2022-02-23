<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            case 'comment.create':
                return [
                    'to_user_id' => 'required|exists:users,id',
                    'comment' => 'required|string',
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
