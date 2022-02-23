<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorWorkingHoursRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Appointments;
use App\Model\DoctorOffDays;
use App\Model\DoctorTimeSlots;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorWorkingHoursController extends Controller
{

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list Working Hours
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam day required string anyone of ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "day": [
     *            "The day field is required."
     *        ]
     *    }
     *}
     *
     * @response 200{
     *    "data": [
     *        {
     *            "shift": "EVENING",
     *            "type": "OFFLINE",
     *            "day": "TUESDAY",
     *            "working_hours": [
     *                {
     *                    "slot_end": "17:30",
     *                    "slot_start": "17:00"
     *                },
     *                {
     *                    "slot_end": "16:30",
     *                    "slot_start": "16:00"
     *                }
     *            ],
     *            "address": {
     *                "id": 1,
     *                "street_name": "South Road",
     *                "city_village": "Edamattom",
     *                "district": "Kottayam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "686575",
     *                "country_code": null,
     *                "contact_number": null,
     *                "land_mark": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "cronin",
     *                "laravel_through_key": 1
     *            }
     *        }
     *    ],
     *    "time_intravel": 10
     *}
     * @response 404 {
     *    "message": "Working Hours not found."
     *}
     *
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'day' => 'required|in:MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,SUNDAY',
            'doctor_clinic_id' => 'required',
            'paginate' => 'nullable|in:0',
        ]);

        $list = DoctorTimeSlots::withoutGlobalScopes()
            ->has("address")
            ->has("timeSlots")
            ->with("timeSlots")
            ->where("user_id", auth()->user()->id)
            ->where("doctor_clinic_id", $data['doctor_clinic_id'])
            ->where("day", $data['day'])
            ->where("parent_id", null)
            ->orderBy("slot_start", "asc")
            ->get();

        $info['data'] = $list;
        $info['time_interval'] = auth()->user()->doctor->time_intravel;
        return response()->json($info, 200);
    }


    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add / edit working hours
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam day string required anyone of ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']
     * @bodyParam shift string required anyone of ['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT']
     * @bodyParam type string required anyone of ['OFFLINE', 'ONLINE','BOTH']
     * @bodyParam doctor_clinic_id integer required set id from clinic_info from api call https://api.doctor-app.alpha.logidots.com/docs/#doctor-list-address
     * @bodyParam working_hours[0][slot_start] time required format H:i format 24 hours
     * @bodyParam working_hours[0][slot_end] time required format H:i format 24 hours
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "working_hours": [
     *            "The working hours field is required."
     *        ],
     *        "day": [
     *            "The day field is required."
     *        ],
     *        "shift": [
     *            "The shift field is required."
     *        ],
     *        "doctor_clinic_id": [
     *            "The doctor clinic id field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Working hours added / updated successfully."
     *}
     */
    public function store(Request $request)
    {
        $data = $request->all();

        DoctorTimeSlots::withoutGlobalScopes()
            ->where('user_id', auth()->user()->id)
            ->where('doctor_clinic_id', $data['doctor_clinic_id'])
            ->where("day", $data['day'])
            ->delete();

        foreach ($data['working_hours'] as $workinghour) {
            $insertedWorkingHour = DoctorTimeSlots::create([
                'user_id' => auth()->user()->id,
                'day' => $data['day'],
                'slot_start' => $workinghour['start_time'],
                'slot_end' => $workinghour['end_time'],
                'type' => $workinghour['type'],
                'doctor_clinic_id' => $data['doctor_clinic_id'],
                'shift' => $workinghour['shift']
            ]);

            DoctorTimeSlots::insert(
                array_map(function ($timeslot) use ($data, $workinghour, $insertedWorkingHour) {
                    return [
                        'day' => $data['day'],
                        'slot_start' => convertToUTC($timeslot[0]),
                        'slot_end' => convertToUTC($timeslot[1]),
                        'type' => $workinghour['type'],
                        'doctor_clinic_id' => $data['doctor_clinic_id'],
                        'shift' => $workinghour['shift'],
                        'user_id' => auth()->user()->id,
                        'parent_id' => $insertedWorkingHour->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }, $workinghour['time_slots'])
            );
        }
        $rows = DoctorTimeSlots::where('user_id', auth()->user()->id)
            ->where('doctor_clinic_id', $data['doctor_clinic_id'])
            ->where("day", $data['day'])
            ->get();

        $day = $data['day'];
        if ($rows) {
            $rows = $rows->toArray();
        } else {
            $rows = array();
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
        return new SuccessMessage('Working hours added / updated successfully.');
    }

    public function createSystemOffDays($day, $rows, $appointments)
    {
        $start_time = Carbon::parse($appointments->start_time);
        $end_time = Carbon::parse($appointments->end_time);
        foreach ($rows as $key => $row) {

            if ($start_time->between(Carbon::parse($row['slot_start'])->addMinute(), Carbon::parse($row['slot_end'])->subMinute()) || $end_time->between(Carbon::parse($row['slot_start'])->addMinute(), Carbon::parse($row['slot_end'])->subMinute())) {

                //make entry in doctor off table
                DoctorOffDays::create([
                    'user_id' => auth()->user()->id,
                    'date' => $appointments->date,
                    'day' => $day,
                    'slot_start' => $row['slot_start'],
                    'slot_end' => $row['slot_end'],
                    'time_slot_ids' => $row['id'],
                    'created_by_system' => 1,
                ]);
            }
        }
        return;
    }
}
