<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Repositories\PatientRepository;
use App\Http\Responses\ErrorMessage;
use Carbon\Carbon;
use App\Http\Responses\SuccessMessage;
use App\Http\Services\PatientService;
use App\Http\Services\PaymentService;
use App\Jobs\SendEmailJob;
use App\Model\Address;
use App\Model\AdminSettings;
use App\Model\Appointments;
use App\Model\DoctorOffDays;
use App\Model\DoctorTimeSlots;
use App\Model\EmergencyContactdetails;
use App\Model\Followups;
use App\Model\PatientPersonalInfo;
use App\Model\PatientFamilyMembers;
use App\Model\PrescriptionMedList;
use App\Model\Prescriptions;
use App\Model\PrescriptionTestList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api;


class PatientController extends Controller
{
    public function __construct(PatientRepository $patient)
    {
        $this->patient = $patient;
    }
    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient edit profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam title string required
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam gender string required  any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth date required format -> Y-m-d
     * @bodyParam age float required
     * @bodyParam blood_group string nullable
     * @bodyParam height float nullable
     * @bodyParam weight float nullable
     * @bodyParam marital_status string nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
     * @bodyParam occupation string nullable
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string nullable required if alt_mobile_number is filled
     * @bodyParam email email required if edited verify using OTP
     * @bodyParam mobile_number string required if edited verify using OTP
     * @bodyParam country_code string required if mobile_number is edited
     * @bodyParam profile_photo file nullable File mime:jpg,jpeg,png size max 2mb
     * @bodyParam national_health_id string nullable
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "title": [
     *            "The title field is required."
     *        ],
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
     *        "blood_group": [
     *            "The blood group field is required."
     *        ],
     *        "height": [
     *            "The height field is required."
     *        ],
     *        "weight": [
     *            "The weight field is required."
     *        ],
     *        "marital_status": [
     *            "The marital status field is required."
     *        ],
     *        "occupation": [
     *            "The occupation field is required."
     *        ],
     *        "alt_mobile_number": [
     *            "The alt mobile number field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     */
    public function editProfile(PatientRequest $request)
    {
        return PatientService::editProfile($request, auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient add address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam contact_number string required
     * @bodyParam country_code string required
     * @bodyParam land_mark string required
     * @bodyParam address_type string required anyone of ['HOME', 'WORK', 'OTHERS']
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
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
     *        ],
     *        "address_type": [
     *            "The address type field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Address added successfully"
     *}
     */
    public function addAddress(PatientRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['created_by'] = auth()->user()->id;
        Address::create($data);
        return new SuccessMessage('Address added successfully');
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient list address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "address_type": "WORK",
     *            "street_name": "Middle",
     *            "city_village": "lane",
     *            "district": "london",
     *            "state": "state",
     *            "country": "india",
     *            "pincode": "627354",
     *            "country_code": "+91",
     *            "contact_number": "987654321"
     *        },
     *        {
     *            "id": 2,
     *            "address_type": "WORK",
     *            "street_name": "Middle",
     *            "city_village": "lane",
     *            "district": "london",
     *            "state": "state",
     *            "country": "india",
     *            "pincode": "627354",
     *            "country_code": "+91",
     *            "contact_number": "987654321"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/listaddress?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/listaddress?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/listaddress",
     *    "per_page": 20,
     *    "prev_page_url": null,
     *    "to": 2,
     *    "total": 2
     *}
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function listAddress()
    {
        $list = Address::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(20);
        $list->makeVisible('address_type');
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('No records found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient edit address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam pincode string required
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam address_type string required anyone of ['HOME', 'WORK', 'OTHERS']
     * @bodyParam contact_number string required
     * @bodyParam country_code string required
     * @bodyParam land_mark string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
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
     *        ],
     *        "address_type": [
     *            "The address type field is required."
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
    public function editAddress(PatientRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['updated_by'] = auth()->user()->id;
            Address::findOrFail($id)->update($data);
        } catch (\Exception $exception) {
            return new ErrorMessage('Address not found', 404);
        }
        return new SuccessMessage('Address updated successfully');
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient delete address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "message": "Address deleted successfully."
     *}
     *@response 404 {
     *    "message": "Address not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function deleteAddress($id)
    {
        try {
            Address::where('user_id', auth()->user()->id)->findOrFail($id)->destroy($id);
            return new SuccessMessage('Address deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Address not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get address by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "id": 1,
     *    "address_type": "WORK",
     *    "street_name": "Middle",
     *    "city_village": "lane",
     *    "district": "london",
     *    "state": "state",
     *    "country": "india",
     *    "pincode": "627001",
     *    "country_code": "+91",
     *    "contact_number": "987654321"
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
            $record = Address::where('user_id', auth()->user()->id)->findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Address not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient add BPL info and Emergency contact details.
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam current_medication string nullable
     * @bodyParam bpl_file_number string nullable
     * @bodyParam bpl_file file nullable if bpl_file_number is filled required File mime:pdf,jpg,jpeg,png size max 2mb
     * @bodyParam first_name_primary string required
     * @bodyParam middle_name_primary string nullable
     * @bodyParam last_name_primary string required
     * @bodyParam mobile_number_primary string required
     * @bodyParam country_code_primary string required
     * @bodyParam relationship_primary string required ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
     * @bodyParam first_name_secondary string nullable
     * @bodyParam middle_name_secondary string nullable
     * @bodyParam last_name_secondary string nullable
     * @bodyParam mobile_number_secondary string nullable
     * @bodyParam country_code_secondary string nullable if mobile_number_secondary is filled
     * @bodyParam relationship_secondary string nullable if filled, any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
     *
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "bpl_file": [
     *            "The bpl file field is required when bpl file number is present."
     *        ],
     *        "first_name_primary": [
     *            "The first name primary field is required."
     *        ],
     *        "middle_name_primary": [
     *            "The middle name primary field is required."
     *        ],
     *        "last_name_primary": [
     *            "The last name primary field is required."
     *        ],
     *        "mobile_number_primary": [
     *            "The mobile number primary field is required."
     *        ],
     *        "relationship_primary": [
     *            "The selected relationship primary is invalid."
     *        ]
     *    }
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */

    public function addEmergencyContact(PatientRequest $request)
    {
        return PatientService::addEmergencyContact($request, auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get BPL info and Emergency contact details.
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response {
     *    "first_name_primary": "THEO",
     *    "middle_name_primary": "BEN",
     *    "last_name_primary": "PHIL",
     *    "country_code_primary":"+91",
     *    "mobile_number_primary": "+914867857682",
     *    "relationship_primary": "SON",
     *    "first_name_secondary": "",
     *    "middle_name_secondary": "",
     *    "last_name_secondary": "",
     *    "country_code_secondary":"+91",
     *    "mobile_number_secondary": "",
     *    "relationship_secondary": "",
     *    "current_medication": "No",
     *    "bpl_file_number": "123456",
     *    "bpl_file": "HLD- FMS_V1.pdf"
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function getEmergencyContact()
    {
        return PatientService::getEmergencyContact(auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get BPL file to download
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response {
     *    "file":"file downloads directly"
     *}
     * @response 404 {
     *    "message": "File not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function getFile()
    {
        return PatientService::getFile(auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient add family member
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam title string required
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam gender string required  any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth date required format -> Y-m-d
     * @bodyParam age float required
     * @bodyParam height float nullable
     * @bodyParam weight float nullable
     * @bodyParam marital_status string nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
     * @bodyParam relationship string required  any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
     * @bodyParam occupation string nullable
     * @bodyParam current_medication string nullable
     * @bodyParam country_code string nullable
     * @bodyParam contact_number string nullable
     * @bodyParam national_health_id string nullable
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "title": [
     *            "The title field is required."
     *        ],
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
     *        "relationship": [
     *            "The selected relationship is invalid."
     *        ]
     *    }
     *}
     *@response 200 {
     *    "message": "Family member added successfully."
     *}
     *@response 404 {
     *    "message": "Patient not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     * @response 422 {
     *    "message": "Duplicate entry found."
     *}
     */

    public function addFamilyMember(PatientRequest $request)
    {
        $data = $request->validated();
        try {
            $relation = array('FATHER', 'MOTHER', 'HUSBAND', 'WIFE');
            if (in_array($data['relationship'], $relation)) {

                $record =  PatientFamilyMembers::where('user_id', auth()->user()->id)->where('relationship', $data['relationship'])->first();
                if ($record) {
                    throw new \Exception("Relationship " . strtolower($data['relationship']) . " already found.", 1);
                }
            }
        } catch (\Exception $exception) {
            return new ErrorMessage($exception->getMessage(), 404);
        }

        // check unique for name, relationship.
        $record = PatientFamilyMembers::where('user_id', auth()->user()->id)->where('relationship', $data['relationship'])->where('first_name', $data['first_name'])->where('middle_name', $data['middle_name'])->where('last_name', $data['last_name'])->first();

        if ($record) {
            return new ErrorMessage('Duplicate entry found.', 422);
        }

        $data['user_id'] = auth()->user()->id;
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
        // patient id for family member
        $data['patient_family_id'] = $this->patient->getPatientFamilyId();
        PatientFamilyMembers::create($data);
        return new SuccessMessage('Family member added successfully.');
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient list family member
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam paginate nullable integer nullable paginate = 0
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "patient_family_id": "P0000001F01",
     *            "title": "Mr",
     *            "first_name": "ben",
     *            "middle_name": "M",
     *            "last_name": "ten",
     *            "gender": "MALE",
     *            "date_of_birth": "1998-06-19",
     *            "age": 27,
     *            "height": 160,
     *            "weight": 90,
     *            "marital_status": "SINGLE",
     *            "occupation": "no work",
     *            "relationship": "SON",
     *            "country_code": null,
     *            "contact_number": null,
     *            "current_medication": "fever"
     *        },
     *        {
     *            "id": 2,
     *            "patient_family_id": "P0000001F12",
     *            "title": "Mr",
     *            "first_name": "ben",
     *            "middle_name": "M",
     *            "last_name": "ten",
     *            "gender": "MALE",
     *            "date_of_birth": "1998-06-19",
     *            "age": 27,
     *            "height": 160,
     *            "weight": 90,
     *            "marital_status": "SINGLE",
     *            "occupation": "no work",
     *            "relationship": "SON",
     *            "country_code": null,
     *            "contact_number": null,
     *            "current_medication": "fever"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/family?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/family?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/family",
     *    "per_page": 20,
     *    "prev_page_url": null,
     *    "to": 5,
     *    "total": 5
     *}
     * @response 404 {
     *    "message": "Family members not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function listFamilyMember(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);

        if ($request->filled('paginate')) {
            $list = PatientFamilyMembers::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        } else {
            $list = PatientFamilyMembers::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(PatientFamilyMembers::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('Family members not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient edit family member
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam title string required
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam gender string required  any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth date required format -> Y-m-d
     * @bodyParam age float required
     * @bodyParam height float nullable
     * @bodyParam weight float nullable
     * @bodyParam marital_status string nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
     * @bodyParam relationship string required  any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
     * @bodyParam occupation string nullable
     * @bodyParam current_medication string nullable
     * @bodyParam country_code string nullable
     * @bodyParam contact_number string nullable
     * @bodyParam national_health_id string nullable
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "title": [
     *            "The title field is required."
     *        ],
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
     *        "relationship": [
     *            "The selected relationship is invalid."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "Family member not found."
     *}
     * @response 200 {
     *    "message": "Family member updated successfully."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     * @response 422 {
     *    "message": "Duplicate entry found."
     *}
     */
    public function editFamilyMember(PatientRequest $request, $id)
    {
        $data = $request->validated();
        return PatientService::editFamilyMember($data, $id, auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient delete family member
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "message": "Family member deleted successfully"
     *}
     * @response 404 {
     *    "message": "Family member not found"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function deleteFamilyMember($id)
    {
        try {
            PatientFamilyMembers::where('user_id', auth()->user()->id)->findOrFail($id)->destroy($id);
            return new SuccessMessage('Family member deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Family member not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get family memeber by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "id": 1,
     *    "patient_family_id": "P0000001F01",
     *    "title": "Mr",
     *    "first_name": "ben",
     *    "middle_name": "M",
     *    "last_name": "ten",
     *    "gender": "MALE",
     *    "date_of_birth": "1998-06-19",
     *    "age": 27,
     *    "height": 160,
     *    "weight": 90,
     *    "marital_status": "SINGLE",
     *    "occupation": "no work",
     *    "relationship": "SON",
     *    "country_code": null,
     *    "contact_number": null,
     *    "current_medication": "fever"
     *}
     * @response 404 {
     *    "message": "Family member not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function getFamilyMemberById($id)
    {
        try {
            $record = PatientFamilyMembers::where('user_id', auth()->user()->id)->findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Family member not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "title": "mr",
     *    "gender": "MALE",
     *    "date_of_birth": "1998-06-19",
     *    "age": 27,
     *    "blood_group": "B+ve",
     *    "height": null,
     *    "weight": null,
     *    "marital_status": null,
     *    "occupation": null,
     *    "alt_mobile_number": null,
     *    "first_name": "theo",
     *    "middle_name": "ben",
     *    "last_name": "phil",
     *    "email": "theophilus@logidots.com",
     *    "alt_country_code":"+91",
     *    "alt_mobile_number":"8610025593",
     *    "mobile_number": "8610025593",
     *    "country_code":"+91",
     *    "username": "user12345",
     *    "national_health_id": "HEAT-9887"
     *}
     * @response 404 {
     *    "message": "Profile details not found"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function getProfile()
    {
        return PatientService::getProfile(auth()->user()->id);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient list Appointments
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array filter[upcoming]=1 for future appointments filter[completed]= 1 for completed appointments
     * @queryParam sortBy nullable any one of (date,id)
     * @queryParam orderBy nullable any one of (asc,desc)
     * @queryParam name nullable string name of doctor
     * @queryParam start_date nullable date format-> Y-m-d
     * @queryParam end_date nullable date format-> Y-m-d
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 369,
     *            "doctor_id": 2,
     *            "patient_id": 3,
     *            "appointment_unique_id": "AP0000369",
     *            "date": "2021-02-15",
     *            "time": "09:29:00",
     *            "consultation_type": "INCLINIC",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "booking_date": "2021-02-15",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Ben",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "profile_photo_url": null
     *                },
     *                "case": 2,
     *                "info": {
     *                    "first_name": "father",
     *                    "middle_name": null,
     *                    "last_name": "father",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": 9786200983,
     *                    "height": 0,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 29
     *                },
     *                "address": {
     *                    "id": 36,
     *                    "street_name": "Sreekariyam",
     *                    "city_village": "Trivandrum",
     *                    "district": "Alappuzha",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "688001",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "profile_photo_url": null
     *            },
     *            "clinic_address": {
     *                "id": 5,
     *                "street_name": "Lane",
     *                "city_village": "london",
     *                "district": "Pathanamthitta",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "689641",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": null,
     *                "longitude": null,
     *                "clinic_name": null
     *            },
     *            "prescription": {
     *                "id": 222,
     *                "appointment_id": 369,
     *                "unique_id": "PX0000222",
     *                "info": {
     *                    "age": 29,
     *                    "height": null,
     *                    "weight": null,
     *                    "address": "Sreekariyam, Trivandrum, Alappuzha, Kerala, India - 688001",
     *                    "symptoms": "xyz",
     *                    "body_temp": null,
     *                    "diagnosis": "xyz",
     *                    "pulse_rate": null,
     *                    "bp_systolic": null,
     *                    "test_search": null,
     *                    "bp_diastolic": null,
     *                    "case_summary": "This guy is an infection hub",
     *                    "medicine_search": null,
     *                    "note_to_patient": null,
     *                    "diet_instruction": null,
     *                    "despencing_details": null,
     *                    "investigation_followup": null
     *                },
     *                "created_at": "2021-02-15",
     *                "pdf_url": null,
     *                "status_medicine": "Yet to dispense.",
     *                "medicinelist": [
     *                    {
     *                        "id": 323,
     *                        "prescription_id": 222,
     *                        "medicine_id": 9,
     *                        "quote_generated": 1,
     *                        "dosage": "1 - 0 - 0 - 1",
     *                        "instructions": "xyz123",
     *                        "duration": "4 days",
     *                        "no_of_refill": "9",
     *                        "substitution_allowed": 0,
     *                        "medicine_status": "Dispensed at clinic.",
     *                        "medicine_name": "Calpol 650",
     *                        "medicine": {
     *                            "id": 9,
     *                            "category_id": 1,
     *                            "sku": "MED0000009",
     *                            "composition": "Paracetamol",
     *                            "weight": 650,
     *                            "weight_unit": "mg",
     *                            "name": "Calpol 650",
     *                            "manufacturer": "Raptakos Brett & Co",
     *                            "medicine_type": "Capsules",
     *                            "drug_type": "Branded",
     *                            "qty_per_strip": 10,
     *                            "price_per_strip": 50,
     *                            "rate_per_unit": 5,
     *                            "rx_required": 0,
     *                            "short_desc": "Symptoms of common cold and headache can also be controlled and treated through the use of this medicine",
     *                            "long_desc": null,
     *                            "cart_desc": "Treatment and control of fever",
     *                            "image_name": "lote.jpg",
     *                            "image_url": null
     *                        }
     *                    }
     *                ],
     *                "testlist": [
     *                    {
     *                        "id": 174,
     *                        "prescription_id": 222,
     *                        "lab_test_id": 4,
     *                        "quote_generated": 0,
     *                        "instructions": null,
     *                        "test_status": "To be dispensed.",
     *                        "test_name": "Comphrensive Metabolic panel",
     *                        "test": {
     *                            "id": 4,
     *                            "name": "Comphrensive Metabolic panel",
     *                            "unique_id": "LAT0000004",
     *                            "price": 300.5,
     *                            "currency_code": "INR",
     *                            "code": "CMP",
     *                            "image": null
     *                        }
     *                    }
     *                ]
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/appointments?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/appointments?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/appointments",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function listAppointments(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.upcoming' => 'nullable|boolean',
            'filter.completed' => 'nullable|boolean',
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
        var_dump(Appointments::where('patient_id', '356')->first());
        $record = Appointments::where('patient_id', auth()->user()->id)->with('doctor:id,first_name,middle_name,last_name,profile_photo')->with('clinic_address')->with('prescription')->where(function ($query) use ($filter, $request) {
            
            if (array_key_exists('upcoming', $filter) && $filter['upcoming'] == 1) {
                $query->where('date', '>=', Carbon::now()->format('Y-m-d'));
                //$query->where('is_completed', 0);
            }
            if (array_key_exists('completed', $filter) && $filter['completed'] == 1) {
                //$query->where('is_completed', 1);
                $query->where('date', '!=', Carbon::now()->format('Y-m-d'));
            }

            if ($request->filled('start_date')) {
                $query->whereBetween('date', [Carbon::parse($request->start_date . '00:00:00'), Carbon::parse($request->end_date . '23:59:59')]);
                //$query->whereBetween('date', [$request->from_date, $request->from_date]);
            }
        });
        dd($record->count());
        if ($request->filled('name')) {

            $record = $record->whereHas('doctor', function ($query) use ($validatedData) {
                //$query->where('first_name', 'like', '%' . $validatedData['name'] . '%');
                //$query->orWhere('middle_name', 'like', '%' . $validatedData['name'] . '%');
                //$query->orWhere('last_name', 'like', '%' . $validatedData['name'] . '%');
                $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like '%" . $validatedData['name'] . "%' ");
            });
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
     * @group Patient
     *
     * Patient list Appointments by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of appointment_id
     *
     * @response 200 {
     *    "id": 369,
     *    "doctor_id": 2,
     *    "patient_id": 3,
     *    "appointment_unique_id": "AP0000369",
     *    "date": "2021-02-15",
     *    "time": "09:29:00",
     *    "consultation_type": "INCLINIC",
     *    "shift": null,
     *    "payment_status": null,
     *    "transaction_id": null,
     *    "total": null,
     *    "is_cancelled": 0,
     *    "is_completed": 1,
     *    "followup_id": null,
     *    "booking_date": "2021-02-15",
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
     *        "case": 2,
     *        "info": {
     *            "first_name": "father",
     *            "middle_name": null,
     *            "last_name": "father",
     *            "email": "patient@logidots.com",
     *            "country_code": "+91",
     *            "mobile_number": 9786200983,
     *            "height": 0,
     *            "weight": 0,
     *            "gender": "MALE",
     *            "age": 29
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
     *        "profile_photo_url": null
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
     *        "id": 222,
     *        "appointment_id": 369,
     *        "unique_id": "PX0000222",
     *        "info": {
     *            "age": 29,
     *            "height": null,
     *            "weight": null,
     *            "address": "Sreekariyam, Trivandrum, Alappuzha, Kerala, India - 688001",
     *            "symptoms": "xyz",
     *            "body_temp": null,
     *            "diagnosis": "xyz",
     *            "pulse_rate": null,
     *            "bp_systolic": null,
     *            "test_search": null,
     *            "bp_diastolic": null,
     *            "case_summary": "This guy is an infection hub",
     *            "medicine_search": null,
     *            "note_to_patient": null,
     *            "diet_instruction": null,
     *            "despencing_details": null,
     *            "investigation_followup": null
     *        },
     *        "created_at": "2021-02-15",
     *        "pdf_url": null,
     *        "status_medicine": "Yet to dispense.",
     *        "medicinelist": [
     *            {
     *                "id": 323,
     *                "prescription_id": 222,
     *                "medicine_id": 9,
     *                "quote_generated": 1,
     *                "dosage": "1 - 0 - 0 - 1",
     *                "instructions": "xyz123",
     *                "duration": "4 days",
     *                "no_of_refill": "9",
     *                "substitution_allowed": 0,
     *                "medicine_status": "Dispensed at clinic.",
     *                "medicine_name": "Calpol 650",
     *                "medicine": {
     *                    "id": 9,
     *                    "category_id": 1,
     *                    "sku": "MED0000009",
     *                    "composition": "Paracetamol",
     *                    "weight": 650,
     *                    "weight_unit": "mg",
     *                    "name": "Calpol 650",
     *                    "manufacturer": "Raptakos Brett & Co",
     *                    "medicine_type": "Capsules",
     *                    "drug_type": "Branded",
     *                    "qty_per_strip": 10,
     *                    "price_per_strip": 50,
     *                    "rate_per_unit": 5,
     *                    "rx_required": 0,
     *                    "short_desc": "Symptoms of common cold and headache can also be controlled and treated through the use of this medicine",
     *                    "long_desc": null,
     *                    "cart_desc": "Treatment and control of fever",
     *                    "image_name": "lote.jpg",
     *                    "image_url": null
     *                }
     *            }
     *        ],
     *        "testlist": [
     *            {
     *                "id": 174,
     *                "prescription_id": 222,
     *                "lab_test_id": 4,
     *                "quote_generated": 0,
     *                "instructions": null,
     *                "test_status": "To be dispensed.",
     *                "test_name": "Comphrensive Metabolic panel",
     *                "test": {
     *                    "id": 4,
     *                    "name": "Comphrensive Metabolic panel",
     *                    "unique_id": "LAT0000004",
     *                    "price": 300.5,
     *                    "currency_code": "INR",
     *                    "code": "CMP",
     *                    "image": null
     *                }
     *            }
     *        ]
     *    }
     *}
     *
     * @response 404 {
     *    "message": "Appointment not found."
     *}
     */
    public function listAppointmentsById($id)
    {
        try {
            $record = Appointments::where('patient_id', auth()->user()->id)->with('doctor:id,first_name,middle_name,last_name,profile_photo')->with('clinic_address')->with('prescription')->findOrFail($id);
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
     * @group Patient
     *
     * Patient cancel appointment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of Appointment
     *
     * @response 200 {
     *    "message": "Appointment cancelled successfully."
     *}
     * @response 404 {
     *    "message": "Appointment not found."
     *}
     * @response 403 {
     *    "message": "Appointment can't be cancelled."
     *}
     */
    public function cancelAppointments($id)
    {
        try {
            $appointment = Appointments::where('patient_id', auth()->user()->id)->where('is_completed', 0)->where('is_cancelled', 0)->with('doctor')->with('doctorinfo')->with('payments')->findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Appointment can\'t be cancelled.', 403);
        }

        $date = $appointment->date;
        $time = $appointment->time;
        if (is_null($time)) {
            $time = '00:00:00';
        }
        $appointment_time = Carbon::parse(convertToUTC(($date . $time)));
        if (!is_null($appointment->cancel_time)) {

            if ($appointment_time->subHours($appointment->cancel_time)->gte(Carbon::now())) {

                $this->cancel_this_appointment($appointment);
                return new SuccessMessage('Appointment cancelled successfully.', 200);
            }
            return new ErrorMessage('Appointment can\'t be cancelled.', 403);
        } else {
            $option = AdminSettings::where('option', 'cancel_time_period')->first();

            if ($appointment_time->subHours($option->cancel_time_period)->gte(Carbon::now())) {

                $this->cancel_this_appointment($appointment);
                return new SuccessMessage('Appointment cancelled successfully.', 200);
            }
            return new ErrorMessage('Appointment can\'t be cancelled.', 403);
        }
    }

    public function cancel_this_appointment($appointment)
    {

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
        SendEmailJob::dispatch(['subject' => config('emailtext.appointment_cancel_subject'), 'user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name, 'email' => auth()->user()->email, 'mail_type' => 'otpverification', 'message' => $to_patient_text]);
        return;
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient reschedule appointment
     *
     * Authorization: "Bearer {access_token}"
     *
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

        // check if appointment is valid
        try {
            $appointment  = Appointments::where('patient_id', auth()->user()->id)->where('is_completed', 0)->with('doctor')->where('is_cancelled', 0)->with('doctorinfo')->findOrFail($data['appointment_id']);

            $old_date = Carbon::parse($appointment->date)->format('d M Y');
            if ($appointment->consultation_type == 'EMERGENCY') {
                $old_time = 'NA';
            } else {
                $old_time = Carbon::parse($appointment->time)->format('h:i A');
            }
        } catch (\Exception $exception) {
            return new ErrorMessage('Appointment can\'t be rescheduled.', 404);
        }

        $date = $appointment->date;
        $time = $appointment->time;
        if (is_null($time)) {
            $time = '00:00:00';
        }
        $appointment_time = Carbon::parse(convertToUTC(($date . $time)));

        if (!is_null($appointment->reschedule_time)) {
            if ($appointment_time->subHours($appointment->reschedule_time)->gte(Carbon::now())) {
            } else {
                return new ErrorMessage('Appointment can\'t be rescheduled.', 403);
            }
        } else {
            $option = AdminSettings::where('option', 'reschedule_time_period')->first();

            if ($appointment_time->subHours($option->reschedule_time_period)->gte(Carbon::now())) {
            } else {
                return new ErrorMessage('Appointment can\'t be rescheduled.', 403);
            }
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
        SendEmailJob::dispatch(['subject' => config('emailtext.appointment_reschedule_subject'), 'user_name' => 'Dr. ' . $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name, 'email' => $appointment->doctor->email, 'mail_type' => 'otpverification', 'message' => $to_doctor_text]);

        //send to patient
        SendEmailJob::dispatch(['subject' => config('emailtext.appointment_reschedule_subject'), 'user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name, 'email' => auth()->user()->email, 'mail_type' => 'otpverification', 'message' => $to_patient_text]);

        return new SuccessMessage('Appointment rescheduled successfully.', 200);
    }
    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient List followups
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam name nullable string name of patient
     * @queryParam start_date nullable date format-> Y-m-d
     * @queryParam end_date nullable date format-> Y-m-d
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "doctor_id": 2,
     *            "last_vist_date": "2020-12-23",
     *            "followup_date": "2020-12-31",
     *            "is_cancelled": 0,
     *            "is_completed": 0,
     *            "enable_followup": false,
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "profile_photo_url": null
     *            },
     *            "appointment": {
     *                "id": 1,
     *                "doctor_id": 2,
     *                "patient_id": 3,
     *                "appointment_unique_id": "AP0000001",
     *                "date": "2020-12-18",
     *                "time": "15:00:00",
     *                "consultation_type": "ONLINE",
     *                "shift": "MORNING",
     *                "payment_status": null,
     *                "transaction_id": null,
     *                "total": null,
     *                "is_cancelled": 0,
     *                "is_completed": 0,
     *                "patient_info": {
     *                    "id": "1",
     *                    "case": "1",
     *                    "email": "james@gmail.com",
     *                    "mobile": "876543210",
     *                    "last_name": "Bond",
     *                    "first_name": "James",
     *                    "middle_name": "007",
     *                    "mobile_code": "+91",
     *                    "patient_mobile": "987654321",
     *                    "patient_mobile_code": "+91"
     *                },
     *                "booking_date": "2020-12-24"
     *            },
     *            "clinic_address": {
     *                "id": 1,
     *                "street_name": "South Road",
     *                "city_village": "Edamattom",
     *                "district": "Kottayam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "686575",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "dach"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/followups?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/followups?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/patient/followups?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/followups",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listFollowups(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|required_with:start_date',

        ]);
        //->where('followup_date', '>=', now()->format('Y-m-d'))
        $list = Followups::where('patient_id', auth()->user()->id)->with('doctor:id,first_name,middle_name,last_name,profile_photo')->where('is_cancelled', 0)->where('is_completed', 0)->with('appointment')->whereHas('appointment', function ($query) {
            //$query->where('is_cancelled', 0)->where('is_completed', 1);
        })->with('clinic_address')->where('followup_date', '>=', Carbon::now()->format('Y-m-d'));;

        if ($request->filled('name')) {

            $list = $list->whereHas('doctor', function ($query) use ($validatedData) {
                //$query->orWhere('first_name', 'like', '%' . $validatedData['name'] . '%');
                //$query->orWhere('middle_name', 'like', '%' . $validatedData['name'] . '%');
                //$query->orWhere('last_name', 'like', '%' . $validatedData['name'] . '%');
                $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like '%" . $validatedData['name'] . "%' ");
            });
        }
        if ($request->filled('start_date')) {
            $list = $list->whereBetween('followup_date', [Carbon::parse($request->start_date . '00:00:00'), Carbon::parse($request->end_date . '23:59:59')]);
            //$query->whereBetween('date', [$request->from_date, $request->from_date]);
        }
        $list = $list->orderBy('id', 'desc')->paginate(Followups::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient cancel followup
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record followup
     *
     * @response 404 {
     *    "message": "Followup not found."
     *}
     * @response 200 {
     *    "message": "Followup cancelled successfully."
     *}
     */
    public function cancelFollowup($id)
    {
        try {
            $followup = Followups::with('appointment')->where('patient_id', auth()->user()->id)->where('id', $id)->where('is_cancelled', 0)->where('is_completed', 0)->firstOrFail();
        } catch (\Exception $e) {
            return new ErrorMessage("Followup not found.", 404);
        }
        $followup->is_cancelled = 1;
        $followup->save();

        $message = str_replace('$$$APPOINTMENT_ID$$$', $followup->appointment->appointment_unique_id, config('emailtext.followup_cancel_mail'));

        SendEmailJob::dispatch(['subject' => config('emailtext.followup_cancel_subject'), 'user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name, 'email' => auth()->user()->email, 'mail_type' => 'otpverification', 'message' => $message]);

        return new SuccessMessage('Followup cancelled successfully.');
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get followup timeslots THIS API WILL BE ABANDONED use this api https://api.doctor-app.alpha.logidots.com/docs/#get-doctor-available-time-slots
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record followup
     * @queryParam date required date format -> Y-m-d
     *
     * @response 200 {
     *    "MORNING": [
     *        {
     *            "id": 5,
     *            "day": "MONDAY",
     *            "slot_start": "09:30:00",
     *            "slot_end": "09:40:00",
     *            "type": "OFFLINE",
     *            "doctor_clinic_id": 1,
     *            "shift": "MORNING"
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Followup not found."
     *}
     * @response 200 {
     *    "message": "Time slots not found."
     *}
     */
    //TODO DELETE THIS
    public function getFollowupTimeslots($id, Request $request)
    {
        return 404;
        $validData = $request->validate([
            'date' => 'required|date_format:Y-m-d'
        ]);
        try {
            $followup = Followups::where('patient_id', auth()->user()->id)->where('id', $id)->where('is_cancelled', 0)->where('is_completed', 0)->firstOrFail();
        } catch (\Exception $e) {
            return new ErrorMessage("Followup not found.", 404);
        }
        $appointment = Appointments::where('id', $followup->appointment_id)->with('clinic_address')->first();

        $type = $appointment->consultation_type;
        if ($appointment->consultation_type != 'ONLINE') {
            $type = 'OFFLINE';
        }
        // get offdays ids
        $offdays = DoctorOffDays::where('user_id', $appointment->doctor_id)->where('date', $validData['date'])->get();
        $day = Carbon::parse($validData['date'])->format('l');
        $day = Str::upper($day);

        $ids = array();
        foreach ($offdays as $key => $offday) {
            $result = explode(',', $offday->time_slot_ids);
            $ids = array_unique(array_merge($ids, $result));
        }
        // check appointment table
        $appointments_slot = Appointments::where('doctor_id', $appointment->doctor_id)->where('is_cancelled', 0)->where('is_completed', 0)->where('date', $validData['date'])->pluck(
            'doctor_time_slots_id'
        );
        if ($appointments_slot->isNotEmpty()) {
            $ids = array_unique(array_merge($appointments_slot->toArray(), $ids));
        }
        //get time slots
        $ids = array_filter($ids);
        $list = DoctorTimeSlots::where('type', $type)->where('doctor_clinic_id', $appointment->address_id)->where('user_id', $appointment->doctor_id)->where(function ($query) use ($day, $ids, $validData) {
            if (!empty($ids)) {
                $query->whereNotIn('id', $ids);
            }
            $query->where('day', $day);
            // check timeslots for today
            if ($validData['date'] == now()->format('Y-m-d')) {
                $query->where('slot_start', '>=', now()->format('H:i:s'));
            }
        })->get();

        if ($list->count() > 0) {
            $grouped = $list->groupBy('shift');
            return response()->json($grouped, 200);
        }
        return new ErrorMessage('Time slots not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient list prescription
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 9,
     *            "appointment_id": 12,
     *            "unique_id": "PX0000009",
     *            "created_at": "2021-01-11",
     *            "pdf_url": null,
     *            "status_medicine": "Dispensed.",
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "email": "theophilus@logidots.com",
     *                "username": "theo",
     *                "country_code": "+91",
     *                "mobile_number": "8940330536",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "role": null,
     *                "currency_code": null,
     *                "approved_date": "2021-01-04",
     *                "laravel_through_key": 12,
     *                "profile_photo_url": null
     *            },
     *            "appointment": {
     *                "id": 12,
     *                "appointment_unique_id": "AP0000012",
     *                "booking_date": "2021-01-21",
     *                "current_patient_info": []
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/prescription?page=1",
     *    "from": 1,
     *    "last_page": 4,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/prescription?page=4",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/patient/prescription?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/prescription",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 4
     *}
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listPrescription()
    {
        $list = Prescriptions::orWhereHas('appointment', function ($query) {
            $query->where('patient_id', auth()->user()->id);
            $query->where('is_completed', 1);
        })->orWhere('user_id', auth()->user()->id)->with('doctor')->with('appointment')->orderBy('id', 'desc')->paginate(Prescriptions::$page);

        if ($list->count() > 0) {
            $list->makeHidden('info');
            $list->makeHidden('medicinelist');
            $list->makeHidden('testlist');
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient list prescription medicine list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record prescription
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "prescription_id": 1,
     *            "quote_generated": 0,
     *            "medicine_id": 1,
     *            "dosage": "2",
     *            "instructions": "Have food",
     *            "duration": "2 days",
     *            "no_of_refill": "2",
     *            "substitution_allowed": 1,
     *            "medicine_status": "Dispensed at associated pharmacy.",
     *            "medicine_name": "Dolo"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/prescription/medicine?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/prescription/medicine?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/prescription/medicine",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listMedicine(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id'
        ]);

        $list = PrescriptionMedList::where('prescription_id', $request->prescription_id)->orderBy('id', 'desc')->paginate(PrescriptionMedList::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient list prescription test list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record prescription
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "prescription_id": 1,
     *            "quote_generated": 0,
     *            "lab_test_id": 1,
     *            "instructions": "Need report on this test",
     *            "test_status": "Dispensed outside.",
     *            "test_name": "Test 2"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/prescription/test?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/prescription/test?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/prescription/test",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     *
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listTest(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id'
        ]);
        $list = PrescriptionTestList::where('prescription_id', $request->prescription_id)->orderBy('id', 'desc')->paginate(PrescriptionTestList::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
}
