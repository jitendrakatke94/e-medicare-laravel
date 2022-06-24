<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrescriptionsRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\PrescriptionPDFJob;
use App\Model\Appointments;
use App\Model\Followups;
use App\Model\PrescriptionMedList;
use App\Model\Prescriptions;
use App\Model\PrescriptionTestList;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrescriptionsController extends Controller
{
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add Prescription
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam appointment_id integer required
     * @bodyParam info array required
     * @bodyParam info.address string nullable present
     * @bodyParam info.body_temp string nullable present
     * @bodyParam info.age string required
     * @bodyParam info.pulse_rate integer nullable present
     * @bodyParam info.bp_diastolic string nullable present
     * @bodyParam info.bp_systolic string nullable present
     * @bodyParam info.height string nullable present
     * @bodyParam info.weight string nullable present
     * @bodyParam info.case_summary string required
     * @bodyParam info.symptoms string required
     * @bodyParam info.diagnosis string required
     *
     * @bodyParam info.note_to_patient string nullable present
     * @bodyParam info.diet_instruction string nullable present
     * @bodyParam info.despencing_details string nullable present
     * @bodyParam info.investigation_followup string nullable present
     *
     * @bodyParam medicine_list array nullable present
     * @bodyParam medicine_list.*.dosage string required
     * @bodyParam medicine_list.*.no_of_refill integer required
     * @bodyParam medicine_list.*.duration string required
     * @bodyParam medicine_list.*.substitution_allowed boolean required 0 or 1
     * @bodyParam medicine_list.*.instructions string nullable present
     * @bodyParam medicine_list.*.medicine_id integer required id of medicine
     * @bodyParam medicine_list.*.status integer required 0,1,2 where 0 => dispensed at clinic, 1 => dispensed at associated pharmacy, 2 => Dispensed outside
     * @bodyParam medicine_list.*.pharmacy_id required_if medicine_list.*.status is 1
     * @bodyParam medicine_list.*.note string nullable present
     *
     * @bodyParam test_list array nullable present
     * @bodyParam test_list.*.status integer required 0,1,2 where 0 => dispensed at clinic, 1 => dispensed at associated laboratory, 2 => Dispensed outside
     * @bodyParam test_list.*.test_id interger required id of test
     * @bodyParam test_list.*.laboratory_id required_if test_list.*.status is 1
     * @bodyParam test_list.*.instructions string nullable present
     * @bodyParam test_list.*.note string nullable present
     *
     * @bodyParam followup_date data present format -> Y-m-d
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "info.case_summary": [
     *            "The case summary field is required."
     *        ],
     *        "info.symptoms": [
     *            "The current symptoms field is required."
     *        ],
     *        "info.diagnosis": [
     *            "The diagnosis field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Prescription saved successfully."
     *}
     * @response 403 {
     *    "message": "Prescription can't be filled before appointment time."
     *}
     */

    public function addPrescription(PrescriptionsRequest $request)
    {

        $data = $request->validated();
        $appointment = Appointments::find($request->appointment_id);
        $time = convertToUser(now(),  'H:i:s');

        // if ($time < $appointment->time) {
        //     return new ErrorMessage('Prescription can\'t be filled before appointment time.', 403);
        // }

        $test_list = $medicine_list = NULL;
        if ($request->filled('medicine_list')) {
            $medicine_list = $data['medicine_list'];
        }
        if ($request->filled('test_list')) {
            $test_list = $data['test_list'];
        }

        $prescription = Prescriptions::firstOrCreate(
            [
                'appointment_id' => $request->appointment_id,
            ],
            [
                'user_id' => $appointment->patient_id,
                'appointment_id' => $request->appointment_id,
                'unique_id' => getPrescriptionId(),
                'info' => $data['info'],
                'medicine_list' => $medicine_list,
                'test_list' => $test_list,
            ]
        );
        PrescriptionPDFJob::dispatch($prescription);
        $appointment->is_completed = 1;

        if ($request->filled('followup_date')) {
            $appointment->followup_date = $request->followup_date;
            $appointment->followup_one->followup_date = $request->followup_date;
        }
        $appointment->followup_one->save();
        $appointment->save();

        //PrescriptionPDFJob::dispatch($prescription)->delay(now()->addMinutes(1));
        return new SuccessMessage('Prescription saved successfully.');
    }

    /**
     * @authenticated
     *
     * @group Appointments
     *
     * List Prescription
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam patient_id required integer id of patient object
     * @queryParam name nullable string name of patient
     * @queryParam date nullable date format-> Y-m-d
     *
     * @response {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "patient_id": [
     *            "The selected patient id is invalid."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "appointment_id": 3,
     *            "diagnosis": "this patient has corona",
     *            "comments": null,
     *            "dispensed_at_clinic": 1,
     *            "medicine_list": [
     *                {
     *                    "comment": "take 2 tables",
     *                    "medicine_id": "1"
     *                },
     *                {
     *                    "comment": "take 5 tables",
     *                    "medicine_id": "2"
     *                }
     *            ],
     *            "test_list": [
     *                {
     *                    "comment": "take 2 tables",
     *                    "test_id": "1"
     *                }
     *            ],
     *            "dispense_type": null,
     *            "created_at": "2020-12-02T06:03:17.000000Z",
     *            "updated_at": "2020-12-02T06:04:18.000000Z",
     *            "pdf_url": "http://localhost/fms-api-laravel/public/storage/uploads/prescription/1-1606889057.pdf",
     *            "appointment": {
     *                "id": 3,
     *                "doctor_id": 2,
     *                "patient_id": 3,
     *                "appointment_unique_id": "AP0000003",
     *                "date": "2020-12-03",
     *                "time": "11:00 AM",
     *                "consultation_type": "INCLINIC",
     *                "shift": "MORNING",
     *                "payment_status": "PAID",
     *                "transaction_id": 1,
     *                "total": "700.00",
     *                "is_cancelled": 0,
     *                "is_completed": 0,
     *                "booking_date": "2020-12-01",
     *                "doctor": {
     *                    "id": 2,
     *                    "first_name": "Theophilus",
     *                    "middle_name": "Jos",
     *                    "last_name": "Simeon",
     *                    "email": "theophilus@logidots.com",
     *                    "username": "theo",
     *                    "country_code": "+91",
     *                    "mobile_number": "8940330536",
     *                    "user_type": "DOCTOR",
     *                    "is_active": "1",
     *                    "role": null,
     *                    "approved_date": "2020-12-01",
     *                    "profile_photo_url": null,
     *                    "approved_by": "Super  Admin"
     *                }
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/appointments/prescription?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/appointments/prescription?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/appointments/prescription",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     *
     */
    public function listPrescription(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer|exists:users,id,deleted_at,NULL,user_type,PATIENT,is_active,1',
            'appointment_id' => 'required|integer|exists:appointments,id,deleted_at,NULL',
            'name' => 'nullable',
            'date' => 'nullable|date_format:Y-m-d'
        ]);
        $appointment = Appointments::find($request->appointment_id);
        if ($appointment->patient_info['case'] == 0) { // some one else
            $child_info = $appointment->patient_info['patient_mobile'];
            $case = 0;
            $param = 'mobile';
        } else if ($appointment->patient_info['case'] == 2) { //family members
            $case = 2;
            $child_info = $appointment->patient_info['id'];
            $param = 'id';
        } else {
            $case = 1;
            $child_info = $appointment->patient_info['id'];
            $param = 'id';
        }

        $list = Prescriptions::whereHas('appointment', function ($query) use ($request, $case, $param, $child_info) {
            $query->where('patient_id', $request->patient_id);
            $query->where('is_completed', 1);
            if ($param == 'mobile') {
                $query->whereJsonContains('patient_info', ['case' => $case, 'patient_mobile' => $child_info]);
            } else {
                $query->whereJsonContains('patient_info', ['case' => $case, 'id' => $child_info]);
            }
        })->with('appointment.doctor');

        if ($request->filled('name')) {

            $list = $list->whereHas('appointment.doctor', function ($query) use ($request) {

                $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like '%" . $request->name . "%' ");
            });
        }

        if ($request->filled('date')) {
            $list = $list->whereDate('created_at', Carbon::parse($request->date));
        }

        $list = $list->orderBy('id', 'desc')->paginate(Prescriptions::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Download Prescription pdf
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam appointment_id required integer id of appointment

     * @response {
     *    "file":"file downloads directly"
     *}
     * @response 404 {
     *    "message": "File not found."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "appointment_id": [
     *            "The selected appointment id is invalid."
     *        ]
     *    }
     *}
     */
    public function download(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);
        try {
            $prescriptions = Prescriptions::where('appointment_id', $request->appointment_id)->firstOrFail();

            $file_path = storage_path() . "/app/" . $prescriptions->file_path;
            if (file_exists($file_path)) {

                $content_type = mime_content_type($file_path);
                $headers = array(
                    'Content-Type: ' . $content_type,
                );
                return \Response::download($file_path, $prescriptions->unique_id, $headers);
            }
            return new ErrorMessage('File not found.', 404);
        } catch (\Exception $exception) {
            return new ErrorMessage('File not found.', 404);
        }
    }
}
