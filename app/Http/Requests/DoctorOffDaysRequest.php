<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorOffDaysRequest extends FormRequest
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
            case 'validate.timeslot':
                return [
                    'date' => 'required|date_format:Y-m-d',
                    'slot_start' => 'required|date_format:H:i',
                    'slot_end' => 'required|date_format:H:i',
                ];
                break;
            case 'schedule.offdays':
                return [
                    'row' => 'required|array|min:1',
                    'row.*.date' => 'required|date_format:Y-m-d',
                    'row.*.slot_start' => 'required|date_format:H:i',
                    'row.*.slot_end' => 'required|date_format:H:i',
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
