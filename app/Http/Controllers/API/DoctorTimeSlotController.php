<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Appointments;
use App\Model\DoctorOffDays;
use App\Model\DoctorTimeSlots;
use Carbon\Carbon;

class DoctorTimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list Time slot
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "day": "FRIDAY",
     *        "slot_start": "09:30:00",
     *        "slot_end": "10:30:00",
     *        "type": "ONLINE",
     *        "doctor_clinic_id": 1,
     *        "shift": "MORNING"
     *    },
     *    {
     *        "id": 2,
     *        "day": "MONDAY",
     *        "slot_start": "10:30:00",
     *        "slot_end": "10:45:00",
     *        "type": "ONLINE",
     *        "doctor_clinic_id": 1,
     *        "shift": "MORNING"
     *    },
     *    {
     *        "id": 3,
     *        "day": "WEDNESDAY",
     *        "slot_start": "11:00:00",
     *        "slot_end": "11:30:00",
     *        "type": "ONLINE",
     *        "doctor_clinic_id": 1,
     *        "shift": "MORNING"
     *    },
     *    {
     *        "id": 4,
     *        "day": "WEDNESDAY",
     *        "slot_start": "18:30:00",
     *        "slot_end": "18:40:00",
     *        "type": "ONLINE",
     *        "doctor_clinic_id": 3,
     *        "shift": "EVENING"
     *    }
     *]
     *
     * @response 404 {
     *    "message": "Time slots not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     *
     */
    public function index()
    {
        $list = DoctorTimeSlots::whereHas('address')->where('user_id', auth()->user()->id)->orderBy('slot_start', 'asc')->get();

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('Time slots not found', 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add / edit Time slot ABANDONED
     *
     * Authorization: "Bearer {access_token}"
     *
     * row = array with multiple objects of values
     *
     * @bodyParam row[0][day] string required anyone of ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']
     * @bodyParam row[0][slot_start] time required format H:i format 24 hours
     * @bodyParam row[0][slot_end] time required format H:i format 24 hours
     * @bodyParam row[0][type] string required anyone of ['OFFLINE', 'ONLINE','BOTH']
     * @bodyParam row[0][shift] string required anyone of ['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT']
     * @bodyParam row[0][doctor_clinic_id] integer required set id from clinic_info from api call https://api.doctor-app.alpha.logidots.com/docs/#doctor-list-address
     *
     *
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "row.1.day": [
     *            "The row.1.day field is required."
     *        ],
     *        "row.0.slot_start": [
     *            "The row.0.slot_start field has a duplicate value."
     *        ],
     *        "row.1.slot_start": [
     *            "The row.1.slot_start field has a duplicate value."
     *        ],
     *        "row.0.type": [
     *            "The row.0.type field is required."
     *        ],
     *        "row.0.shift": [
     *            "The row.0.shift field is required."
     *        ],
     *        "row.0.doctor_clinic_id": [
     *            "The row.0.doctor_clinic_id field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Time slots added / updated successfully"
     *}
     */
    public function store(DoctorRequest $request)
    {
        return 404;
        $rows = $request->validated()['row'];
        $day = $rows[0]['day'];

        $record = DoctorTimeSlots::where('user_id', auth()->user()->id)->where('day', $day)->pluck('id');

        //deleting all the old records
        if ($record->isNotEmpty()) {
            DoctorTimeSlots::whereIn('id', $record->toArray())->delete();
        }
        foreach ($rows as $key => $row) {
            $row['user_id'] = auth()->user()->id;
            $slot = DoctorTimeSlots::create($row);
            $rows[$key]['time_slot_id'] = $slot->id;
        }

        $old_appointments = Appointments::where('is_cancelled', 0)->where('is_completed', 0)->where('date', '>=', now()->format('Y-m-d'))->where('doctor_id', auth()->user()->id)->get();

        foreach ($old_appointments as $key => $appointments) {
            // check current time for today's appointment
            if ($appointments->date == now()->format('Y-m-d')) {

                if (Carbon::parse($appointments->time, 'UTC')->gte(Carbon::now())) {

                    $this->createSystemOffDays($day, $rows, $appointments);
                } else {
                    continue;
                }
            } else {
                $this->createSystemOffDays($day, $rows, $appointments);
            }
        }

        // schedule off days start
        $off_days = DoctorOffDays::where('day', $day)->where('user_id', auth()->user()->id)->where('date', '>=', now()->format('Y-m-d'))->where('created_by_system', 0)->get();
        foreach ($off_days as $key => $off_day) {
            $slot_start = $off_day->slot_start;
            $slot_end = $off_day->slot_end;

            $timeSlots = DoctorTimeSlots::where('user_id', auth()->user()->id)->where('day', $off_day->day)->where('slot_start', '>=', $slot_start)->where('slot_end', '<=', $slot_end)->pluck('id');
            if ($timeSlots->isNotEmpty()) {
                $off_day->time_slot_ids = implode(',', $timeSlots->toArray());
                $off_day->save();
            }
        }
        // schedule off days end
        return new SuccessMessage('Time slots added / updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get Time slot by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "id": 1,
     *    "day": "MONDAY",
     *    "slot_start": "19:45:00",
     *    "slot_end": "19:55:00",
     *    "type": "ONLINE",
     *    "doctor_clinic_id": "1",
     *    "shift": "MORNING"
     *}
     * @response 404 {
     *    "message": "Time slot not found"
     *}
     */
    public function show($id)
    {
        try {
            $record = DoctorTimeSlots::where('user_id', auth()->user()->id)->findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Time slot not found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor delete Time slot
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "message": "Time slot deleted successfully"
     *}
     *@response 404 {
     *    "message": "Time slot not found"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function destroy($id)
    {
        try {
            DoctorTimeSlots::where('user_id', auth()->user()->id)->findOrFail($id)->destroy($id);
            return new SuccessMessage('Time slot deleted successfully');
        } catch (\Exception $exception) {
            return new ErrorMessage('Time slot not found', 404);
        }
    }
}
