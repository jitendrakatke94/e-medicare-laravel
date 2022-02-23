<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEditRequest;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\PatientRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Http\Services\DoctorService;
use App\Http\Services\PatientService;
use App\Model\Address;
use App\Model\AdminSettings;
use App\Model\BankAccountDetails;
use App\Model\DoctorClinicDetails;
use App\Model\DoctorPersonalInfo;
use App\Model\LaboratoryInfo;
use App\Model\PatientFamilyMembers;
use App\Model\PatientPersonalInfo;
use App\Model\Pharmacy;
use App\Model\Specializations;
use App\User;
use Carbon\Carbon;
use Str;

class EditController extends Controller
{
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit laboratory basicinfo
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam laboratory_name string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam email string required
     * @bodyParam gstin string required
     * @bodyParam lab_reg_number string required
     * @bodyParam lab_issuing_authority string required
     * @bodyParam lab_date_of_issue date required format:Y-m-d
     * @bodyParam lab_valid_upto date required format:Y-m-d
     * @bodyParam lab_file image nullable mime:jpg,jpeg,png size max 2mb

     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "id": [
     *            "The id field is required."
     *        ],
     *        "laboratory_name": [
     *            "The laboratory name field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "gstin": [
     *            "GSTIN (Goods and Services Tax Identification Number) is required."
     *        ],
     *        "lab_reg_number": [
     *            "Laboratory Registraton number is required."
     *        ],
     *        "lab_issuing_authority": [
     *            "Laboratory Registraton Issuing Authority is required."
     *        ],
     *        "lab_date_of_issue": [
     *            "Laboratory Registraton date of issue is required."
     *        ],
     *        "lab_valid_upto": [
     *            "Laboratory Registraton valid upto is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "id": 1,
     *    "sample_collection": 1,
     *    "order_amount": "4.00",
     *    "currency_code": "INR",
     *    "address": {
     *        "id": 73,
     *        "street_name": "street",
     *        "city_village": "village",
     *        "district": "district",
     *        "state": "state",
     *        "country": "country",
     *        "pincode": "678555",
     *        "country_code": "+91",
     *        "contact_number": null,
     *        "latitude": "8.74122200",
     *        "longitude": "77.69462600",
     *        "clinic_name": null
     *    }
     *}
     * @response 404 {
     *    "message": "Laboratory not found"
     *}
     */
    public function laboratoryBasicInfo($id, AdminEditRequest $request)
    {

        try {
            $record = LaboratoryInfo::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Laboratory not found', 404);
        }

        /*
        // Admin no need to edit email and mobile number
        $userData['email'] = $request->email;
        $userData['country_code'] = $request->country_code;
        $userData['mobile_number'] = $request->mobile_number;
        User::find($record->user_id)->update($userData);
        */
        if ($request->file('lab_file')) {
            $fileExtension = $request->lab_file->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/' . $record->user_id;
            $filePath = $request->file('lab_file')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $record->lab_file_path = $filePath;
        }

        $record->laboratory_name = $request->laboratory_name;
        $record->alt_mobile_number = $request->alt_mobile_number;
        $record->alt_country_code = $request->alt_country_code;
        $record->gstin = $request->gstin;
        $record->lab_reg_number = $request->lab_reg_number;
        $record->lab_issuing_authority = $request->lab_issuing_authority;
        $record->lab_date_of_issue = $request->lab_date_of_issue;
        $record->lab_valid_upto = $request->lab_valid_upto;
        $record->save();

        $address = Address::where('address_type', 'LABORATORY')->where('user_id', $record->user_id)->first();
        // return data for next step
        $user = User::find($record->user_id);
        $result = array('id' => $record->id, 'sample_collection' => $record->sample_collection, 'order_amount' => $record->order_amount, 'currency_code' => $user->currency_code, 'address' => $address);
        return response()->json($result, 200);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit laboratory address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam sample_collection boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if home_delivery is filled
     * @bodyParam currency_code string required
     * @bodyParam latitude double required
     * @bodyParam longitude double required
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
     *        "sample_collection": [
     *            "Sample collection from home field is required."
     *        ],
     *        "order_amount": [
     *            "Order amount is required when Sample collection from home field is yes."
     *        ],
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ]
     *    }
     *}
     *@response 200 {
     *    "id":1,
     *    "row": [
     *        {
     *            "id": 1,
     *            "sample_collect": 1
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Laboratory not found"
     *}
     */
    public function laboratoryAddress($id, AdminEditRequest $request)
    {
        try {
            $record = LaboratoryInfo::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Laboratory not found', 404);
        }
        $record->sample_collection = $request->sample_collection;
        $record->order_amount = $request->order_amount;
        $record->save();

        $data = $request->validated();
        User::where('id', $record->user_id)->update(['currency_code' => $data['currency_code']]);

        unset($data['sample_collection']);
        unset($data['order_amount']);
        unset($data['currency_code']);
        Address::where('address_type', 'LABORATORY')->where('user_id', $record->user_id)->update($data);

        $result = array('id' => $record->id, 'row' => $record->lab_tests);
        return response()->json($result, 200);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit laboratory test list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam row array nullable
     * @bodyParam row[0][id] integer required id of LaboratoryTestList
     * @bodyParam row[0][sample_collect] boolean required 1 0r 0
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "data_id": [
     *            "The data id field is required."
     *        ],
     *        "row.0.id": [
     *            "The row.0.id field is required."
     *        ],
     *        "row.1.id": [
     *            "The row.1.id field is required."
     *        ],
     *        "row.0.sample_collect": [
     *            "The row.0.sample_collect field is required."
     *        ],
     *        "row.1.sample_collect": [
     *            "The row.1.sample_collect field is required."
     *        ]
     *    }
     *}
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
     *    "message": "Laboratory not found"
     *}
     */
    public function laboratoryAddTestList($id, AdminEditRequest $request)
    {
        try {
            $record = LaboratoryInfo::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Laboratory not found', 404);
        }

        if ($request->filled('row')) {
            $record->lab_tests = $request->row;
            $record->save();
        }

        $bank = BankAccountDetails::where('user_id', $record->user_id)->first();
        //sending bank account number
        return response()->json($bank, 200);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit laboratory bank details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id integer required id of bank record from previous response
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
     * @response 404{
     *     "message": "Bank Account Details not found"
     *}
     * @response 200{
     *     "message": "Bank Account Details updated successfully"
     *}
     */
    public function laboratoryAddBankDetails($id, AdminEditRequest $request)
    {
        try {
            $record = BankAccountDetails::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Bank Account Details not found', 404);
        }
        $data = $request->validated();
        $record->update($data);
        return new SuccessMessage('Bank Account Details updated successfully');
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit pharmacy basicinfo
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam pharmacy_name string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam gstin string required
     * @bodyParam dl_number string required
     * @bodyParam dl_issuing_authority string required
     * @bodyParam dl_date_of_issue date required format:Y-m-d
     * @bodyParam dl_valid_upto date required format:Y-m-d
     * @bodyParam dl_file image nullable mime:jpg,jpeg,png size max 2mb

     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "pharmacy_name": [
     *            "The pharmacy name field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ],
     *        "gstin": [
     *            "GSTIN (Goods and Services Tax Identification Number) is required."
     *        ],
     *        "dl_number": [
     *            "Drug licence number is required."
     *        ],
     *        "dl_issuing_authority": [
     *            "Drug licence Issuing Authority is required."
     *        ],
     *        "dl_date_of_issue": [
     *            "Drug licence date of issue is required."
     *        ],
     *        "dl_valid_upto": [
     *            "Drug licence valid upto is required."
     *        ],
     *        "dl_file": [
     *            "Drug licence image file is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "id": 1,
     *    "home_delivery": 1,
     *    "order_amount": "4.00",
     *    "currency_code": "INR",
     *    "address": {
     *        "id": 73,
     *        "street_name": "street",
     *        "city_village": "village",
     *        "district": "district",
     *        "state": "state",
     *        "country": "country",
     *        "pincode": "678555",
     *        "country_code": "+91",
     *        "contact_number": null,
     *        "latitude": "8.74122200",
     *        "longitude": "77.69462600",
     *        "clinic_name": null
     *    }
     *}
     * @response 404 {
     *    "message": "Pharmacy not found"
     *}
     */
    public function pharmacyBasicInfo($id, AdminEditRequest $request)
    {
        try {
            $record = Pharmacy::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Pharmacy not found', 404);
        }

        /*
        // Admin no need to edit email and mobile number
        $userData['email'] = $request->email;
        $userData['country_code'] = $request->country_code;
        $userData['mobile_number'] = $request->mobile_number;
        User::find($record->user_id)->update($userData);
        */
        if ($request->file('dl_file')) {
            $fileExtension = $request->dl_file->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/' . $record->user_id;
            $filePath = $request->file('dl_file')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $record->dl_file_path = $filePath;
        }

        $record->pharmacy_name = $request->pharmacy_name;
        $record->gstin = $request->gstin;
        $record->dl_number = $request->dl_number;
        $record->dl_issuing_authority = $request->dl_issuing_authority;
        $record->dl_date_of_issue = $request->dl_date_of_issue;
        $record->dl_valid_upto = $request->dl_valid_upto;
        $record->save();

        $address = Address::where('address_type', 'PHARMACY')->where('user_id', $record->user_id)->first();
        $user = User::find($record->user_id);
        // return data for next step
        $result = array('id' => $record->id, 'home_delivery' => $record->home_delivery, 'order_amount' => $record->order_amount, 'currency_code' => $user->currency_code, 'address' => $address);
        return response()->json($result, 200);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit pharmacy address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam home_delivery boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if home_delivery is filled
     * @bodyParam currency_code string required
     * @bodyParam latitude double required
     * @bodyParam longitude double required
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
     *        "home_delivery": [
     *            "The home delivery field is required."
     *        ],
     *        "order_amount": [
     *            "The order amount is required when Home delivery field is yes."
     *        ],
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "Pharmacy not found"
     *}
     * @response 200 {
     *    "id": 1,
     *    "pharmacy_details": {
     *        "pharmacist_name": "Hermann Bayer Jr.",
     *        "course": "Bsc",
     *        "pharmacist_reg_number": "PHAR1234",
     *        "issuing_authority": "GOVT",
     *        "alt_mobile_number": null,
     *        "alt_country_code": null,
     *        "reg_certificate": "http://localhost/fms-api-laravel/public/storage",
     *        "reg_date": "2020-10-15",
     *        "reg_valid_upto": "2030-10-15"
     *    },
     *    "bank_details": {
     *        "id": 2,
     *        "bank_account_number": "BANK12345",
     *        "bank_account_holder": "BANKER",
     *        "bank_name": "BANK",
     *        "bank_city": "India",
     *        "bank_ifsc": "IFSC45098",
     *        "bank_account_type": "SAVINGS"
     *    }
     *}
     */
    public function pharmacyAddress($id, AdminEditRequest $request)
    {
        try {
            $record = Pharmacy::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Pharmacy not found', 404);
        }

        $record->home_delivery = $request->home_delivery;
        $record->order_amount = $request->order_amount;
        $record->save();

        $data = $request->validated();
        User::where('id', $record->user_id)->update(['currency_code' => $data['currency_code']]);
        unset($data['home_delivery']);
        unset($data['order_amount']);
        unset($data['currency_code']);
        Address::where('address_type', 'PHARMACY')->where('user_id', $record->user_id)->update($data);

        $bank = BankAccountDetails::where('user_id', $record->user_id)->first();

        $details['pharmacist_name'] = $record->pharmacist_name;
        $details['course'] = $record->course;
        $details['pharmacist_reg_number'] = $record->pharmacist_reg_number;
        $details['issuing_authority'] = $record->issuing_authority;
        $details['alt_mobile_number'] = $record->alt_mobile_number;
        $details['alt_country_code'] = $record->alt_country_code;
        $details['reg_certificate'] = $record->reg_certificate;
        $details['reg_date'] = $record->reg_date;
        $details['reg_valid_upto'] = $record->reg_valid_upto;

        $result = array('id' => $record->id, 'pharmacy_details' => $details, 'bank_details' => $bank);
        return response()->json($result, 200);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit pharmacy Additional details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam pharmacist_name string required
     * @bodyParam course string required
     * @bodyParam pharmacist_reg_number string required
     * @bodyParam issuing_authority string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam reg_certificate string required
     * @bodyParam reg_date string required
     * @bodyParam reg_valid_upto string required
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
     *        "pharmacist_name": [
     *            "The pharmacist name field is required."
     *        ],
     *        "course": [
     *            "The course field is required."
     *        ],
     *        "pharmacist_reg_number": [
     *            "Pharmacist Registration Number is required."
     *        ],
     *        "issuing_authority": [
     *            "The issuing authority field is required."
     *        ],
     *        "alt_country_code": [
     *            "The alt country code field is required when alt mobile number is present."
     *        ],
     *        "reg_certificate": [
     *            "The reg certificate field is required."
     *        ],
     *        "reg_date": [
     *            "The reg date field is required."
     *        ],
     *        "reg_valid_upto": [
     *            "The reg valid upto field is required."
     *        ],
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
     * @response 404 {
     *    "message": "Pharmacy not found"
     *}
     * @response 200 {
     *    "message": "Pharmacy additional details saved successfully."
     *}
     */
    public function pharmacyAdditionaldetails($id, AdminEditRequest $request)
    {
        try {
            $record = Pharmacy::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Pharmacy not found', 404);
        }
        $data = $request->validated();
        User::find($record->user_id)->update(['last_name' => $data['pharmacist_name']]);
        $record->pharmacist_name = $data['pharmacist_name'];
        $record->alt_mobile_number = $data['alt_mobile_number'];
        $record->alt_country_code = $data['alt_country_code'];
        $record->course = $data['course'];
        $record->issuing_authority = $data['issuing_authority'];
        $record->pharmacist_reg_number = $data['pharmacist_reg_number'];
        $record->reg_date = $data['reg_date'];
        $record->reg_valid_upto = $data['reg_valid_upto'];
        $reg_certificate_path = $record->reg_certificate_path;
        if ($request->file('reg_certificate')) {
            $fileExtension = $request->reg_certificate->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/' . $record->user_id;
            $filePath = $request->file('reg_certificate')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $reg_certificate_path = $filePath;
        }
        $record->reg_certificate_path = $reg_certificate_path;
        $record->save();

        $bank_details['bank_account_number'] = $data['bank_account_number'];
        $bank_details['bank_account_holder'] = $data['bank_account_holder'];
        $bank_details['bank_name'] = $data['bank_name'];
        $bank_details['bank_city'] = $data['bank_city'];
        $bank_details['bank_ifsc'] = $data['bank_ifsc'];
        $bank_details['bank_account_type'] = $data['bank_account_type'];

        BankAccountDetails::where('user_id', $record->user_id)->update($bank_details);
        return new SuccessMessage('Pharmacy additional details saved successfully.');
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin get Doctor get profile
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of doctor
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
    public function getDoctorProfile($id)
    {
        return DoctorService::getProfile($id);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit Doctor profile
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of doctor
     *
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam gender string required
     * @bodyParam date_of_birth string required
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
     * @response 404 {
     *    "message": "Doctor not found."
     *}
     */
    public function editProfile($id, DoctorRequest $request)
    {
        try {
            User::where('user_type', 'DOCTOR')->findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Doctor not found.', 404);
        }
        return DoctorService::editProfile($request, $id);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin list doctor address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of doctor
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
     *    "message": "No records found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     * @response 404 {
     *    "message": "Doctor not found.."
     *}
     */
    public function listDoctorAddress($id)
    {
        try {
            User::where('user_type', 'DOCTOR')->findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Doctor not found.', 404);
        }


        $list = Address::where('user_id', $id)->where('address_type', 'CLINIC')->with('clinicInfo:address_id,id,pharmacy_list,laboratory_list')->orderBy('id', 'desc')->paginate(Address::$page);
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('No records found.', 404);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit doctor address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of address
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
     *    "message": "Address updated successfully."
     *}
     * @response 404 {
     *    "message": "Address not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function editDoctorAddress(DoctorRequest $request, $id)
    {
        return DoctorService::editAddress($request, $id);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin get Doctor Additional Information
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of doctor in user object
     *
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
     *    "consulting_online_fee": null,
     *    "consulting_offline_fee": 675,
     *    "emergency_fee": 345,
     *    "emergency_appointment":1,
     *    "no_of_followup": 3,
     *    "followups_after": 1,
     *    "cancel_time_period": 120,
     *    "reschedule_time_period": 48,
     *    "payout_period": 1,
     *    "registration_number": "REG-DEN-6894",
     *    "comment": "test comments",
     *    "currency_code": "USD"
     *}
     * @response 404 {
     *    "message": "Doctor additional information not found."
     *}
     */
    public function getAdditionalInformation($id)
    {

        try {
            $data = DoctorPersonalInfo::where('user_id', $id)->firstOrFail();
        } catch (\Exception $e) {
            return new ErrorMessage('Doctor additional information not found.', 404);
        }
        return DoctorService::getAdditionalInformation($id);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit Doctor Additional Information
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of doctor in user object
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
     * @bodyParam emergency_fee double nullable
     * @bodyParam emergency_appointment integer
     * @bodyParam no_of_followup integer required values 1 to 10
     * @bodyParam followups_after integer required values 1 to 4
     * @bodyParam cancel_time_period integer nullable send 12 for 12 hours, 48 for 2 days
     * @bodyParam reschedule_time_period integer nullable send 12 for 12 hours, 48 for 2 days
     * @bodyParam currency_code stirng required
     * @bodyParam payout_period boolean required 0 or 1
     * @bodyParam registration_number string required
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
     *    "message": "Details updated successfully."
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
     * @response 404 {
     *    "message": "Doctor additional information not found."
     *}
     */
    public function editAdditionalInformation($id, DoctorRequest $request)
    {
        return DoctorService::editAdditionalInformation($request, $id);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin get Doctor bank details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of doctor in user object
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
     *     "message": "Doctor bank details not found."
     *}
     */
    public function getBankDetails($id)
    {

        try {
            $bank = BankAccountDetails::where('user_id', $id)->firstOrFail();
        } catch (\Exception $e) {
            return new ErrorMessage('Doctor bank details not found.', 404);
        }
        return response()->json($bank, 200);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit Doctor bank details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of bank record
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
     *     "message": "Bank Account details saved successfully."
     *}
     * @response 404 {
     *     "message": "Doctor bank details not found."
     *}
     */
    public function addBankDetails($id, DoctorRequest $request)
    {
        try {
            $bank = BankAccountDetails::findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Doctor bank details not found.', 404);
        }
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $bank->update($data);
        return new SuccessMessage('Bank Account details saved successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin get patient profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of patient in user object
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
     *    "username": "user12345"
     *}
     * @response 404 {
     *    "message": "Details not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function getPatientProfile($id)
    {
        return PatientService::getProfile($id);
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit patient profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of patient
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
     * @bodyParam email email required
     * @bodyParam mobile_number string required
     * @bodyParam country_code string required
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
    public function editPatientProfile($id, PatientRequest $request)
    {
        try {
            User::where('user_type', 'PATIENT')->with('patient')->findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Patient not found.', 404);
        }
        return PatientService::editProfile($request, $id);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin list patient address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of patient in user object
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
     * @response 404 {
     *    "message": "Patient not found."
     *}
     */
    public function listPatientAddress($id)
    {
        try {
            User::where('user_type', 'PATIENT')->findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Patient not found.', 404);
        }

        $list = Address::where('user_id', $id)->orderBy('id', 'desc')->paginate(Address::$page);
        $list->makeVisible('address_type');
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('No records found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit patient address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of address
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
     *    "message": "Address updated successfully."
     *}
     * @response 404 {
     *    "message": "Address not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function editpatientAddress(PatientRequest $request, $id)
    {
        try {
            $address = Address::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Address not found.', 404);
        }
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $address->update($data);
        return new SuccessMessage('Address updated successfully.');
    }
    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit list patient family member
     *
     * @queryParam id required integer id of patient
     *
     * Authorization: "Bearer {access_token}"
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
     * @response 404 {
     *    "message": "Patient not found."
     *}
     */
    public function listPatientFamilyMember($id)
    {
        try {
            User::where('user_type', 'PATIENT')->findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Patient not found.', 404);
        }

        $list = PatientFamilyMembers::where('user_id', $id)->orderBy('id', 'desc')->paginate(20);
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('Family members not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit patient family member
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record from family list
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
     * @response 404 {
     *    "message": "Family member not found."
     *}
     * @response 200 {
     *    "message": "Family member updated successfully."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function editPatientFamilyMember(PatientRequest $request, $id)
    {
        try {
            $family = PatientFamilyMembers::findOrFail($id);
            $family->makeVisible('user_id');
        } catch (\Exception $exception) {
            return new ErrorMessage('Family member not found.', 404);
        }
        $data = $request->validated();
        $user_id = $family->user_id;
        $data = $request->validated();
        return PatientService::editFamilyMember($data, $id, $user_id);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin get Patient BPL info and Emergency contact details.
     *
     * @queryParam id required integer id of patient
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
    public function getPatientEmergencyContact($id)
    {
        return PatientService::getEmergencyContact($id);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin edit patient BPL info and Emergency contact details.
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of patient
     *
     * @bodyParam current_medication string nullable
     * @bodyParam bpl_file_number string nullable
     * @bodyParam bpl_file string nullable if bpl_file_number is filled required File mime:pdf,jpg,jpeg,png size max 2mb
     * @bodyParam first_name_primary string required
     * @bodyParam middle_name_primary string nullable
     * @bodyParam last_name_primary string required
     * @bodyParam mobile_number_primary string required
     * @bodyParam country_code_primary string required
     * @bodyParam relationship_primary string required ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','', 'OTHERS']
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
     * @response 404 {
     *    "message": "Patient not found."
     *}
     */

    public function addPatientEmergencyContact($id, PatientRequest $request)
    {
        try {
            $patient = PatientPersonalInfo::where('user_id', $id)->firstOrFail();
        } catch (\Exception $exception) {
            return new ErrorMessage('Patient not found.', 404);
        }
        return PatientService::addEmergencyContact($request, $id);
    }

    /**
     * @authenticated
     *
     * @group Admin Edit
     *
     * Admin get patient get BPL file to download
     *
     * @queryParam id required integer id of patient
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
    public function getFile($id)
    {
        return PatientService::getFile($id);
    }
}
