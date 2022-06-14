<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentsRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\AppointmentPaymentJob;
use App\Model\Address;
use App\Model\AppCache;
use App\Model\Appointments;
use App\Model\DoctorPersonalInfo;
use App\Model\DoctorTimeSlots;
use App\Model\Followups;
use App\Model\PatientPersonalInfo;
use App\Model\TaxService;
use App\Model\UserCommissions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\AppointmentConfirmationToDoctor;
use Mail;
use App\Traits\sendMobileSms;

class AppointmentsController extends Controller
{
    use sendMobileSms;
    /**
     * @group Appointments
     *
     * Get Details to make appointment
     *
     * Authorization: "Bearer {access_token}" is optional, when a valid access_token is present , user is authenticated and allowed to proceed with payment. If access_token is invalid a redirect_id is provided to contine to payment after successfull login.
     *
     *
     * @bodyParam doctor_id integer required
     * @bodyParam address_id integer required
     * @bodyParam consultation_type string required any one of INCLINIC,ONLINE,EMERGENCY
     * @bodyParam time_stot_id integer required if consultation_type is equal to anyone of INCLINIC,ONLINE
     * @bodyParam date date required format Y-m-d
     * @bodyParam shift string nullable required if consultation_type is equal to EMERGENCY , any one of MORNING, AFTERNOON, EVENING, NIGHT
     * @bodyParam followup_id integer nullable
     * @bodyParam timezone string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "doctor_id": [
     *            "The doctor id field is required."
     *        ],
     *        "address_id": [
     *            "The address id field is required."
     *        ],
     *         "time_stot_id": [
     *            "The time stot id field is required."
     *        ],
     *        "consultation_type": [
     *            "The Consultation type stot id field is required."
     *        ],
     *        "date": [
     *            "The date field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "redirect_id": 2
     *}
     *
     * @response 200 {
     *    "id": 2,
     *    "doctor_unique_id": "4",
     *    "title": "Dr.",
     *    "gender": "MALE",
     *    "date_of_birth": "1975-12-03",
     *    "age": 8,
     *    "qualification": "eum",
     *    "years_of_experience": "5",
     *    "alt_mobile_number": null,
     *    "clinic_name": null,
     *    "career_profile": null,
     *    "education_training": null,
     *    "experience": null,
     *    "clinical_focus": null,
     *    "awards_achievements": null,
     *    "memberships": null,
     *    "profile_photo": null,
     *    "appointment_type_online": null,
     *    "appointment_type_offline": null,
     *    "consulting_online_fee": null,
     *    "consulting_offline_fee": null,
     *    "available_from_time": null,
     *    "available_to_time": null,
     *    "service": null,
     *    "address": {
     *        "id": 2,
     *        "street_name": "Waters Cape",
     *        "city_village": "817 Theresa Summit",
     *        "district": "Lennyborough",
     *        "state": "Louisiana",
     *        "country": "Mali",
     *        "pincode": "94379",
     *        "contact_number": "782.971.9321",
     *        "latitude": "-13.71597100",
     *        "longitude": "-76.15551600"
     *    },
     *    "time_slot": {
     *        "id": 1,
     *        "day": "FRIDAY",
     *        "slot_start": "19:30:00",
     *        "slot_end": "19:40:00",
     *        "type": "ONLINE",
     *        "doctor_clinic_id": 1,
     *        "shift": "MORNING"
     *    },
     *    "patient": [
     *        {
     *            "id": 2,
     *            "first_name": "ammu",
     *            "middle_name": null,
     *            "last_name": "prasad",
     *            "email": "ammu.prasad@logidots.com",
     *            "username": "ammu",
     *            "country_code": "+91",
     *            "mobile_number": "7591985087",
     *            "user_type": "PATIENT",
     *            "profile_photo_url": "http://localhost/fms-api-laravel/public/storage/uploads/2/1601270200-4cb339a2-fb1e-4c3c-8ada-fe9e6566e7db.jpeg",
     *            "family": [
     *                {
     *                    "id": 1,
     *                    "patient_family_id": "P0000001F01",
     *                    "title": "Mr",
     *                    "first_name": "ben",
     *                    "middle_name": "M",
     *                    "last_name": "ten",
     *                    "gender": "MALE",
     *                    "date_of_birth": "1998-06-19",
     *                    "age": 27,
     *                    "height": 160,
     *                    "weight": 90,
     *                    "marital_status": "SINGLE",
     *                    "occupation": "nothing to work",
     *                    "relationship": "SON",
     *                    "current_medication": "fever"
     *                },
     *                {
     *                    "id": 2,
     *                    "patient_family_id": "P0000001F02",
     *                    "title": "Mr",
     *                    "first_name": "ben",
     *                    "middle_name": "M",
     *                    "last_name": "ten",
     *                    "gender": "MALE",
     *                    "date_of_birth": "1998-06-19",
     *                    "age": 27,
     *                    "height": 160,
     *                    "weight": 90,
     *                    "marital_status": "SINGLE",
     *                    "occupation": "nothing to work",
     *                    "relationship": "SON",
     *                    "current_medication": "fever"
     *                }
     *            ]
     *        }
     *    ],
     *    "consultation_type": "INCLINIC",
     *    "shift": "MORNING",
     *    "followup_id": "2",
     *    "date": "2020-09-23",
     *    "user": {
     *        "id": 5,
     *        "first_name": "Mrs. Bessie Strosin",
     *        "middle_name": "Miss Trisha Walter",
     *        "last_name": "Rocky Batz"
     *    },
     *    "specialization": [
     *          {
     *            "id": 7,
     *            "name": "Dietitian",
     *            "pivot": {
     *                "doctor_personal_info_id": 1,
     *                "specializations_id": 7
     *            }
     *        },
     *        {
     *            "id": 8,
     *            "name": "Pulmonologist",
     *            "pivot": {
     *                "doctor_personal_info_id": 1,
     *                "specializations_id": 8
     *            }
     *        }
     *    ]
     *}
     */
    public function getDetailsForAppointment(AppointmentsRequest $request)
    {
        $validatedData = $request->validated();

        $doctor_id = $validatedData['doctor_id'];
        $address_id = $validatedData['address_id'];
        $time_slot_id = $validatedData['time_slot_id'];
        $date = $validatedData['date'];
        $shift = NULL;
        if ($validatedData['consultation_type'] == 'EMERGENCY') {
            $time_slot_id = NULL;
            $shift = $validatedData['shift'];
        }
        $followup_id = NULL;
        if ($request->filled('followup_id')) {
            $followup_id = $validatedData['followup_id'];
        }
        // user is not logged in or invalid token
        if (!Auth::guard('api')->check()) {
            $appCache = AppCache::create(
                [
                    'doctor_id' => $doctor_id,
                    'address_id' => $address_id,
                    'time_slot_id' => $time_slot_id,
                    'consultation_type' => $validatedData['consultation_type'],
                    'date' => $date,
                    'shift' => $shift,
                    'followup_id' => $followup_id
                ]
            );
            return response()->json(['redirect_id' => $appCache->id], 200);
        }
        //user has a valid token
        $user = Auth::guard('api')->user();
        if ($user->user_type != 'PATIENT') {
            return new ErrorMessage('You do not have the required authorization.', 403);
        }

        $data = $this->fetchDetails($doctor_id, $address_id, $time_slot_id);
        $data['consultation_type'] = $validatedData['consultation_type'];
        $data['date'] = $validatedData['date'];
        $data['shift'] = $shift;
        $data['followup_id'] = $followup_id;
        return response()->json($data, 200);
    }

