<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Appointments;
use App\Model\PatientAllergicDetails;
use App\Model\PatientFamilyHistory;
use App\Model\PatientSocialHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientHistoryController extends Controller
{
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list patient social history
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam patient_id required integer
     * @queryParam appointment_id  required integer
     * @queryParam name nullable string name of patient
     * @queryParam date nullable date format-> Y-m-d
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "unique_id": "PSH0000001",
     *            "details": "This patient has covid 20",
     *            "date": "2020-10-29",
     *            "doctor_name": "Jos"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function getPatientSocialHistory(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1',
            'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
            'name' => 'nullable',
            'date' => 'nullable|date_format:Y-m-d'
        ]);
        $appointment = Appointments::find($validatedData['appointment_id']);
        if ($appointment->patient_info['case'] == 0) {

            $child_info = $appointment->patient_info['patient_mobile'];
        } else {
            $child_info = $appointment->patient_info['id'];
        }

        $list = PatientSocialHistory::where('patient_id', $validatedData['patient_id'])->where('child_info', $child_info);

        if ($request->filled('name')) {
            $list = $list->whereHas('doctor', function ($query) use ($validatedData) {
                $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like '%" . $validatedData['name'] . "%' ");
            });
        }
        if ($request->filled('date')) {
            $list = $list->whereDate('created_at', Carbon::parse($request->date));
        }

        $list = $list->orderBy('id', 'desc')->paginate(PatientAllergicDetails::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add patient social history
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam patient_id integer required
     * @bodyParam appointment_id integer required
     * @bodyParam details string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "patient_id": [
     *            "The patient id field is required."
     *        ],
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ],
     *        "details": [
     *            "The details field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     *
     */
    public function addPatientSocialHistory(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1',
            'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
            'details' => 'required|string'
        ]);
        $appointment = Appointments::find($validatedData['appointment_id']);
        $validatedData['child_info'] = NULL;
        if ($appointment->patient_info['case'] == 0) {

            $validatedData['child_info'] = $appointment->patient_info['patient_mobile'];
        } else {
            $validatedData['child_info'] = $appointment->patient_info['id'];
        }
        $validatedData['doctor_id'] = auth()->user()->id;
        $validatedData['unique_id'] = getSocialHistoryId();
        PatientSocialHistory::create($validatedData);
        return new SuccessMessage('Details saved successfully.');
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list patient family history
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam patient_id required integer
     * @queryParam appointment_id  required integer
     * @queryParam name nullable string name of patient
     * @queryParam date nullable date format-> Y-m-d
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "unique_id": "PFH0000001",
     *            "details": "This patient has covid 19",
     *            "date": "2020-10-29",
     *            "doctor_name": "Jos"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function getPatientFamilyHistory(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1',
            'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
            'name' => 'nullable',
            'date' => 'nullable|date_format:Y-m-d'
        ]);
        $appointment = Appointments::find($validatedData['appointment_id']);
        if ($appointment->patient_info['case'] == 0) {

            $child_info = $appointment->patient_info['patient_mobile'];
        } else {
            $child_info = $appointment->patient_info['id'];
        }

        $list = PatientFamilyHistory::where('patient_id', $validatedData['patient_id'])->where('child_info', $child_info);

        if ($request->filled('name')) {
            $list = $list->whereHas('doctor', function ($query) use ($validatedData) {
                $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like '%" . $validatedData['name'] . "%' ");
            });
        }
        if ($request->filled('date')) {
            $list = $list->whereDate('created_at', Carbon::parse($request->date));
        }

        $list = $list->orderBy('id', 'desc')->paginate(PatientAllergicDetails::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add patient family history
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam patient_id integer required
     * @bodyParam appointment_id integer required
     * @bodyParam details string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "patient_id": [
     *            "The patient id field is required."
     *        ],
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ],
     *        "details": [
     *            "The details field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     *
     *
     */
    public function addPatientFamilyHistory(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1',
            'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
            'details' => 'required|string'
        ]);
        $appointment = Appointments::find($validatedData['appointment_id']);
        $validatedData['child_info'] = NULL;
        if ($appointment->patient_info['case'] == 0) {

            $validatedData['child_info'] = $appointment->patient_info['patient_mobile'];
        } else {
            $validatedData['child_info'] = $appointment->patient_info['id'];
        }
        $validatedData['doctor_id'] = auth()->user()->id;
        $validatedData['unique_id'] = getFamilyHistoryId();
        PatientFamilyHistory::create($validatedData);

        return new SuccessMessage('Details saved successfully.');
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list patient allergic details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam patient_id required integer
     * @queryParam appointment_id  required integer
     * @queryParam name nullable string name of patient
     * @queryParam date nullable date format-> Y-m-d
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "unique_id": "PAD0000001",
     *            "details": "This patient has covid 19 up",
     *            "date": "2020-10-29",
     *            "doctor_name": "Jos"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function getPatientAllergicDetails(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1',
            'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
            'name' => 'nullable',
            'date' => 'nullable|date_format:Y-m-d'
        ]);

        $appointment = Appointments::find($validatedData['appointment_id']);
        if ($appointment->patient_info['case'] == 0) {

            $child_info = $appointment->patient_info['patient_mobile'];
        } else {
            $child_info = $appointment->patient_info['id'];
        }
        $list = PatientAllergicDetails::where('patient_id', $validatedData['patient_id'])->where('child_info', $child_info);

        if ($request->filled('name')) {
            $list = $list->whereHas('doctor', function ($query) use ($validatedData) {
                $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like '%" . $validatedData['name'] . "%' ");
            });
        }
        if ($request->filled('date')) {
            $list = $list->whereDate('created_at', Carbon::parse($request->date));
        }

        $list = $list->orderBy('id', 'desc')->paginate(PatientAllergicDetails::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add patient allergic details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam patient_id integer required
     * @bodyParam appointment_id integer required
     * @bodyParam details string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "patient_id": [
     *            "The patient id field is required."
     *        ],
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ],
     *        "details": [
     *            "The details field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     *
     *
     */
    public function addPatientAllergicDetails(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,is_active,1',
            'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
            'details' => 'required|string'
        ]);

        $appointment = Appointments::find($validatedData['appointment_id']);
        $validatedData['child_info'] = NULL;
        if ($appointment->patient_info['case'] == 0) {

            $validatedData['child_info'] = $appointment->patient_info['patient_mobile'];
        } else {
            $validatedData['child_info'] = $appointment->patient_info['id'];
        }
        $validatedData['doctor_id'] = auth()->user()->id;
        $validatedData['unique_id'] = getAllergicDetailsId();
        PatientAllergicDetails::create($validatedData);

        return new SuccessMessage('Details saved successfully.');
    }
}
