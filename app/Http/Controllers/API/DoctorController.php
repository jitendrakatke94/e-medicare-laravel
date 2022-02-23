<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Http\Services\DoctorService;
use App\Http\Services\PaymentService;
use App\Jobs\SendEmailJob;
use App\Model\Address;
use App\Model\AdminSettings;
use App\Model\Appointments;
use App\Model\BankAccountDetails;
use App\Model\DoctorPersonalInfo;
use App\Model\DoctorClinicDetails;
use App\Model\DoctorOffDays;
use App\Model\DoctorTimeSlots;
use App\Model\Followups;
use App\Model\LaboratoryInfo;
use App\Model\PatientPersonalInfo;
use App\Model\Pharmacy;
use App\Model\Specializations;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorController extends Controller
{

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get profile
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     * @response 200 {
     *    "first_name": "Surgeon",
     *    "middle_name": "Heart",
     *    "last_name": "Heart surgery",
     *    "email": "theophilus@logidots.com",
     *    "country_code": "+91",
     *    "mobile_number": "+918940330536",
     *    "username": "theo",
     *    "gender": "MALE",
     *    "date_of_birth": "1993-06-19",
     *    "age": 4,
     *    "qualification": "BA",
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
     *    "years_of_experience": "5",
     *    "alt_country_code": "+91",
     *    "alt_mobile_number": null,
     *    "clinic_name": null,
     *    "pincode": "627354",
     *    "street_name": "street",
     *    "city_village": "vill",
     *    "district": "district",
     *    "state": "KL",
     *    "country": "India",
     *    "specialization_list": [
     *        {
     *            "id": 1,
     *            "name": "Orthopedician"
     *        },
     *        {
     *            "id": 2,
     *            "name": "Dermatologist"
     *        },
     *        {
     *            "id": 3,
     *            "name": "Pediatrician"
     *        },
     *        {
     *            "id": 4,
     *            "name": "General Physician"
     *        }
     *    ]
     *}
     *
     * @response 200 {
     *    "first_name": "theo",
     *    "middle_name": "theo",
     *    "last_name": "theo",
     *    "email": "theophilus@logidots.com",
     *    "country_code": "+91",
     *    "mobile_number": "+918940330536",
     *    "username": "user12345",
     *    "gender": "MALE",
     *    "date_of_birth": "1998-06-15",
     *    "age": 27,
     *    "qualification": "MD",
     *    "specialization": [],
     *    "years_of_experience": "5",
     *    "alt_country_code": "+91",
     *    "alt_mobile_number": null,
     *    "clinic_name": "GRACE",
     *    "pincode": "680001",
     *    "street_name": "street",
     *    "city_village": "VILLAGE",
     *    "district": "KL 15",
     *    "state": "KL",
     *    "country": "IN",
     *    "specialization_list":[]
     *}
     */
    public function getProfile()
    {
        return DoctorService::getProfile(auth()->user()->id);
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor edit profile
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam gender string required any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth string required format -> Y-m-d
     * @bodyParam age float required
     * @bodyParam qualification string required
     * @bodyParam specialization array required example specialization[0] = 1
     * @bodyParam years_of_experience string required
     * @bodyParam mobile_number string required if edited verify using OTP
     * @bodyParam country_code string required if mobile_number is edited
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string nullable required if alt_mobile_number is filled
     * @bodyParam email string required if edited verify using OTP
     * @bodyParam clinic_name string nullable
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required
     * @bodyParam city_village string required
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     *
     * @response {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "first_name": [
     *            "The first name field is required."
     *        ],
     *        "last_name": [
     *            "The last name field is required."
     *        ],
     *        "gender": [
     *            "The gender field is required."
     *        ],
     *        "date_of_birth": [
     *            "The date of birth field is required."
     *        ],
     *        "age": [
     *            "The age field is required."
     *        ],
     *        "qualification": [
     *            "The qualification field is required."
     *        ],
     *        "specialization": [
     *            "The specialization must be an array.."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "pincode": [
     *            "The pincode field is required."
     *        ],
     *        "street_name": [
     *            "The street name field is required."
     *        ],
     *        "city_village": [
     *            "The city village field is required."
     *        ],
     *        "district": [
     *            "The district field is required."
     *        ],
     *        "state": [
     *            "The state field is required."
     *        ],
     *        "country": [
     *            "The country field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function editProfile(DoctorRequest $request)
    {
        return DoctorService::editProfile($request, auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam clinic_name string required
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam contact_number string nullable
     * @bodyParam country_code string nullable required if contact_number is filled
     * @bodyParam pharmacy_list array nullable pharmacy_list[0]=1,pharmacy_list[1]=2
     * @bodyParam laboratory_list array nullable laboratory_list[0]=1,laboratory_list[1]=2
     * @bodyParam latitude double required
     * @bodyParam longitude double required
     *
     * @response 422{
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "clinic_name": [
     *            "The clinic name already exists."
     *        ],
     *        "pincode": [
     *            "The pincode must be 6 digits."
     *        ],
     *        "street_name": [
     *            "The street name field is required."
     *        ],
     *        "city_village": [
     *            "The city village field is required."
     *        ],
     *        "district": [
     *            "The district field is required."
     *        ],
     *        "state": [
     *            "The state field is required."
     *        ],
     *        "country": [
     *            "The country field is required."
     *        ],
     *        "pharmacy_list": [
     *            "The pharmacy list must be an array."
     *        ],
     *        "laboratory_list": [
     *            "The laboratory list must be an array."
     *        ],
     *        "latitude": [
     *            "The latitude format is invalid."
     *        ],
     *        "longitude": [
     *            "The longitude format is invalid."
     *        ]
     *    }
     *}
     *
     *@response 200 {
     *    "message": "Address added successfully"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function addAddress(DoctorRequest $request)
    {
        $validData = $request->validate([
            'clinic_name' => 'required',
        ]);

        $data = $request->validated();
        $data['clinic_name'] = $validData['clinic_name'];
        $data['user_id'] = auth()->user()->id;
        $data['created_by'] = auth()->user()->id;
        $data['address_type'] = 'CLINIC';

        $pharmacy_list = $laboratory_list = NULL;
        if ($request->filled('pharmacy_list')) {
            $pharmacy_list = $data['pharmacy_list'];
        }
        if ($request->filled('laboratory_list')) {
            $laboratory_list = $data['laboratory_list'];
        }

        $address = Address::create($data);
        unset($data['pharmacy_list']);
        unset($data['laboratory_list']);

        DoctorClinicDetails::updateOrCreate(
            ['address_id' => $address->id],
            [
                'address_id' => $address->id,
                'pharmacy_list' => $pharmacy_list,
                'laboratory_list' => $laboratory_list
            ]
        );
        return new SuccessMessage('Address added successfully');
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor edit address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @bodyParam clinic_name string required
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam contact_number string nullable
     * @bodyParam country_code string nullable required if contact_number is filled
     * @bodyParam pharmacy_list array nullable pharmacy_list[0]=1,pharmacy_list[1]=2
     * @bodyParam laboratory_list array nullable laboratory_list[0]=1,laboratory_list[1]=2
     * @bodyParam latitude double required
     * @bodyParam longitude double required
     *
     * @response 422{
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "pincode": [
     *            "The pincode must be 6 digits."
     *        ],
     *        "clinic_name": [
     *            "The clinic name already exists."
     *        ],
     *        "street_name": [
     *            "The street name field is required."
     *        ],
     *        "city_village": [
     *            "The city village field is required."
     *        ],
     *        "district": [
     *            "The district field is required."
     *        ],
     *        "state": [
     *            "The state field is required."
     *        ],
     *        "country": [
     *            "The country field is required."
     *        ],
     *        "pharmacy_list": [
     *            "The pharmacy list must be an array."
     *        ],
     *        "laboratory_list": [
     *            "The laboratory list must be an array."
     *        ],
     *        "latitude": [
     *            "The latitude format is invalid."
     *        ],
     *        "longitude": [
     *            "The longitude format is invalid."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Address updated successfully"
     *}
     * @response 404 {
     *    "message": "Address not found"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function editAddress(DoctorRequest $request, $id)
    {
        return DoctorService::editAddress($request, $id);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "address_type": "CLINIC",
     *            "street_name": "street name",
     *            "city_village": "garden",
     *            "district": "idukki",
     *            "state": "kerala",
     *            "country": "India",
     *            "pincode": "680002",
     *            "country_code": "+91",
     *            "contact_number": "9876543210",
     *            "latitude": "13.06743900",
     *            "longitude": "80.23761700",
     *            "clinic_name": "Grace",
     *            "clinic_info": {
     *                "address_id": 1,
     *                "id": 2,
     *                "pharmacy_list": [
     *                    "1",
     *                    "2",
     *                    "3"
     *                ],
     *                "laboratory_id_1": []
     *            }
     *        },
     *        {
     *            "id": 3,
     *            "address_type": "CLINIC",
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
     *            "clinic_name": "Grace",
     *            "clinic_info": {
     *                "address_id": 3,
     *                "id": 5,
     *                "pharmacy_list": [
     *                    "1",
     *                    "2",
     *                    "3"
     *                ],
     *                "laboratory_list": [
     *                    "1",
     *                    "2",
     *                    "3"
     *                ]
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/doctor/address?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/doctor/address?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/doctor/address",
     *    "per_page": 20,
     *    "prev_page_url": null,
     *    "to": 2,
     *    "total": 2
     *}
     *@response 404 {
     *    "message": "Address not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function listAddress()
    {
        $list = Address::where('user_id', auth()->user()->id)->where('address_type', 'CLINIC')->with('clinicInfo:address_id,id,pharmacy_list,laboratory_list')->orderBy('id', 'desc')->paginate(Address::$page);
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('Address not found', 404);
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get address by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "id": 2,
     *    "address_type": "CLINIC",
     *    "street_name": "address 2",
     *    "city_village": "garden",
     *    "district": "kollam",
     *    "state": "kerala",
     *    "country": "India",
     *    "pincode": "680002",
     *    "country_code": "+91",
     *    "contact_number": "9876543210",
     *    "latitude": "13.06743900",
     *    "longitude": "80.23761700",
     *    "clinic_name": "Grace",
     *    "clinic_info": {
     *        "address_id": 2,
     *        "pharmacy_list": [
     *                    "1",
     *                    "2",
     *                    "3"
     *                ],
     *                "laboratory_list": [
     *                    "1",
     *                    "2",
     *                    "3"
     *                ]
     *    }
     *}
     * @response 404 {
     *    "message": "Address not found"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function getAddressById($id)
    {
        try {
            $record = Address::where('user_id', auth()->user()->id)->with('clinicInfo:address_id,pharmacy_list,laboratory_list')->findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Address not found', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor delete address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "message": "Address deleted successfully"
     *}
     *@response 404 {
     *    "message": "Address not found"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function deleteAddress($id)
    {
        try {
            Address::where('user_id', auth()->user()->id)->findOrFail($id)->destroy($id);
            $clinicAddress = DoctorClinicDetails::where('address_id', $id)->first();
            if ($clinicAddress) {
                $clinicAddress->deleted_at = now();
                $clinicAddress->save();
            }
            return new SuccessMessage('Address deleted successfully');
        } catch (\Exception $exception) {
            return new ErrorMessage('Address not found', 404);
        }
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor check address has time slots
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of address
     *
     * @response 200 {
     *    "message": "Time slots found."
     *}
     * @response 404 {
     *    "message": "Time slots not found."
     *}
     * @response 404 {
     *    "message": "Address not found."
     *}
     */
    public function checkAddressHasTimeslots($id)
    {
        try {
            $address = Address::where('user_id', auth()->user()->id)->findOrFail($id);
            if ($address->timeslot()->exists()) {
                return new SuccessMessage('Time slots found.');
            }
            return new ErrorMessage('Time slots not found.', 404);
        } catch (\Exception $e) {
            return new ErrorMessage('Address not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor edit Additional Information
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam career_profile string required
     * @bodyParam education_training string required
     * @bodyParam clinical_focus string required
     * @bodyParam awards_achievements string nullable
     * @bodyParam memberships string nullable
     * @bodyParam experience string nullable
     * @bodyParam profile_photo image required required only if image is edited by user. image mime:jpg,jpeg,png size max 2mb
     * @bodyParam service string required anyone of ['INPATIENT', 'OUTPATIENT', 'BOTH']
     * @bodyParam appointment_type_online boolean nullable 0 or 1
     * @bodyParam appointment_type_offline boolean nullable 0 or 1
     * @bodyParam consulting_online_fee decimal The consulting online fee field is required when appointment type is 1.
     * @bodyParam consulting_offline_fee decimal The consulting offline fee field is required when appointment type is 1.
     * @bodyParam currency_code stirng required
     * @bodyParam emergency_fee double nullable
     * @bodyParam emergency_appointment integer
     * @bodyParam no_of_followup integer required values 1 to 10
     * @bodyParam followups_after integer required values 1 to 4
     * @bodyParam cancel_time_period integer nullable send 12 for 12 hours, 48 for 2 days
     * @bodyParam reschedule_time_period integer nullable send 12 for 12 hours, 48 for 2 days
     * @bodyParam payout_period boolean required 0 or 1
     * @bodyParam registration_number string required
     * @bodyParam time_intravel integer nullable max 59
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "career_profile": [
     *            "The career profile field is required."
     *        ],
     *        "education_training": [
     *            "The education training field is required."
     *        ],
     *        "service": [
     *            "The service field is required."
     *        ],
     *        "consulting_online_fee": [
     *            "The consulting online fee field is required when appointment type online is 1."
     *        ],
     *        "consulting_offline_fee": [
     *            "The consulting offline fee field is required when appointment type offline is 1."
     *        ],
     *        "no_of_followup": [
     *            "The number of followup field is required"
     *        ],
     *        "followups_after": [
     *            "The number of followup after field is required"
     *        ],
     *        "cancel_time_period": [
     *            "The cancel time period must be a number."
     *        ],
     *        "reschedule_time_period": [
     *            "The reschedule time period must be a number."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Profile details updated successfully"
     *}
     * @response 403 {
     *    "message": "Add Doctor profile details to continue."
     *}
     * @response 403 {
     *    "message": "Cancel Time Period is greater than Master Cancel Time Period."
     *}
     * @response 403 {
     *    "message": "Reschedule Time Period is greater than Master Reschedule Time Period."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function editAdditionalInformation(DoctorRequest $request)
    {
        return DoctorService::editAdditionalInformation($request, auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get Additional Information
     *
     * Authorization: "Bearer {access_token}"
     * @response 200 {
     *    "career_profile": "Surgeon",
     *    "education_training": "Heart",
     *    "clinical_focus": "Heart surgery",
     *    "awards_achievements": null,
     *    "memberships": null,
     *    "experience": "5",
     *    "doctor_profile_photo": "http://localhost/fms-api-laravel/public/storage/uploads/1/1597232166-66392b02-8113-4961-ad0a-4ceaca84da1b.jpeg",
     *    "service": "INPATIENT",
     *    "appointment_type": "OFFLINE",
     *    "currency_code": "INR",
     *    "consulting_online_fee": null,
     *    "consulting_offline_fee": 675,
     *    "emergency_fee": 345,
     *    "emergency_appointment":1,
     *    "no_of_followup": 3,
     *    "followups_after": 1,
     *    "cancel_time_period": 120,
     *    "reschedule_time_period": 48,
     *    "payout_period": 0
     *}
     * @response 200 {
     *    "career_profile": null,
     *    "education_training": null,
     *    "clinical_focus": null,
     *    "awards_achievements": null,
     *    "memberships": null,
     *    "experience": null,
     *    "doctor_profile_photo": null,
     *    "service": null,
     *    "appointment_type_online": null,
     *    "appointment_type_offline": null,
     *    "currency_code": null,
     *    "consulting_online_fee": null,
     *    "consulting_offline_fee": null,
     *    "emergency_fee": null,
     *    "emergency_appointment":null,
     *    "no_of_followup":null,
     *    "followups_after":null,
     *    "cancel_time_period":null,
     *    "reschedule_time_period":null,
     *    "payout_period": 0,
     *    "time_intravel": 10,
     *    "registration_number": null
     *}
     */
    public function getAdditionalInformation()
    {
        return DoctorService::getAdditionalInformation(auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor add bank details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam bank_account_number string required
     * @bodyParam bank_account_holder string required
     * @bodyParam bank_name string required
     * @bodyParam bank_city string required
     * @bodyParam bank_ifsc string required
     * @bodyParam bank_account_type string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "bank_account_number": [
     *            "The bank account number field is required."
     *        ],
     *        "bank_account_holder": [
     *            "The bank account holder field is required."
     *        ],
     *        "bank_name": [
     *            "The bank name field is required."
     *        ],
     *        "bank_city": [
     *            "The bank city field is required."
     *        ],
     *        "bank_ifsc": [
     *            "The bank ifsc field is required."
     *        ],
     *        "bank_account_type": [
     *            "The bank account type field is required."
     *        ]
     *    }
     *}
     * @response 200{
     *     "message": "Bank Account saved successfully."
     *}
     */
    public function addBankDetails(DoctorRequest $request)
    {

        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        BankAccountDetails::updateOrCreate(['user_id' => auth()->user()->id], $data);

        $data = DoctorPersonalInfo::with('addressFirst')->with('user')->where('user_id', auth()->user()->id)->first();
        if ($data) {
            if ($data->gender != '' && $data->career_profile != '' && !empty($data->addressFirst[0]) && is_null($data->user->approved)) {

                \DB::table('users')->where('id', auth()->user()->id)->update(['is_active' => '0']);
            }
        }

        return new SuccessMessage('Bank Account saved successfully.');
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get bank details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "id": 1,
     *    "bank_account_number": "BANK12345",
     *    "bank_account_holder": "BANKER",
     *    "bank_name": "BANK",
     *    "bank_city": "India",
     *    "bank_ifsc": "IFSC45098",
     *    "bank_account_type": "SAVINGS"
     *}
     * @response 404 {
     *     "message": "No records found."
     *}
     */
    public function getBankDetails()
    {

        try {
            $bank = BankAccountDetails::where('user_id', auth()->user()->id)->firstOrFail();
        } catch (\Exception $e) {
            return new ErrorMessage('No records found.', 404);
        }
        return response()->json($bank, 200);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list Appointments
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array filter[list]=0 for today list filter[list]=1 for future list filter[list]=2 for past list
     * @queryParam sortBy nullable any one of (date,id,time)
     * @queryParam orderBy nullable any one of (asc,desc)
     * @queryParam name nullable string name of patient
     * @queryParam start_date nullable date format-> Y-m-d
     * @queryParam end_date nullable date format-> Y-m-d
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 114,
     *            "doctor_id": 44,
     *            "patient_id": 3,
     *            "appointment_unique_id": "AP0000114",
     *            "date": "2021-01-27",
     *            "time": "18:00:00",
     *            "consultation_type": "ONLINE",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "is_cancelled": 0,
     *            "is_completed": 0,
     *            "followup_id": null,
     *            "booking_date": "2021-01-21",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210"
     *                },
     *                "case": 0,
     *                "info": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "height": 1,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 20
     *                },
     *                "address": {
     *                    "id": 77,
     *                    "street_name": "Villa",
     *                    "city_village": "street",
     *                    "district": "Pathanamthitta",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "689641",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "clinic_address": {
     *            "id": 5,
     *            "street_name": "Lane",
     *            "city_village": "london",
     *            "district": "Pathanamthitta",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "689641",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *            },
     *            "prescription": null
     *        },
     *        {
     *            "id": 113,
     *            "doctor_id": 44,
     *            "patient_id": 3,
     *            "appointment_unique_id": "AP0000113",
     *            "date": "2021-01-27",
     *            "time": "18:30:00",
     *            "consultation_type": "ONLINE",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "is_cancelled": 0,
     *            "is_completed": 0,
     *            "followup_id": null,
     *            "booking_date": "2021-01-21",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210"
     *                },
     *                "case": 2,
     *                "info": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "height": 1,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 20
     *                },
     *                "address": {
     *                    "id": 77,
     *                    "street_name": "Villa",
     *                    "city_village": "street",
     *                    "district": "Pathanamthitta",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "689641",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "clinic_address": {
     *            "id": 5,
     *            "street_name": "Lane",
     *            "city_village": "london",
     *            "district": "Pathanamthitta",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "689641",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *            },
     *            "prescription": null
     *        },
     *        {
     *            "id": 111,
     *            "doctor_id": 44,
     *            "patient_id": 3,
     *            "appointment_unique_id": "AP0000111",
     *            "date": "2021-01-25",
     *            "time": "13:16:00",
     *            "consultation_type": "INCLINIC",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "is_cancelled": 0,
     *            "is_completed": 0,
     *            "followup_id": null,
     *            "booking_date": "2021-01-21",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210"
     *                },
     *                "case": 1,
     *                "info": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "height": 1,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 20
     *                },
     *                "address": {
     *                    "id": 77,
     *                    "street_name": "Villa",
     *                    "city_village": "street",
     *                    "district": "Pathanamthitta",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "689641",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "clinic_address": {
     *            "id": 5,
     *            "street_name": "Lane",
     *            "city_village": "london",
     *            "district": "Pathanamthitta",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "689641",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *            },
     *            "prescription": {
     *                "id": 44,
     *                "appointment_id": 110,
     *                "unique_id": "PX0000044",
     *                "info": {
     *                    "age": "45",
     *                    "height": null,
     *                    "weight": null,
     *                    "address": null,
     *                    "symptoms": "some one else fever",
     *                    "body_temp": null,
     *                    "diagnosis": "some one else fever",
     *                    "pulse_rate": null,
     *                    "bp_systolic": null,
     *                    "test_search": null,
     *                    "bp_diastolic": null,
     *                    "case_summary": "some one else fever",
     *                    "medicine_search": null,
     *                    "note_to_patient": null,
     *                    "diet_instruction": null,
     *                    "despencing_details": null,
     *                    "investigation_followup": null
     *                },
     *                "created_at": "2021-01-21",
     *                "pdf_url": null,
     *                "status_medicine": "Dispensed.",
     *                "medicinelist": [
     *                    {
     *                        "id": 32,
     *                        "prescription_id": 44,
     *                        "medicine_id": 1,
     *                        "pharmacy_id": null,
     *                        "dosage": "1 - 0 - 0 - 0",
     *                        "instructions": "some one else fever",
     *                        "duration": "1 days",
     *                        "no_of_refill": "0",
     *                        "substitution_allowed": 0,
     *                        "medicine_status": "Dispensed at clinic.",
     *                        "medicine_name": "Ammu",
     *                        "medicine": {
     *                            "id": 1,
     *                            "category_id": 1,
     *                            "sku": "MED0000001",
     *                            "composition": "Paracetamol",
     *                            "weight": 50,
     *                            "weight_unit": "kg",
     *                            "name": "Ammu",
     *                            "manufacturer": "Ammu Corporation",
     *                            "medicine_type": "Capsules",
     *                            "drug_type": "Branded",
     *                            "qty_per_strip": 10,
     *                            "price_per_strip": 45,
     *                            "rate_per_unit": 4.5,
     *                            "rx_required": 0,
     *                            "short_desc": "This is a good product",
     *                            "long_desc": "This is a good product",
     *                            "cart_desc": "This is a good product",
     *                            "image_name": null,
     *                            "image_url": null
     *                        }
     *                    }
     *                ]
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/doctor/appointments?page=1",
     *    "from": 1,
     *    "last_page": 5,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/doctor/appointments?page=5",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/doctor/appointments?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/doctor/appointments",
     *    "per_page": 4,
     *    "prev_page_url": null,
     *    "to": 4,
     *    "total": 18
     *}
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "filter.list": [
     *            "The selected filter.list is invalid."
     *        ],
     *        "orderBy": [
     *            "The selected order by is invalid."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function listAppointments(Request $request)
    {
        //TODO VALIDATE
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.list' => 'nullable|in:0,1,2',
            'sortBy' => 'nullable|in:id,time,date',
            'orderBy' => 'nullable|in:asc,desc',
            'name' => 'nullable',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|required_with:start_date',
        ]);
        $filter = array();
        if (!empty($validatedData['filter'])) {
            $filter = $validatedData['filter'];
        }
        $sortBy = 'time'; //id
        $orderBy = 'asc';
        if ($request->filled('sortBy')) {
            $sortBy = $validatedData['sortBy'];
        }
        if ($request->filled('orderBy')) {
            $orderBy = $validatedData['orderBy'];
        }
        // filter[list]=0 today list filter[list]=1 future list filter[list]=2 past list
        $record = Appointments::where('doctor_id', auth()->user()->id)->with('prescription')->with('clinic_address')->where(function ($query) use ($filter, $request) {

            if (array_key_exists('list', $filter) && $filter['list'] == 0) {
                $query->where('date', Carbon::now()->format('Y-m-d'));
                //$query->where('is_cancelled', 0);
                // $query->where('is_completed', 0);
            }
            if (array_key_exists('list', $filter) && $filter['list'] == 1) {
                $query->where('date', '>', Carbon::now()->format('Y-m-d'));
            }
            if (array_key_exists('list', $filter) && $filter['list'] == 2) {
                $query->where('date', '!=', Carbon::now()->format('Y-m-d'));
            }
            if ($request->filled('name')) {
                $query->whereRaw('lower(patient_info->"$.first_name") LIKE ? ', ['%' . trim(strtolower($request->name)) . '%']);
                $query->orWhereRaw('lower(patient_info->"$.middle_name") LIKE ? ', ['%' . trim(strtolower($request->name)) . '%']);
                $query->orWhereRaw('lower(patient_info->"$.last_name") LIKE ? ', ['%' . trim(strtolower($request->name)) . '%']);
            }
        });

        if ($request->filled('start_date')) {
            $record = $record->whereBetween('date', [Carbon::parse($request->start_date . '00:00:00'), Carbon::parse($request->end_date . '23:59:59')]);
            //$query->whereBetween('date', [$request->from_date, $request->from_date]);
        }
        $record = $record->orderBy($sortBy, $orderBy)->paginate(Appointments::$page);

        if ($record->count() > 0) {
            $record->makeHidden(['patient_details', 'patient_more_info', 'start_time', 'end_time',]);

            return response()->json($record, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list Appointments by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of appointment_id
     *
     * @response 200 {
     *    "id": 14,
     *    "doctor_id": 2,
     *    "patient_id": 3,
     *    "appointment_unique_id": "AP0000014",
     *    "date": "2021-01-20",
     *    "time": "12:05:00",
     *    "consultation_type": "ONLINE",
     *    "shift": null,
     *    "payment_status": null,
     *    "transaction_id": null,
     *    "total": null,
     *    "is_cancelled": 0,
     *    "is_completed": 0,
     *    "followup_id": null,
     *    "booking_date": "2021-01-07",
     *    "current_patient_info": {
     *         "user": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210"
     *                },
     *        "case": 1,
     *        "info": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "height": 1,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 20
     *        },
     *        "address": {
     *            "id": 77,
     *            "street_name": "Villa",
     *            "city_village": "street",
     *            "district": "Pathanamthitta",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "689641",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *        }
     *    },
     *    "clinic_address": {
     *        "id": 5,
     *        "street_name": "Lane",
     *        "city_village": "london",
     *        "district": "Pathanamthitta",
     *        "state": "Kerala",
     *        "country": "India",
     *        "pincode": "689641",
     *        "country_code": null,
     *        "contact_number": null,
     *        "latitude": null,
     *        "longitude": null,
     *        "clinic_name": null
     *    },
     *    "prescription": {
     *        "id": 15,
     *        "appointment_id": 14,
     *        "unique_id": "PX0000015",
     *        "info": {
     *            "age": "98",
     *            "height": "150 cms",
     *            "weight": "70 Kg",
     *            "address": "23, Middle Lane, Kollam",
     *            "symptoms": "Fever",
     *            "body_temp": "98 C",
     *            "diagnosis": "Corono",
     *            "pulse_rate": null,
     *            "bp_systolic": "50",
     *            "bp_diastolic": "45",
     *            "case_summary": "Patient has corono",
     *            "note_to_Patient": "Drink plenty of water",
     *            "diet_instruction": "Take food on time",
     *            "despencing_details": "Despence all medicine",
     *            "investigation_followup": "f"
     *        },
     *        "created_at": "2021-01-12",
     *        "pdf_url": null,
     *        "status_medicine": "Dispensed.",
     *        "medicinelist": [
     *            {
     *                "id": 12,
     *                "prescription_id": 15,
     *                "medicine_id": 1,
     *                "quote_generated": 0,
     *                "dosage": "2",
     *                "instructions": "Have food",
     *                "duration": "2 days",
     *                "no_of_refill": "2",
     *                "substitution_allowed": 1,
     *                "medicine_status": "Dispensed at clinic.",
     *                "medicine_name": "Ammu",
     *                "medicine": {
     *                    "id": 1,
     *                    "category_id": 1,
     *                    "sku": "MED0000001",
     *                    "composition": "Paracetamol",
     *                    "weight": 50,
     *                    "weight_unit": "kg",
     *                    "name": "Ammu",
     *                    "manufacturer": "Ammu Corporation",
     *                    "medicine_type": "Capsules",
     *                    "drug_type": "Branded",
     *                    "qty_per_strip": 10,
     *                    "price_per_strip": 45,
     *                    "rate_per_unit": 4.5,
     *                    "rx_required": 0,
     *                    "short_desc": "This is a good product",
     *                    "long_desc": "This is a good product",
     *                    "cart_desc": "This is a good product",
     *                    "image_name": null,
     *                    "image_url": null
     *                }
     *            },
     *            {
     *                "id": 13,
     *                "prescription_id": 15,
     *                "medicine_id": 2,
     *                "quote_generated": 0,
     *                "dosage": "2",
     *                "instructions": "Have food",
     *                "duration": "2 days",
     *                "no_of_refill": "2",
     *                "substitution_allowed": 1,
     *                "medicine_status": "Dispensed at associated pharmacy.",
     *                "medicine_name": "test",
     *                "medicine": {
     *                    "id": 2,
     *                    "category_id": 1,
     *                    "sku": "MED0000002",
     *                    "composition": "water",
     *                    "weight": 12,
     *                    "weight_unit": "g",
     *                    "name": "test",
     *                    "manufacturer": "dndnd",
     *                    "medicine_type": "Capsules",
     *                    "drug_type": "Generic",
     *                    "qty_per_strip": 3,
     *                    "price_per_strip": 10,
     *                    "rate_per_unit": 12,
     *                    "rx_required": 0,
     *                    "short_desc": "good",
     *                    "long_desc": "null",
     *                    "cart_desc": "cart good",
     *                    "image_name": "medicine.png",
     *                    "image_url": null
     *                }
     *            }
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "Appointment not found."
     *}
     */
    public function listAppointmentsById($id)
    {
        try {
            $record = Appointments::where('doctor_id', auth()->user()->id)->with('prescription')->with('clinic_address')->findOrFail($id);
            $record->makeHidden([
                'patient_details', 'patient_more_info', 'start_time', 'end_time',
            ]);
        } catch (\Exception $exception) {
            return new ErrorMessage('Appointment not found.', 404);
        }
        return response()->json($record, 200);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get patient profile
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of patient
     *
     * @response 200 {
     *    "id": 1,
     *    "user_id": 3,
     *    "patient_unique_id": "P0000001",
     *    "title": "mr",
     *    "gender": "MALE",
     *    "date_of_birth": "1998-06-19",
     *    "age": 22,
     *    "blood_group": "B+ve",
     *    "height": null,
     *    "weight": null,
     *    "marital_status": null,
     *    "occupation": null,
     *    "alt_country_code": "+91",
     *    "alt_mobile_number": "5453",
     *    "current_medication": null,
     *    "bpl_file_number": null,
     *    "bpl_file_name": null,
     *    "first_name": "Ben",
     *    "middle_name": "john",
     *    "last_name": "phil",
     *    "email": "patient@logidots.com",
     *    "country_code": "+91",
     *    "mobile_number": "7591985089",
     *    "username": "patient",
     *    "patient_profile_photo": null,
     *    "address": [
     *        {
     *            "id": 75,
     *            "street_name": "Middle",
     *            "city_village": "lane",
     *            "district": "london",
     *            "state": "state",
     *            "country": "india",
     *            "pincode": "627354",
     *            "country_code": "+91",
     *            "contact_number": "0987654321",
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *        },
     *        {
     *            "id": 76,
     *            "street_name": "Middle",
     *            "city_village": "lane",
     *            "district": "london",
     *            "state": "state",
     *            "country": "india",
     *            "pincode": "627354",
     *            "country_code": "+91",
     *            "contact_number": "0987654321",
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     *
     */
    public function getPatientProfile($id)
    {
        try {
            $patient = PatientPersonalInfo::with('address')->where('user_id', $id)->firstOrFail();


            if ($patient) {
                $patient->toArray();
                $user = User::find($id);
                $patient['first_name'] = $user->first_name;
                $patient['middle_name'] = $user->middle_name;
                $patient['last_name'] = $user->last_name;
                $patient['email'] = $user->email;
                $patient['country_code'] = $user->country_code;
                $patient['mobile_number'] = $user->mobile_number;
                $patient['username'] = $user->username;
            }


            return response()->json($patient, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage("No records found.", 404);
        }
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor, Admin cancel appointment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of Appointment
     *
     * @response 200 {
     *    "message": "Appointment cancelled successfully."
     *}
     * @response 403 {
     *    "message": "Appointment can't be cancelled."
     *}
     */
    public function cancelAppointments($id)
    {
        try {
            $appointment = Appointments::with('patient_details')->where('doctor_id', auth()->user()->id)->with('doctor')->where('is_completed', 0)->where('is_cancelled', 0)->findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Appointment can\'t be cancelled.', 403);
        }
        //refund and mail notification

        $appointment->is_cancelled = 1;
        $appointment->payment_status = 'Cancelled';
        $appointment->cancelled_by = auth()->user()->id;

        $appointment->save();
        if (!is_null($appointment->payments)) {
            (new PaymentService)->refund($appointment, 'APPOINTMENT');
        }

        $date = Carbon::parse($appointment->date)->format('d M Y');
        $time = Carbon::parse($appointment->time)->format('h:i A');

        $message = str_replace('$$$APPOINTMENT_ID$$$', $appointment->appointment_unique_id, config('emailtext.appointment_cancel_mail'));
        $message = str_replace('$$$DATE$$$', $date, $message);
        $message = str_replace('$$$TIME$$$', $time, $message);
        $to_patient_text = $to_doctor_text = $message;

        $to_patient_text = str_replace('$$$NAME$$$', 'Dr. ' . $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name, $to_patient_text);

        $to_doctor_text = str_replace('$$$NAME$$$', 'Mr. ' . $appointment->current_patient_info['info']['first_name'] . ' ' . $appointment->current_patient_info['info']['last_name'], $to_doctor_text);

        //send to doctor
        SendEmailJob::dispatch(['subject' => config('emailtext.appointment_cancel_subject'), 'user_name' => 'Dr. ' . $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name, 'email' => $appointment->doctor->email, 'mail_type' => 'otpverification', 'message' => $to_doctor_text]);

        //send to patient
        SendEmailJob::dispatch(['subject' => config('emailtext.appointment_cancel_subject'), 'user_name' => $appointment->patient_details->first_name . ' ' . $appointment->patient_details->last_name, 'email' => $appointment->patient_details->email, 'mail_type' => 'otpverification', 'message' => $to_patient_text]);

        return new SuccessMessage('Appointment cancelled successfully.', 200);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor, Admin reschedule appointment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam appointment_id required integer id of Appointment
     * @bodyParam consultation_type string required anyone of INCLINIC,ONLINE,EMERGENCY
     * @bodyParam shift string nullable anyone of MORNING,AFTERNOON,EVENING,NIGHT required_if consultation_type is EMERGENCY
     * @bodyParam date required date format Y-m-d
     * @bodyParam doctor_time_slots_id required id of timeslot
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ],
     *        "date": [
     *            "The date field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Appointment rescheduled successfully."
     *}
     * @response 404 {
     *    "message": "Appointment not found."
     *}
     * @response 403 {
     *    "message": "Appointment can't be rescheduled."
     *}
     * @response 403 {
     *    "message": "Previous appointment consultation type is not equal to current input."
     *}
     */
    public function rescheduleAppointments(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id,deleted_at,NULL',
            'consultation_type' => 'required|in:INCLINIC,ONLINE,EMERGENCY',
            'date' => 'required|date_format:Y-m-d|after_or_equal:' . Carbon::now()->format('Y-m-d'),
            'shift' => 'nullable|in:MORNING,AFTERNOON,EVENING,NIGHT|required_if:consultation_type,EMERGENCY',
            'doctor_time_slots_id' => 'present|nullable|integer|exists:doctor_time_slots,id,deleted_at,NULL|required_if:consultation_type,INCLINIC,ONLINE',
        ]);

        try {
            $appointment  = Appointments::with('patient_details')->where('doctor_id', auth()->user()->id)->where('is_completed', 0)->where('is_cancelled', 0)->findOrFail($data['appointment_id']);
            $old_date = Carbon::parse($appointment->date)->format('d M Y');
            if ($appointment->consultation_type == 'EMERGENCY') {
                $old_time = 'NA';
            } else {
                $old_time = Carbon::parse($appointment->time)->format('h:i A');
            }
        } catch (\Exception $exception) {
            return new ErrorMessage('Appointment can\'t be rescheduled.', 404);
        }

        if ($appointment->consultation_type != $data['consultation_type']) {
            return new ErrorMessage('Previous appointment consultation type is not equal to current input.', 403);
        }
        $appointment->date = $data['date'];
        $appointment->reschedule_by = auth()->user()->id;
        if ($appointment->consultation_type == 'EMERGENCY') {
            $appointment->shift = $data['shift'];
            $appointment->save();
        } else {
            if ($appointment->date == now()->format('Y-m-d') && Carbon::now()->gte(Carbon::parse(convertToUTC($appointment->time, 'H:i:s')))) {
                return new ErrorMessage('Appointment can\'t be rescheduled.', 403);
            }
            $time_slot = DoctorTimeSlots::find($data['doctor_time_slots_id']);
            $appointment->doctor_time_slots_id = $time_slot->id;
            $appointment->time = $time_slot->slot_start;
            $appointment->start_time = $time_slot->slot_start;
            $appointment->end_time = $time_slot->slot_end;
            $appointment->save();
        }
        //mail notification
        $appointment->refresh();
        $new_date = Carbon::parse($appointment->date)->format('d M Y');

        if ($appointment->consultation_type != 'EMERGENCY') {
            $new_time = Carbon::parse($appointment->time)->format('h:i A');
        } else {
            $new_time = 'NA';
        }

        $message = str_replace('$$$APPOINTMENT_ID$$$', $appointment->appointment_unique_id, config('emailtext.appointment_reschedule_mail'));

        $message = str_replace('$$$OLDDATE$$$', $old_date, $message);
        $message = str_replace('$$$OLDTIME$$$', $old_time, $message);
        $message = str_replace('$$$NEWDATE$$$', $new_date, $message);
        $message = str_replace('$$$NEWTIME$$$', $new_time, $message);
        $to_patient_text = $to_doctor_text = $message;

        $to_patient_text = str_replace('$$$NAME$$$', 'Dr. ' . $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name, $to_patient_text);

        $to_doctor_text = str_replace('$$$NAME$$$', 'Mr. ' . $appointment->current_patient_info['info']['first_name'] . ' ' . $appointment->current_patient_info['info']['last_name'], $to_doctor_text);

        //send to doctor
        SendEmailJob::dispatch(['subject' => config('emailtext.appointment_reschedule_subject'), 'user_name' => 'Dr. ' . auth()->user()->first_name . ' ' . auth()->user()->last_name, 'email' => auth()->user()->email, 'mail_type' => 'otpverification', 'message' => $to_doctor_text]);

        //send to patient
        SendEmailJob::dispatch(['subject' => config('emailtext.appointment_reschedule_subject'), 'user_name' => $appointment->patient_details->first_name . ' ' . $appointment->patient_details->last_name, 'email' => $appointment->patient_details->email, 'mail_type' => 'otpverification', 'message' => $to_patient_text]);

        return new SuccessMessage('Appointment rescheduled successfully.', 200);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get associated Pharmacy
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam address_id required integer id of Address
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "pharmacy_name": "Pharmacy Name",
     *        "dl_file": null,
     *        "reg_certificate": null
     *    }
     *]
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     *
     */

    public function associatedPharmacy(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:doctor_clinic_details,address_id',
        ]);
        $list = DoctorClinicDetails::select('pharmacy_list')->where('address_id', $request->address_id)->first();
        if ($list) {
            $records = Pharmacy::whereHas('user', function ($query) {
                $query->where('is_active', '1');
            })->select('id', 'pharmacy_name')->whereIn('id', $list->pharmacy_list)->get();

            return response()->json($records, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor get associated Laboratory
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam address_id required integer id of Address
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "laboratory_name": "Laboratory Name",
     *        "lab_file": null
     *    }
     *]
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     *
     */
    public function associatedLaboratory(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:doctor_clinic_details,address_id',
        ]);
        $list = DoctorClinicDetails::select('laboratory_list')->where('address_id', $request->address_id)->first();
        if ($list) {
            $records = LaboratoryInfo::whereHas('user', function ($query) {
                $query->where('is_active', '1');
            })->select('id', 'laboratory_name')->whereIn('id', $list->laboratory_list)->get();

            return response()->json($records, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor list payouts
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam paid present integer 0 for unpaid , 1 for paid
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "paid": [
     *            "The paid field must be present."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "next_payout_period": "31 March 2021 11:59 PM",
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 3,
     *            "doctor_id": 2,
     *            "patient_id": 3,
     *            "appointment_unique_id": "AP0000003",
     *            "date": "2021-03-04",
     *            "time": "13:45:00",
     *            "consultation_type": "ONLINE",
     *            "shift": null,
     *            "payment_status": "Paid",
     *            "total": 606,
     *            "commission": 0,
     *            "tax": 0,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "booking_date": "2021-03-04",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Test",
     *                    "middle_name": "middle",
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "profile_photo_url": null
     *                },
     *                "case": 1,
     *                "info": {
     *                    "first_name": "Test",
     *                    "middle_name": "middle",
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "height": 0,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 0
     *                },
     *                "address": {
     *                    "id": 16,
     *                    "street_name": "vekam",
     *                    "city_village": "alappuzha",
     *                    "district": "Alappuzha",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "688004",
     *                    "country_code": null,
     *                    "contact_number": "8281837601",
     *                    "land_mark": "near statue",
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "payments": {
     *                "id": 3,
     *                "unique_id": "PAY0000003",
     *                "total_amount": 606,
     *                "payment_status": "Paid",
     *                "created_at": "2021-03-04 07:14:07 pm"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/doctor/payouts?page=1",
     *    "from": 1,
     *    "last_page": 29,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/doctor/payouts?page=29",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/doctor/payouts?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/doctor/payouts",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 29
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */

    public function listPayouts(Request $request)
    {
        $request->validate([
            'paid' => 'present|nullable|in:0,1',
        ]);

        $list = Appointments::where('doctor_id', auth()->user()->id)->with('payments')->whereHas('payments', function ($query) use ($request) {
            if ($request->filled('paid')) {
                if ($request->paid == 0) {
                    $query->where('payment_status', 'Not Paid');
                } else if ($request->paid == 0) {
                    $query->where('payment_status', 'Paid');
                }
            }
        })->orderBy('id', 'desc')->paginate(Appointments::$page);

        if ($list->count() > 0) {
            $list->makeHidden(['patient_details', 'patient_more_info', 'start_time', 'end_time']);
            $list->makeVisible('commission');

            // find next payout date
            $next_payout_period = NULL;
            if (auth()->user()->doctor->payout_period == 0) {
                $next_payout_period = Carbon::now()->endOfMonth()->format('d F Y h:i A');
            } else {
                $next_payout_period  = Carbon::now()->endOfWeek()->format('d F Y h:i A');
            }
            $return = collect(['next_payout_period' => $next_payout_period]);
            $data = $return->merge($list);
            return response()->json($data, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Doctor
     *
     * Doctor complete appointment by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam appointment_id required integer id of appointment
     * @bodyParam comment string comment present PNS,Completed
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ],
     *        "comment": [
     *            "The comment field must be present."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Appointment completed successfully."
     *}
     * @response 403 {
     *    "message": "Appointment has been already cancelled."
     *}
     *
     * @response 403 {
     *    "message": "Appointment has been already completed."
     *}
     */
    public function completeAppointment(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id,deleted_at,NULL,doctor_id,' . auth()->user()->id,
            'comment' => 'required|string|in:PNS,Completed',
            'pns_comment' => 'present|nullable'
        ]);

        $appointment = Appointments::with('doctor')->with('doctorinfo')->find($data['appointment_id']);

        if ($appointment->is_cancelled == 1) {
            return new ErrorMessage("Appointment has been already cancelled.", 403);
        } elseif ($appointment->is_completed == 1) {
            return new ErrorMessage("Appointment has been already completed.", 403);
        }

        //pns should be updated only after 2 hours of appointment
        if ($data['comment'] == 'PNS') {
            $date = $appointment->date;
            $time = $appointment->time;
            if (is_null($time)) {
                $time = '00:00:00';
            }
            $appointment_time = Carbon::parse(convertToUTC(($date . $time)))->addHours(2);

            if ($appointment_time->gte(carbon::now())) {

                return new ErrorMessage("PNS can be marked only after 2 hours of appointment time.", 403);
            }
            // send mail to patient
            $subject = 'emedicare: Patient didn’t show up for Appointment Id ' . $appointment->appointment_unique_id;
            $new_date = Carbon::parse($appointment->date)->format('d M Y');
            if ($appointment->consultation_type != 'EMERGENCY') {
                $new_time = Carbon::parse($appointment->time)->format('h:i A');
            } else {
                $new_time = 'NA';
            }

            $message = "You didn’t show up for Appointment " . $appointment->appointment_unique_id . " with Dr. " . auth()->user()->first_name . " " . auth()->user()->last_name . " booked for " . $new_date . " @ " . $new_time . " . Doctor has marked your appointment as Patient No Show (PNS). You are requested to provide your comment on your user dashboard on emedicare.in/emedicare app within 7 days of receipt of this email. After 7 days you will not be allowed to reply. In case of any doubt you can read our “Terms & Conditions” page and “Cancellation, Refund & Rescheduling” policy on our home page. You have already accepted these terms while booking the appointment.";

            SendEmailJob::dispatch(['subject' => $subject, 'user_name' => $appointment->patient_details->first_name . ' ' . $appointment->patient_details->last_name, 'email' => $appointment->patient_details->email, 'mail_type' => 'otpverification', 'message' => $message]);
        }
        $appointment->comment = $data['comment'];
        $appointment->pns_comment = $data['pns_comment'];
        $appointment->is_completed = 1;
        $appointment->save();

        // make followups for this appointments
        if (!is_null($appointment->doctorinfo->no_of_followup) && !is_null($appointment->doctorinfo->followups_after)) {

            // check if followup is present or else create new folloup
            if (is_null($appointment->followup_id)) {
                $this->createFollowup(1, $appointment, $appointment->id);
            } else {
                // follow up id is present
                $followups = Followups::withTrashed()->withCount('parent')->find($appointment->followup_id);

                $followups->makeVisible('parent_id');
                $count = $followups->parent_count;

                if ($count < $appointment->doctorinfo->no_of_followup) {
                    $this->createFollowup($count + 1, $appointment, $followups->parent_id);
                }
            }
        }

        return new SuccessMessage('Appointment completed successfully.');
    }

    public function createFollowup($i, $appointment, $parent_id)
    {
        Followups::firstOrCreate(
            [
                'appointment_id' => $appointment->id,
                'followup_date' => now()->addWeek($i * $appointment->doctorinfo->followups_after),
            ],
            [
                'appointment_id' => $appointment->id,
                'followup_date' => now()->addWeeks($i * $appointment->doctorinfo->followups_after),
                'doctor_id' => $appointment->doctor_id,
                'patient_id' => $appointment->patient_id,
                'clinic_id' => $appointment->address_id,
                'last_vist_date' => $appointment->date,
                'parent_id' => $parent_id,
            ]
        );
        Log::debug('Doctorcontroller createFollowup', ['appointment_id' => $appointment->id, 'parent_id' => $parent_id]);
        return;
    }
}