    public function fetchDetails($doctor_id, $address_id, $time_slot_id)
    {
        $doctor = DoctorPersonalInfo::with('user:id,first_name,middle_name,last_name')->with('specialization')->where('user_id', $doctor_id)->first();

        $doctor['address'] = [];
        $address = Address::find($address_id);
        if ($address) {
            $doctor['address'] = $address->toArray();
        }
        $doctor['time_slot'] = [];
        $time_slot = DoctorTimeSlots::find($time_slot_id);
        if ($time_slot) {
            $doctor['time_slot'] = $time_slot->toArray();
        }

        $doctor['patient'] = User::where('id', auth('api')->user()->id)->with('family')->get()->toArray();

        return $doctor;
    }

    /**
     * @group Appointments
     *
     * Continue with draft appointment
     *
     * @authenticated
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam redirect_id required integer
     *
     * @response 200 {
     *    "id": 2,
     *    "doctor_unique_id": "4",
     *    "title": "Dr.",
     *    "gender": "MALE",
     *    "date_of_birth": "1975-12-03",
     *    "age": 8,
     *    "qualification": "eum",
     *    "years_of_experience": "5",
     *    "alt_mobile_number": null,
     *    "clinic_name": null,
     *    "career_profile": null,
     *    "education_training": null,
     *    "experience": null,
     *    "clinical_focus": null,
     *    "awards_achievements": null,
     *    "memberships": null,
     *    "profile_photo": null,
     *    "appointment_type_online": null,
     *    "appointment_type_offline": null,
     *    "consulting_online_fee": null,
     *    "consulting_offline_fee": null,
     *    "available_from_time": null,
     *    "available_to_time": null,
     *    "service": null,
     *    "address": {
     *        "id": 2,
     *        "street_name": "Waters Cape",
     *        "city_village": "817 Theresa Summit",
     *        "district": "Lennyborough",
     *        "state": "Louisiana",
     *        "country": "Mali",
     *        "pincode": "94379",
     *        "contact_number": "782.971.9321",
     *        "latitude": "-13.71597100",
     *        "longitude": "-76.15551600"
     *    },
     *    "time_slot": {
     *        "id": 1,
     *        "day": "FRIDAY",
     *        "slot_start": "19:30:00",
     *        "slot_end": "19:40:00",
     *        "type": "ONLINE",
     *        "doctor_clinic_id": 1,
     *        "shift": "MORNING"
     *    },
     *    "patient": [
     *        {
     *            "id": 2,
     *            "first_name": "ammu",
     *            "middle_name": null,
     *            "last_name": "prasad",
     *            "email": "ammu.prasad@logidots.com",
     *            "username": "ammu",
     *            "country_code": "+91",
     *            "mobile_number": "7591985087",
     *            "user_type": "PATIENT",
     *            "profile_photo_url": "http://localhost/fms-api-laravel/public/storage/uploads/2/1601270200-4cb339a2-fb1e-4c3c-8ada-fe9e6566e7db.jpeg",
     *            "user": {
     *                "id": 2,
     *                "first_name": "ammu",
     *                "middle_name": "ammu",
     *                "last_name": "phil",
     *                "mobile_number": "+917591985087",
     *                "email": "ammu.prasad@logidots.com"
     *            },
     *            "family": [
     *                {
     *                    "id": 1,
     *                    "patient_family_id": "P0000001F01",
     *                    "title": "Mr",
     *                    "first_name": "ben",
     *                    "middle_name": "M",
     *                    "last_name": "ten",
     *                    "gender": "MALE",
     *                    "date_of_birth": "1998-06-19",
     *                    "age": 27,
     *                    "height": 160,
     *                    "weight": 90,
     *                    "marital_status": "SINGLE",
     *                    "occupation": "nothing to work",
     *                    "relationship": "SON",
     *                    "current_medication": "fever"
     *                },
     *                {
     *                    "id": 2,
     *                    "patient_family_id": "P0000001F02",
     *                    "title": "Mr",
     *                    "first_name": "ben",
     *                    "middle_name": "M",
     *                    "last_name": "ten",
     *                    "gender": "MALE",
     *                    "date_of_birth": "1998-06-19",
     *                    "age": 27,
     *                    "height": 160,
     *                    "weight": 90,
     *                    "marital_status": "SINGLE",
     *                    "occupation": "nothing to work",
     *                    "relationship": "SON",
     *                    "current_medication": "fever"
     *                }
     *            ]
     *        }
     *    ],
     *    "consultation_type": "INCLINIC",
     *    "shift": "MORNING",
     *    "followup_id": "2",
     *    "date": "2020-09-23",
     *    "user": {
     *        "id": 5,
     *        "first_name": "Mrs. Bessie Strosin",
     *        "middle_name": "Miss Trisha Walter",
     *        "last_name": "Rocky Batz"
     *    },
     *    "specialization": [
     *          {
     *            "id": 7,
     *            "name": "Dietitian",
     *            "pivot": {
     *                "doctor_personal_info_id": 1,
     *                "specializations_id": 7
     *            }
     *        },
     *        {
     *            "id": 8,
     *            "name": "Pulmonologist",
     *            "pivot": {
     *                "doctor_personal_info_id": 1,
     *                "specializations_id": 8
     *            }
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Redirect id not found."
     *}
     */
    public function continueWithAppointment($id)
    {
        // TODO check time slot is available
        try {
            $record = AppCache::findOrFail($id);

            $data = $this->fetchDetails($record->doctor_id, $record->address_id, $record->time_slot_id);
            $data['consultation_type'] = $record->consultation_type;
            $data['date'] = $record->date;
            $data['followup_id'] = $record->followup_id;
            $data['shift'] = $record->shift;
            //$record->delete();
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Redirect id not found', 404);
        }
    }

