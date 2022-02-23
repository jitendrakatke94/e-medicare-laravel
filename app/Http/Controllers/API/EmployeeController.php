<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Model\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @authenticated
     *
     * @group Employee
     *
     * Employee get profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "id": 3,
     *    "unique_id": "EMP0000003",
     *    "father_first_name": "dad",
     *    "father_middle_name": "dad midle",
     *    "father_last_name": "dad last",
     *    "date_of_birth": "1995-10-10",
     *    "age": 25,
     *    "date_of_joining": "2020-10-10",
     *    "gender": "MALE",
     *    "user": {
     *        "id": 33,
     *        "first_name": "Employee",
     *        "middle_name": "middle",
     *        "last_name": "last",
     *        "email": "employee@logidots",
     *        "username": "Emp5f9c0972bf270",
     *        "country_code": "+91",
     *        "mobile_number": "9876543288",
     *        "user_type": "EMPLOYEE",
     *        "is_active": "0",
     *        "profile_photo_url": null
     *    },
     *    "address": [
     *        {
     *            "id": 75,
     *            "street_name": "Lane",
     *            "city_village": "land",
     *            "district": "CA",
     *            "state": "KL",
     *            "country": "IN",
     *            "pincode": "654321",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Details not found."
     *}
     */

    public function getEmployeeProfile(Request $request)
    {
        try {
            $record = Employee::with('user')->with('address')->where('user_id', auth()->user()->id)->firstOrFail();
        } catch (\Exception $e) {

            return new ErrorMessage('Details not found.', 404);
        }
        return response()->json($record, 200);
    }
}
