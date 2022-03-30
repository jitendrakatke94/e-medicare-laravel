<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Model\Address;
use App\Model\Appointments;
use App\Model\DoctorOffDays;
use App\Model\DoctorPersonalInfo;
use App\Model\DoctorTimeSlots;
use App\Model\Reviews;
use App\Model\Specializations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Str;
use App\Model\Offers;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    /**
     * @group Search
     *
     * Search doctor list based on Address and Specialization
     *
     * filter[specialization] = 1
     * or filter[specialization] = 1,2,3
     * filter[gender] = 'FEMALE'
     * filter[consulting_fee_start] = 500
     * filter[consulting_fee_end] = 500
     * shift[0] = 'MORNING'
     * shift[1] = 'AFTERNOON'
     * shift[2] = 'EVENING'
     * shift[3] = 'NIGHT'
     *
     * @queryParam location required array location[street_name] = "Washington" or location[city_village] = "Washington" or location[state] = "Washington" or location[district] = "Washington" or location[country] = "Washington"
     * @queryParam filter nullable array filter[gender],filter[consulting_fee_start],filter[consulting_fee_end],filter[specialization]
     * @queryParam shift nullable array any of ['MORNING','AFTERNOON','EVENING','NIGHT']
     * @queryParam sortBy nullable any on of (consulting_online_fee,consulting_offline_fee,years_of_experience)
     * @queryParam orderBy nullable any one of (asc,desc)
     * @queryParam timezone required string format -> Asia/Kolkata
     * @queryParam latitude nullable string
     * @queryParam longitude nullable string
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "location": [
     *            "The location field is required."
     *        ],
     *        "filter": [
     *            "The filter must be an array."
     *        ],
     *        "shift": [
     *            "The shift must be an array."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "We couldn't find doctors for you"
     *}
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 7,
     *            "doctor_unique_id": "D0000007",
     *            "title": "Dr.",
     *            "gender": "FEMALE",
     *            "date_of_birth": "2020-09-10",
     *            "age": 3,
     *            "qualification": "quaerat",
     *            "years_of_experience": "5",
     *            "alt_country_code": "+91",
     *            "alt_mobile_number": "1-914-676-8725",
     *            "clinic_name": null,
     *            "career_profile": null,
     *            "education_training": null,
     *            "experience": null,
     *            "clinical_focus": null,
     *            "awards_achievements": null,
     *            "memberships": null,
     *            "doctor_profile_photo": null,
     *            "appointment_type_online": null,
     *            "appointment_type_offline": null,
     *            "consulting_online_fee": 681,
     *            "consulting_offline_fee": 107,
     *            "available_from_time": null,
     *            "available_to_time": null,
     *            "service": null,
     *            "reviews_count": 1,
     *            "average_rating": "4.3333",
     *            "doctor_profile_photo": "http://localhost/fms-api-laravel/public/storage/uploads/1/1601267114-f03757bd-2cbb-49d8-8415-d45174811aaf.jpeg",
     *            "user": {
     *                "id": 10,
     *                "first_name": "Rasheed Hettinger",
     *                "last_name": "Demario Senger Jr."
     *            },
     *            "address": [
     *                {
     *                    "id": 21,
     *                    "street_name": "East Road",
     *                    "city_village": "Air Village",
     *                    "district": "Kollam",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "601021",
     *                    "country_code": "+91",
     *                    "contact_number": null,
     *                    "latitude": "10.53034500",
     *                    "longitude": "76.21472900",
     *                    "clinic_name": "batz"
     *                }
     *            ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/doctor?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/doctor?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/guest/search/doctor",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     *
     */
    public function doctorList(Request $request)
    {
        $validatedData = $request->validate([
            'location' => 'present|array',
            'filter' => 'nullable|array',
            'filter.consulting_fee_start' => 'nullable|present',
            'filter.consulting_fee_end' => 'nullable|present',
            'shift' => 'nullable|array|in:MORNING,AFTERNOON,EVENING,NIGHT',
            'shift.*' => 'distinct',
            'sortBy' => 'nullable|string',
            'orderBy' => 'nullable|in:asc,desc',
            'timezone' => 'nullable|timezone',
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'], 'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'required_with:latitude'],
        ]);

        $location = $validatedData['location'];
        $filter = array();
        if (!empty($validatedData['filter'])) {
            $filter = $validatedData['filter'];
        }
        $shift = array();
        if (!empty($validatedData['shift'])) {
            $shift = $validatedData['shift'];
        }

        $sortBy = 'id';
        $orderBy = 'asc';
        if ($request->filled('sortBy')) {

            $sortBy = $validatedData['sortBy'];
        }
        if ($request->filled('orderBy')) {

            $orderBy = $validatedData['orderBy'];
        }
        $list = DoctorPersonalInfo::with('user:id,first_name,last_name')->whereHas('user', function ($query) {
            $query->where('is_active', '1');
        })->with(['address' => function ($query) use ($location) {

            if (array_key_exists('street_name', $location) && !empty($location['street_name'])) {
                $query->where('street_name', 'like', '%' . $location['street_name'] . '%');
            }
            if (array_key_exists('city_village', $location) && !empty($location['city_village'])) {
                $query->where('city_village', 'like', '%' . $location['city_village'] . '%');
            }
            if (array_key_exists('state', $location) && !empty($location['state'])) {
                $query->where('state', 'like', '%' . $location['state'] . '%');
            }
            if (array_key_exists('district', $location) && !empty($location['district'])) {
                $query->where('district', 'like', '%' . $location['district'] . '%');
            }
            if (array_key_exists('country', $location) && !empty($location['country'])) {
                $query->where('country', 'like', '%' . $location['country'] . '%');
            }
            $query->where('address_type', 'CLINIC');
        }])->whereHas('address', function (Builder $query) use ($location, $request) {

            if (array_key_exists('street_name', $location) && !empty($location['street_name'])) {
                $query->where('street_name', 'like', '%' . $location['street_name'] . '%');
            }
            if (array_key_exists('city_village', $location) && !empty($location['city_village'])) {
                $query->where('city_village', 'like', '%' . $location['city_village'] . '%');
            }
            if (array_key_exists('state', $location) && !empty($location['state'])) {
                $query->where('state', 'like', '%' . $location['state'] . '%');
            }
            if (array_key_exists('district', $location) && !empty($location['district'])) {
                $query->where('district', 'like', '%' . $location['district'] . '%');
            }
            if (array_key_exists('country', $location) && !empty($location['country'])) {
                $query->where('country', 'like', '%' . $location['country'] . '%');
            }
            $query->where('address_type', 'CLINIC');

            if ($request->filled('latitude')) {
                $query->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)) + sin( radians(?) ) * sin( radians( latitude ) ) )) AS distance", [$request->latitude, $request->longitude, $request->latitude])->having("distance", "<", 10);
            }
        })->whereHas('specialization', function (Builder $query) use ($filter) {
            if (array_key_exists('specialization', $filter) && !empty($filter['specialization'])) {
                $query->whereIn('specializations_id', [$filter['specialization']]);
            }
        })->where(function ($query) use ($filter) {

            if (array_key_exists('gender', $filter) && !empty($filter['gender'])) {
                $query->where('gender', $filter['gender']);
            }

            if (array_key_exists('years_of_experience', $filter) && !empty($filter['years_of_experience'])) {

                $query->where('years_of_experience', $filter['years_of_experience']);
            }

            if (!is_null($filter['consulting_fee_start']) && !is_null($filter['consulting_fee_end'])) {
                $query->where(function ($subquery) use ($filter) {
                    $subquery->whereBetween('consulting_online_fee', [$filter['consulting_fee_start'], $filter['consulting_fee_end']])
                        ->orWhereBetween('consulting_offline_fee', [$filter['consulting_fee_start'], $filter['consulting_fee_end']])
                        ->orWhereBetween('emergency_fee', [$filter['consulting_fee_start'], $filter['consulting_fee_end']]);
                });
            }
        });

        if (!empty($shift)) {
            $list = $list->whereHas('timeslot', function (Builder $query) use ($shift) {
                if (in_array('MORNING', $shift)) {
                    $query->where('shift', 'MORNING');
                }
                if (in_array('EVENING', $shift)) {
                    $query->where('shift', 'EVENING');
                }
                if (in_array('AFTERNOON', $shift)) {
                    $query->where('shift', 'AFTERNOON');
                }
                if (in_array('NIGHT', $shift)) {
                    $query->where('shift', 'NIGHT');
                }
            });
        }

        $list = $list->with('specialization')->withCount('reviews')->orderBy($sortBy, $orderBy)->paginate(DoctorPersonalInfo::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("We couldn't find doctors for you", 404);

        /*
        ->with(['specialization' => function ($query) use ($filter) {
            if (array_key_exists('specialization', $filter) && !empty($filter['specialization'])) {
                $query->whereIn('specializations_id', [$filter['specialization']]);
            }
        }])
        ->with(['timeslot' => function ($query) use ($shift) {
            if (in_array('MORNING', $shift)) {
                $query->where('shift', 'MORNING');
            }
            if (in_array('EVENING', $shift)) {
                $query->where('shift', 'EVENING');
            }
            if (in_array('AFTERNOON', $shift)) {
                $query->where('shift', 'AFTERNOON');
            }
            if (in_array('NIGHT', $shift)) {
                $query->where('shift', 'NIGHT');
            }
        }])
        */
    }

    /**
     * @group Search
     *
     * Get Specialization list based on search
     *
     * @queryParam specialization required string
     *
     * @response 200 [
     *    {
     *        "id": 4,
     *        "name": "General Physician"
     *    },
     *    {
     *        "id": 5,
     *        "name": "General Surgeon"
     *    }
     *]
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "specialization": [
     *            "The specialization field is required."
     *        ]
     *    }
     *}
     */
    public function getSpecializations(Request $request)
    {
        $validatedData = $request->validate([
            'specialization' => 'required',
        ]);
        $specialization = Specializations::where('name', 'like', '%' . $validatedData['specialization'] . '%')->get();

        if ($specialization->count() > 0) {
            return response()->json($specialization, 200);
        }
        $specialization = Specializations::all();
        return response()->json($specialization, 200);
    }

    /**
     * @group Search
     *
     * Get Address list based on search
     *
     * @queryParam location required array location[street_name] = "Washington" or location[city_village] = "Washington" or location[state] = "Washington" or location[district] = "Washington" or location[country] = "Washington"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 91,
     *            "address_type": "CLINIC",
     *            "street_name": "Boyle Radial",
     *            "city_village": "56152 Mallory Passage",
     *            "district": "Abbottside",
     *            "state": "Washington",
     *            "country": "Somalia",
     *            "pincode": "49690",
     *            "country_code": "+91",
     *            "contact_number": "803-327-3274",
     *            "latitude": "84.37410600",
     *            "longitude": "-26.71904700",
     *            "clinic_name": "batz"
     *        },
     *        {
     *            "id": 96,
     *            "address_type": "CLINIC",
     *            "street_name": "Schaden Light",
     *            "city_village": "72768 Lloyd Ridges",
     *            "district": "South Cassiemouth",
     *            "state": "Washington",
     *            "country": "Trinidad and Tobago",
     *            "pincode": "00966-2863",
     *            "country_code": "+91",
     *            "contact_number": "879-713-4248 x0178",
     *            "latitude": "68.83947400",
     *            "longitude": "-112.17728600",
     *            "clinic_name": "batz"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/address?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/address?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/guest/search/address",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 4,
     *    "total": 4
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "location": [
     *            "The location must be an array.."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "We couldn't find address for you"
     *}
     */
    public function getAddressList(Request $request)
    {
        $validatedData = $request->validate([
            'location' => 'required|array',
        ]);
        $location = $validatedData['location'];

        $list = Address::where(function ($subQuery) use ($location) {

            if (array_key_exists('street_name', $location) && !empty($location['street_name'])) {
                $subQuery->orWhere('street_name', 'like', '%' . $location['street_name'] . '%');
            }
            if (array_key_exists('city_village', $location) && !empty($location['city_village'])) {
                $subQuery->orWhere('city_village', 'like', '%' . $location['city_village'] . '%');
            }
            if (array_key_exists('state', $location) && !empty($location['state'])) {
                $subQuery->orWhere('state', 'like', '%' . $location['state'] . '%');
            }
            if (array_key_exists('district', $location) && !empty($location['district'])) {
                $subQuery->orWhere('district', 'like', '%' . $location['district'] . '%');
            }
            if (array_key_exists('country', $location) && !empty($location['country'])) {
                $subQuery->orWhere('country', 'like', '%' . $location['country'] . '%');
            }
        })->orderBy('id', 'desc')->paginate(Address::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("We couldn't find address for you", 404);
    }

    /**
     * @group Search
     *
     * Get Doctor details by id
     *
     * @queryParam id required integer id of doctor
     *
     * @response 200 {
     *    "id": 21,
     *    "doctor_unique_id": "D0000021",
     *    "title": "Dr.",
     *    "gender": "MALE",
     *    "date_of_birth": "1993-06-19",
     *    "age": 4,
     *    "qualification": "BA",
     *    "years_of_experience": 5,
     *    "alt_country_code": "+91",
     *    "alt_mobile_number": null,
     *    "clinic_name": "GRACE",
     *    "career_profile": "heart",
     *    "education_training": "heart",
     *    "experience": "5",
     *    "clinical_focus": null,
     *    "awards_achievements": null,
     *    "memberships": null,
     *    "doctor_profile_photo": null,
     *    "appointment_type_online": 1,
     *    "appointment_type_offline": 1,
     *    "consulting_online_fee": 400,
     *    "consulting_offline_fee": 500,
     *    "available_from_time": null,
     *    "available_to_time": null,
     *    "service": "INPATIENT",
     *    "address_count": 3,
     *    "reviews_count": 3,
     *    "average_rating": "4.3333",
     *    "doctor_profile_photo": "http://localhost/fms-api-laravel/public/storage/uploads/1/1601267114-f03757bd-2cbb-49d8-8415-d45174811aaf.jpeg",
     *    "user": {
     *        "id": 1,
     *        "first_name": "Surgeon",
     *        "middle_name": "Heart",
     *        "last_name": "Heart surgery"
     *    },
     *    "specialization": [
     *        {
     *            "id": 1,
     *            "name": "Orthopedician"
     *        },
     *        {
     *            "id": 3,
     *            "name": "Pediatrician"
     *        },
     *        {
     *            "id": 5,
     *            "name": "General Surgeon"
     *        }
     *    ],
     *    "address_first": [
     *        {
     *            "id": 202,
     *            "address_type": "CLINIC",
     *            "street_name": "address 2",
     *            "city_village": "garden",
     *            "district": "kollam",
     *            "state": "kerala",
     *            "country": "India",
     *            "pincode": "680002",
     *            "contact_number": "+919876543210",
     *            "latitude": "13.06743900",
     *            "longitude": "80.23761700",
     *            "clinic_name": "batz"
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Doctor not found"
     *}
     */
    public function getDoctorById($id)
    {
        $doctor = DoctorPersonalInfo::with('user:id,first_name,middle_name,last_name')->with('specialization')->withCount('address')->withCount('reviews')->with('addressFirst')->where('user_id', $id)->first();

        if ($doctor) {

            $doctor = $doctor->toArray();
            foreach ($doctor['specialization'] as $key => $value) {
                unset($doctor['specialization'][$key]['pivot']);
            }
            return response()->json($doctor, 200);
        }
        return new ErrorMessage('Doctor not found', 404);
    }

    /**
     * @group Search
     *
     * Get Doctor overview
     *
     * @queryParam id required integer id of doctor
     *
     * @response 200 {
     *    "career_profile": "heart",
     *    "experience": "5",
     *    "education_training": "heart",
     *    "awards_achievements": null,
     *    "service": "INPATIENT"
     *}
     * @response 200 {
     *    "career_profile": null,
     *    "experience": null,
     *    "education_training": null,
     *    "awards_achievements": null,
     *    "service": null
     *}
     */
    public function getDoctorOverview($id)
    {
        $data = array(
            'career_profile' => NULL,
            'experience' => NULL,
            'education_training' => NULL,
            'awards_achievements' => NULL,
            'service' => NULL,
            'qualification' => null
        );
        $doctor = DoctorPersonalInfo::where('user_id', $id)->first();
        if ($doctor) {
            $info = $doctor->toArray();
            $data = array(
                'career_profile' => $info['career_profile'],
                'experience' =>  $info['experience'],
                'education_training' =>  $info['education_training'],
                'awards_achievements' =>  $info['awards_achievements'],
                'service' =>  $info['service'],
                'qualification' => $info['qualification'],

            );
        }


        return response()->json($data, 200);
    }

    /**
     * @group Search
     *
     * Get Doctor Locations
     *
     * @queryParam id required integer id of doctor
     * @queryParam timezone required string format -> Asia/Kolkata
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 2,
     *            "street_name": "address 2",
     *            "city_village": "garden",
     *            "district": "kollam",
     *            "state": "kerala",
     *            "country": "India",
     *            "pincode": "680002",
     *            "country_code": "+91",
     *            "contact_number": "9876543210",
     *            "latitude": "13.06743900",
     *            "longitude": "80.23761700",
     *            "clinic_name": "batz",
     *            "timeslot": [
     *                {
     *                    "id": 4,
     *                    "day": "MONDAY",
     *                    "slot_start": "19:40:00",
     *                    "slot_end": "19:50:00",
     *                    "type": "ONLINE",
     *                    "doctor_clinic_id": 1,
     *                    "shift": "MORNING",
     *                    "laravel_through_key": 2
     *                }
     *            ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/location?page=1",
     *    "from": 1,
     *    "last_page": 5,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/location?page=5",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/location?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/location",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 5
     *}
     * @response 404 {
     *    "message": "Location not found"
     *}
     */
    public function getDoctorLocation($id, Request $request)
    {
        $validatedData = $request->validate([
            'timezone' => 'nullable|timezone',
        ]);

        $address = Address::where('user_id', $id)->where('address_type', 'CLINIC')->with(['timeslot' => function ($query) use ($id) {
            $query->where('user_id', $id);
        }])->orderBy('id', 'desc')->paginate(Address::$page);

        if ($address->count() > 0) {
            return response()->json($address, 200);
        }
        return new ErrorMessage('Location not found', 404);
    }

    /**
     * @group Search
     *
     * Get Doctor Reviews
     *
     * @queryParam id required integer id of doctor
     *
     * @response 200 {
     *    "average_rating": 4.33,
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 3,
     *            "rating": 7,
     *            "title": "very good doctor",
     *            "review": "wait and seee",
     *            "created_time": "Reviewed 19 minutes ago",
     *            "patient": {
     *                "id": 5,
     *                "first_name": "ammu",
     *                "middle_name": null,
     *                "last_name": "prasad",
     *                "profile_photo_url": null
     *            }
     *        },
     *        {
     *            "id": 2,
     *            "rating": 2,
     *            "title": "very good doctor",
     *            "review": "wait and seee",
     *            "created_time": "Reviewed 42 minutes ago",
     *            "patient": {
     *                "id": 4,
     *                "first_name": "Test",
     *                "middle_name": null,
     *                "last_name": "Patient",
     *                "profile_photo_url": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/doctor/2/review?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/guest/search/doctor/2/review?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/guest/search/doctor/2/review",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 3,
     *    "total": 3
     *}
     * @response 404 {
     *    "message": "Reviews not found."
     *}
     */
    public function getDoctorReviews($id)
    {
        $list = Reviews::with('patient:id,first_name,middle_name,last_name')->where('to_id', $id)->orderBy('updated_at', 'desc')->paginate(Reviews::$page);
        $list->makeHidden('patient_profile_photo');
        if ($list->count() > 0) {
            $rating = collect(['average_rating' => Reviews::averageRating($id)]);
            $list = $rating->merge($list);
            return response()->json($list, 200);
        }
        return new ErrorMessage('Reviews not found.', 404);
    }


    /**
     * @group Search
     *
     * Get Doctor Business Hours
     *
     * @queryParam id required integer id of doctor

     * @response 200 {
     *    "MORNING": [
     *        {
     *            "id": 1,
     *            "day": "THURSDAY",
     *            "slot_start": "19:30:00",
     *            "slot_end": "19:40:00",
     *            "type": "ONLINE",
     *            "doctor_clinic_id": 1,
     *            "shift": "MORNING",
     *            "address": {
     *                "id": 1,
     *                "street_name": "North Road",
     *                "city_village": "water Village",
     *                "district": "Thrissur",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "680001",
     *                "country_code": "+91",
     *                "contact_number": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "batz",
     *                "laravel_through_key": 1
     *            }
     *        }
     *    ],
     *    "NIGHT": [
     *        {
     *            "id": 3,
     *            "day": "MONDAY",
     *            "slot_start": "19:30:00",
     *            "slot_end": "19:40:00",
     *            "type": "ONLINE",
     *            "doctor_clinic_id": 1,
     *            "shift": "NIGHT",
     *            "address": {
     *                "id": 1,
     *                "street_name": "North Road",
     *                "city_village": "water Village",
     *                "district": "Thrissur",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "680001",
     *                "country_code": "+91",
     *                "contact_number": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "batz",
     *                "laravel_through_key": 1
     *            }
     *        }
     *    ],
     *    "EVENING": [
     *        {
     *            "id": 5,
     *            "day": "FRIDAY",
     *            "slot_start": "19:30:00",
     *            "slot_end": "19:40:00",
     *            "type": "OFFLINE",
     *            "doctor_clinic_id": 3,
     *            "shift": "EVENING",
     *            "address": {
     *                "id": 1,
     *                "street_name": "North Road",
     *                "city_village": "water Village",
     *                "district": "Thrissur",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "680001",
     *                "country_code": "+91",
     *                "contact_number": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "batz",
     *                "laravel_through_key": 1
     *            }
     *        }
     *    ]
     *}
     *
     * @response 404 {
     *    "message": "Time slots not found"
     *}
     */
    public function getDoctorBusinessHours($id)
    {
        $list = DoctorTimeSlots::with('address')->where('user_id', $id)->get();

        if ($list->count() > 0) {
            $grouped = $list->groupBy('shift');
            return response()->json($grouped, 200);
        }
        return new ErrorMessage('Time slots not found', 404);
    }

    /**
     * @group Search
     *
     * Get Doctor Available Time slots
     *
     * @queryParam id required integer id of doctor
     * @queryParam date required date format Y-m-d
     * @queryParam timezone required string format -> Asia/Kolkata
     * @queryParam clinic_address_id send clinic_address_id for followup appointments
     *
     * @response 200 {
     *    "MORNING": [
     *        {
     *            "id": 1,
     *            "day": "THURSDAY",
     *            "slot_start": "19:30:00",
     *            "slot_end": "19:40:00",
     *            "type": "ONLINE",
     *            "doctor_clinic_id": 1,
     *            "shift": "MORNING",
     *            "show_emergency": true,
     *            "address": {
     *                "id": 68,
     *                "street_name": "Test street",
     *                "city_village": "Test villa",
     *                "district": "Thiruvananthapuram",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "695001",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": "8.49730180",
     *                "longitude": "76.94846240",
     *                "clinic_name": "Back End Developer",
     *                "laravel_through_key": 27
     *            }
     *        }
     *    ],
     *    "NIGHT": [
     *        {
     *            "id": 3,
     *            "day": "MONDAY",
     *            "slot_start": "19:30:00",
     *            "slot_end": "19:40:00",
     *            "type": "ONLINE",
     *            "doctor_clinic_id": 1,
     *            "shift": "NIGHT",
     *            "show_emergency": false,
     *             "address": {
     *                "id": 68,
     *                "street_name": "Test street",
     *                "city_village": "Test villa",
     *                "district": "Thiruvananthapuram",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "695001",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": "8.49730180",
     *                "longitude": "76.94846240",
     *                "clinic_name": "Back End Developer",
     *                "laravel_through_key": 27
     *            }
     *        }
     *    ],
     *    "EVENING": [
     *        {
     *            "id": 5,
     *            "day": "FRIDAY",
     *            "slot_start": "19:30:00",
     *            "slot_end": "19:40:00",
     *            "type": "OFFLINE",
     *            "doctor_clinic_id": 3,
     *            "shift": "EVENING",
     *            "show_emergency": false,
     *            "address": {
     *                "id": 68,
     *                "street_name": "Test street",
     *                "city_village": "Test villa",
     *                "district": "Thiruvananthapuram",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "695001",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": "8.49730180",
     *                "longitude": "76.94846240",
     *                "clinic_name": "Back End Developer",
     *                "laravel_through_key": 27
     *            }
     *        }
     *    ]
     *}
     *
     * @response 404 {
     *    "message": "Time slots not found."
     *}
     */
    public function getDoctorAvailableTimeslots($id, Request $request)
    {

        $validData = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'timezone' => 'nullable|timezone'
        ]);
        // get offdays ids
        $offdays = DoctorOffDays::where('user_id', $id)->where('date', $validData['date'])->get();
        $day = Carbon::parse($validData['date'])->format('l');
        $day = Str::upper($day);

        $ids = array();
        foreach ($offdays as $key => $offday) {
            $result = explode(',', $offday->time_slot_ids);
            $ids = array_unique(array_merge($ids, $result));
        }

        // check appointment table
        $appointments = Appointments::where('doctor_id', $id)->where('is_cancelled', 0)->whereDate('date', $validData['date'])->get();

        foreach ($appointments as $key => $appointment) {
            $appointment_offdays = DoctorTimeSlots::where('user_id', $id)->where('day', $day)->where('slot_start', convertToUTC($appointment->start_time))->pluck('id');
            if ($appointment_offdays->isNotEmpty()) {
                $ids = array_unique(array_merge($appointment_offdays->toArray(), $ids));
            }
        }
        //get time slots
        $ids = array_filter($ids);
        $list = DoctorTimeSlots::where('user_id', $id)->where(function ($query) use ($day, $ids, $validData) {
            if (!empty($ids)) {
                $query->whereNotIn('id', $ids);
            }
            $query->where('day', $day);
            // check timeslots for today
            if ($validData['date'] == now()->format('Y-m-d')) {
                $query->where('slot_start', '>=', now()->format('H:i:s'));
            }
        })->with('address')->whereHas('address', function ($query) use ($request) {
            if ($request->filled('clinic_address_id')) {
                $query->where('addresses.id', $request->clinic_address_id);
            }
            $query->where('address_type', 'CLINIC');
        })->orderBy('slot_start', 'asc')->get();

        if ($list->count() > 0) {
            $doctor = DoctorPersonalInfo::where('user_id', $id)->first();
            foreach ($list as $key => $list_object) {
                $status = false;
                if ($list_object->type == 'OFFLINE') {
                    if (!is_null($doctor->emergency_fee)) {
                        $appointments = Appointments::where('date', $validData['date'])->where('doctor_id', $id)->where('shift', $list_object->shift)->where('is_cancelled', 0)->get();

                        if ($appointments->count() + 1 > $doctor->emergency_appointment) {
                            $status = false;
                        } else {
                            $status = true;
                        }
                    } else {
                        $status = false;
                    }
                } else {
                    $status = false;
                }
                $return = collect(['show_emergency' => $status]);
                $list[$key] = $return->merge($list_object);
            }
            $grouped = $list->groupBy('shift');
            return response()->json($grouped, 200);
        }
        return new ErrorMessage('Time slots not found.', 404);
    }


    public function doctorSearch(Request $request)
    {
        $validatedData = $request->validate([
            'country' => 'required',
            'state' => 'required',
            'district' => 'required',
            'keyword' => 'required'
        ]);

        $sortBy = 'id';
        $orderBy = 'asc';
        $list = DoctorPersonalInfo::with('user:id,first_name,last_name')->whereHas('user', function ($query) use($validatedData) {
            $query->where(['is_active'=>'1'])->where('first_name', 'like', '%' . $validatedData['keyword'] . '%')->orWhere('last_name', 'like', '%' . $validatedData['keyword'] . '%');
        })->whereHas('address', function ($query) use ($validatedData) {
            $query->where('state' ,$validatedData['state'])->where('district' ,$validatedData['district'])->where('country' ,$validatedData['country'])->where('address_type', 'CLINIC');
        })->orWhereHas('specialization', function (Builder $query) use ($validatedData) {
                $query->where('name', 'like', '%' . $validatedData['keyword'] . '%');
        });

        $list = $list->with(['specialization', 'address'])->withCount('reviews')->orderBy($sortBy, $orderBy)->paginate(DoctorPersonalInfo::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("We couldn't find doctors for you", 404);
    }

    public function topDoctorsAndOffersList() {
        $data = array(
            'top_doctors' =>[],
            'recently_visited_doctors'=>[],
            'offers_for_you'=>[]
        );
        $doctors = DoctorPersonalInfo::with('user')->limit(5)->get();
        
        $recently_visited_doctors = Appointments::with(['doctor', 'patient_details', 'timeslot', 'clinic_address'])
                                    ->where('date', '>=', Carbon::now()->subDays(4)->format('Y-m-d'))->where('is_cancelled', 0)->get();
        
        $offers = Offers::where('created_date', '<=', Carbon::now()->format('Y-m-d'))->where('expiry_date', '>=', Carbon::now()->format('Y-m-d'))->get();
        
        $data['top_doctors'] =$doctors;
        $data['recently_visited_doctors'] = $recently_visited_doctors;
        $data['offers_for_you'] = $offers;
            
        return response()->json($data, 200);
    }

    public function getTopLocations(Request $request)
    {
        $data = array(
            'data' =>[]
        );
        $addressList = Address::select('*')->havingRaw('COUNT(state) > 5')->groupBy('state')->limit(5)->get();

        if ($addressList->count() > 0) {
            $data['data'] = $addressList;
            return response()->json($data, 200);
        }
    }

}