    /**
     * @group Appointments
     *
     * Create appointment
     *
     * @authenticated
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam doctor_id integer required
     * @bodyParam address_id integer required
     * @bodyParam patient_id integer required
     * @bodyParam consultation_type string required anyone of INCLINIC,ONLINE,EMERGENCY
     * @bodyParam time_slot_id integer required
     * @bodyParam date date required format -> Y-m-d
     * @bodyParam shift string nullable anyone of MORNING,AFTERNOON,EVENING,NIGHT required_if consultation_type is EMERGENCY
     * @bodyParam followup_id integer nullable
     * @bodyParam patient_info.mobile_code string required
     * @bodyParam patient_info.mobile string required
     * @bodyParam patient_info.first_name string required
     * @bodyParam patient_info.middle_name string nullable
     * @bodyParam patient_info.last_name string required
     * @bodyParam patient_info.patient_mobile_code string required
     * @bodyParam patient_info.patient_mobile string required
     * @bodyParam patient_info.email string nullable
     * @bodyParam patient_info.case interger required 0 for someonelse, 1 for current patient, 2 for family member
     * @bodyParam patient_info.id integer nullable patient_id or family_member_id
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "doctor_id": [
     *            "The doctor id field is required."
     *        ],
     *        "address_id": [
     *            "The address id field is required."
     *        ],
     *        "patient_id": [
     *            "The patient id field is required."
     *        ],
     *        "consultation_type": [
     *            "The consultation type field is required."
     *        ],
     *        "date": [
     *            "The date must be a date after or equal to now."
     *        ]
     *    }
     *}
     * @response 403 {
     *    "message": "Time slot already booked."
     *}
     * @response 403 {
     *    "message": "Emergency appointment can't be booked."
     *}
     * @response 200 {
     *    "appointment_id": 1,
     *    "type": "FOLLOWUP",
     *    "message": "Appointment created successfully."
     *}
     * @response 200 {
     *    "id": 484,
     *    "doctor_id": 2,
     *    "patient_id": 3,
     *    "appointment_unique_id": "AP0000484",
     *    "date": "2021-04-03",
     *    "time": "18:00:00",
     *    "consultation_type": "ONLINE",
     *    "shift": null,
     *    "payment_status": null,
     *    "transaction_id": null,
     *    "total": null,
     *    "tax": null,
     *    "commission": null,
     *    "is_cancelled": 0,
     *    "is_completed": 0,
     *    "followup_id": null,
     *    "booking_date": "2021-03-03",
     *    "current_patient_info": {
     *        "user": {
     *            "first_name": "Ben",
     *            "middle_name": null,
     *            "last_name": "Patient",
     *            "email": "patient@logidots.com",
     *            "country_code": "+91",
     *            "mobile_number": "9876543210",
     *            "profile_photo_url": null
     *        },
     *        "case": 0,
     *        "info": {
     *            "first_name": "someoneElse",
     *            "middle_name": null,
     *            "last_name": "Two",
     *            "email": "patient@logidots.com",
     *            "country_code": "+91",
     *            "mobile_number": 9876543210,
     *            "height": null,
     *            "weight": null,
     *            "gender": null,
     *            "age": null
     *        },
     *        "address": {
     *            "id": 36,
     *            "street_name": "Sreekariyam",
     *            "city_village": "Trivandrum",
     *            "district": "Alappuzha",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "688001",
     *            "country_code": null,
     *            "contact_number": null,
     *            "land_mark": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *        }
     *    },
     *    "doctor": {
     *        "id": 2,
     *        "first_name": "Theophilus",
     *        "middle_name": "Jos",
     *        "last_name": "Simeon",
     *        "email": "theophilus@logidots.com",
     *        "username": "theo",
     *        "country_code": "+91",
     *        "mobile_number": "8940330536",
     *        "user_type": "DOCTOR",
     *        "is_active": "1",
     *        "role": null,
     *        "currency_code": "INR",
     *        "approved_date": "2021-01-04",
     *        "profile_photo_url": null
     *    },
     *    "clinic_address": {
     *        "id": 1,
     *        "street_name": "South Road",
     *        "city_village": "Edamatto",
     *        "district": "Kottayam",
     *        "state": "Kerala",
     *        "country": "India",
     *        "pincode": "686575",
     *        "country_code": null,
     *        "contact_number": "9786200983",
     *        "land_mark": null,
     *        "latitude": "10.53034500",
     *        "longitude": "76.21472900",
     *        "clinic_name": "Neo clinic"
     *    },
     *    "tax_percent": 15,
     *    "total_commission": 15,
     *    "total_tax": 15,
     *    "total_fees": 150,
     *    "type": "NEW_APPOINTMENT"
     *}
     */
    public function confirmAppointment(AppointmentsRequest $request)
    {
        $time = $shift = $followup_id = $start_time = $end_time = NULL;
        if ($request->filled('shift')) {
            $shift = $request->shift;
        }
        if ($request->filled('followup_id')) {
            $followup_id = $request->followup_id;
        }
        $time_slot = DoctorTimeSlots::with('address')->find($request->time_slot_id);
        if ($time_slot) {
            $time = $time_slot->slot_start;
            $start_time = $time_slot->slot_start;
            $end_time = $time_slot->slot_end;
        }
        $doctor = DoctorPersonalInfo::where('user_id', $request->doctor_id)->first();

        if ($request->consultation_type == 'EMERGENCY') {
            // check doctor emergency values
            if (!is_null($doctor->emergency_fee)) {
                $appointments = Appointments::where('date', $request->date)->where('doctor_id', $request->doctor_id)->where('shift', $shift)->where('is_completed', 0)->where('is_cancelled', 0)->get();

                if ($appointments->count() + 1 > $doctor->emergency_appointment) {
                    return new ErrorMessage('Emergency appointment can\'t be booked.', 403);
                }
            } else {
                return new ErrorMessage('Emergency appointment can\'t be booked.', 403);
            }
        } else {
            $appointments = Appointments::where('doctor_time_slots_id', $request->time_slot_id)->where('date', $request->date)->where('doctor_id', $request->doctor_id)->where('is_completed', 0)->where('is_cancelled', 0)->first();
            $shift = NULL;
            if ($appointments) {
                return new ErrorMessage('Time slot already booked.', 403);
            }
        }
        $address_id = $request->address_id;
        $appointment = Appointments::create(
            [
                'appointment_unique_id' => getAppointmentId(),
                'doctor_id' => $request->doctor_id,
                'address_id' => $address_id,
                'patient_id' => $request->patient_id,
                'consultation_type' => $request->consultation_type,
                'date' => $request->date,
                'time' => $time,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'doctor_time_slots_id' => $request->time_slot_id,
                'shift' => $shift,
                'payment_status' => 'Not Paid',
                'followup_id' => $followup_id,
                'patient_info' => $request->patient_info,
                'cancel_time' => $doctor->cancel_time_period,
                'reschedule_time' => $doctor->reschedule_time_period,
            ]
        );

        if (!is_null($followup_id)) {
            $appointment->payment_status = 'Free';
            $appointment->save();
            Followups::find($followup_id)->destroy($followup_id);
            return response()->json(['appointment_id' => $appointment->id, 'type' => 'FOLLOWUP', 'message' => 'Appointment created successfully.'], 200);
        }
        // send tax
        $tax_percent = $commission = $consulting_fee = $total_tax = $total_commission = $total_fees = 0;
        $tax = NULL;

        $userCommissions = UserCommissions::where('user_id', $appointment->doctor_id)->first();

        if ($request->consultation_type == 'INCLINIC') {

            $tax = TaxService::where('name', 'Doctor offline consultation')->first();
            $consulting_fee = $doctor->consulting_offline_fee;
            $commission = $userCommissions->in_clinic;
        } else if ($request->consultation_type == 'ONLINE') {

            $tax = TaxService::where('name', 'Doctor online consultation')->first();
            $consulting_fee = $doctor->consulting_online_fee;
            $commission = $userCommissions->online;
        } else if ($request->consultation_type == 'EMERGENCY') {

            $tax = TaxService::where('name', 'Doctor emergency consultation')->first();
            $consulting_fee = $doctor->emergency_fee;
            $commission = $userCommissions->emergency;
        }
        if ($tax) {
            $tax_percent = $tax->tax_percent;
        }

        $total_commission = ($consulting_fee * $commission) / 100;
        $total_tax = ($total_commission * $tax_percent) / 100;
        $total_fees = $consulting_fee + $total_tax;

        $record = Appointments::with('doctor')->with('clinic_address')->find($appointment->id);
        $record->makeHidden(['patient_details', 'patient_more_info', 'start_time', 'end_time',]);
        $record = $record->toArray();
        $record['tax_percent'] = $tax_percent;
        $record['commission'] = $commission;
        $record['type'] = "NEW_APPOINTMENT";
        $record['total_commission'] = round($total_commission, 2);
        $record['total_tax'] = round($total_tax, 2);
        $record['total_fees'] = round(($total_fees + $total_commission), 2);
        //for mobile Alert message
        $mobile_number = $record['doctor']['country_code'] . $record['doctor']['mobile_number'];
        // $message = "Appointment Confirmed Hai Dr". $record['doctor']['first_name']. ",New appointment confirmed for the following details. Patient Name:" .$record['current_patient_info']['user']['first_name'] ." ". $record['current_patient_info']['user']['last_name']. "Bookingid:". $record['appointment_unique_id'] ."type:". $record['consultation_type'] . "Date:" . $record['booking_date'] ." ". $record['time'] . "Place:" . $record['clinic_address']['clinic_name'] ." ". $record['clinic_address']['street_name'] ." ". $record['clinic_address']['city_village'] ." ". $record['clinic_address']['state'] . ".";
        $doctorname = $record['doctor']['first_name'];
        $message = "Appointment Confirmed Hai Dr". $doctorname . ".";

        $abc = $this->send($mobile_number, $message);
        $record['abc'] = $abc;
        //for Email Alert message
        Mail::to($record['doctor']['email'])->send(new AppointmentConfirmationToDoctor($record));
        //if payment not paid within 10 minutes delete this record
        AppointmentPaymentJob::dispatch($appointment)->delay(now()->addMinutes(11));
        return response()->json($record, 200);
    }
}
