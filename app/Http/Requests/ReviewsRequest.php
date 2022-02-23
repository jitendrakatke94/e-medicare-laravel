<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewsRequest extends FormRequest
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
            case 'patient.review.add':
                return [
                    'to_id' => 'required|integer',
                    // 'type' => [
                    //     'required',
                    //     Rule::in(['PATIENT', 'DOCTOR', 'PHARMACIST', 'LABORATORY']),
                    // ],
                    'rating' => 'required|integer',
                    'title' => 'required|string',
                    'review' => 'nullable|string|present'
                ];
            case 'patient.review.edit':
                return [
                    'rating' => 'required|integer',
                    'title' => 'required|string',
                    'review' => 'nullable|string|present'
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
