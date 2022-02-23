<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorOffDaysRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\DoctorOffDays;
use App\Model\DoctorTimeSlots;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;

class DoctorOffDaysController extends Controller
{
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor validate Timeslot to assign off days
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam date date required
     * @bodyParam slot_start time required format H:i format 24 hours
     * @bodyParam slot_end time required format H:i format 24 hours
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "date": [
     *            "The date does not match the format Y-m-d."
     *        ],
     *        "slot_start": [
     *            "The slot start field is required."
     *        ],
     *        "slot_end": [
     *            "The slot end does not match the format H:i."
     *        ]
     *    }
     *}
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
     *        "id": 10,
     *        "day": "FRIDAY",
     *        "slot_start": "09:30:00",
     *        "slot_end": "10:30:00",
     *        "type": "ONLINE",
     *        "doctor_clinic_id": 2,
     *        "shift": "MORNING"
     *    }
     *]
     *
     * @response 200{
     *    "message": true
     *}
     */
    public function validateTimeSlot(DoctorOffDaysRequest $request)
    {

        $day = Carbon::parse($request->date)->format('l');
        $day = Str::upper($day);
        $timeSlots = DoctorTimeSlots::where('user_id', auth()->user()->id)->where('day', $day)->get();
        $result = array();

        if ($timeSlots) {
            foreach ($timeSlots as $key => $timeSlot) {

                $slot_start = Carbon::parse($timeSlot->slot_start)->addSecond();
                $slot_end = Carbon::parse($timeSlot->slot_end)->subSecond();

                $slot_start_request = Carbon::parse($request->slot_start);
                $slot_end_request = Carbon::parse($request->slot_end);

                if ($slot_start->between($slot_start_request, $slot_end_request) || $slot_end->between($slot_start_request, $slot_end_request)) {
                    $result[] = $timeSlot;
                }
            }
        }

        if (!empty($result)) {

            return response()->json($result, 200);
        }
        $result['message'] = true;
        return response()->json($result, 200);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor schedule Offdays
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam row[0][date] date required format Y-m-d
     * @bodyParam row[0][slot_start] time required format H:i format 24 hours for full dayoff send time as 00:01
     * @bodyParam row[0][slot_end] time required format H:i format 24 hours for full dayoff send time as 23:59
     *
     * @response 403 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "row.0.date": [
     *            "The row.0.date field is required."
     *        ],
     *        "row.0.slot_start": [
     *            "The row.0.slot_start does not match the format H:i."
     *        ],
     *        "row.0.slot_end": [
     *            "The row.0.slot_end does not match the format H:i."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Offdays scheduled successfully."
     *}
     *
     * @response 404 {
     *    "message": "No inputs given."
     *}
     */
    public function scheduleOffdays(DoctorOffDaysRequest $request)
    {
        if ($request->filled('row')) {

            foreach ($request->row as $key => $row) {

                $day = Carbon::parse($row['date'])->format('l');
                $day = Str::upper($day);
                $timeSlots = DoctorTimeSlots::where('user_id', auth()->user()->id)->where('day', $day)->get();
                $result = array();

                foreach ($timeSlots as $key => $timeSlot) {

                    $slot_start = Carbon::parse($timeSlot->slot_start)->addSecond();
                    $slot_end = Carbon::parse($timeSlot->slot_end)->subSecond();

                    $slot_start_request = Carbon::parse($row['slot_start']);
                    $slot_end_request = Carbon::parse($row['slot_end']);

                    if ($slot_start->between($slot_start_request, $slot_end_request) || $slot_end->between($slot_start_request, $slot_end_request)) {
                        $result[] = $timeSlot->id;
                    }
                }

                DoctorOffDays::updateOrCreate(
                    [
                        'user_id' => auth()->user()->id,
                        'date' => $row['date'],
                        'day' => $day,
                        'slot_start' => convertToUTC($row['slot_start'], 'H:i:s'),
                        'slot_end' => convertToUTC($row['slot_end'], 'H:i:s'),

                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'date' => $row['date'],
                        'day' => $day,
                        'slot_start' => $row['slot_start'],
                        'slot_end' => $row['slot_end'],
                        'time_slot_ids' => implode(',', $result),
                    ]
                );
            }
            return new SuccessMessage('Offdays scheduled successfully.');
        }
        return new ErrorMessage('No inputs given.', 404);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list Offdays
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "user_id": 1,
     *            "date": "2020-09-18",
     *            "day": "FRIDAY",
     *            "slot_start": "09:30",
     *            "slot_end": "10:30"
     *        },
     *        {
     *            "id": 2,
     *            "user_id": 1,
     *            "date": "2020-09-23",
     *            "day": "WEDNESDAY",
     *            "slot_start": "00:01",
     *            "slot_end": "23:59"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays",
     *    "per_page": 15,
     *    "prev_page_url": null,
     *    "to": 2,
     *    "total": 2
     *}
     *
     * @response 404 {
     *    "message": "Offdays not found."
     *}
     */
    public function getOffdays()
    {
        $date = Carbon::now()->format('Y-m-d');
        $list = DoctorOffDays::where('user_id', auth()->user()->id)->where('date', '>=', $date)->where('created_by_system', 0)->orderBy('id', 'desc')->paginate(DoctorOffDays::$page);
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('Offdays not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor delete Offday
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "message": "Offday deleted successfully."
     *}
     *@response 404 {
     *    "message": "Offday not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function destroy($id)
    {
        try {
            $off_days = DoctorOffDays::where('user_id', auth()->user()->id)->findOrFail($id);

            $system_off_days = DoctorOffDays::where('user_id', auth()->user()->id)->where('date', '=', $off_days->date)->where('created_by_system', 1)->whereBetween('slot_start', [$off_days->slot_start, $off_days->slot_end])->whereBetween('slot_end', [$off_days->slot_start, $off_days->slot_end])->pluck('id');

            if ($system_off_days->isNotEmpty()) {
                DoctorOffDays::whereIn('id', $system_off_days->toArray())->delete();
            }
            $off_days->delete();
            return new SuccessMessage('Offday deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Offday not found.', 404);
        }
    }
}
