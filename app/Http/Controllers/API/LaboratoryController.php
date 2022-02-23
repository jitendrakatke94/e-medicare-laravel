<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaboratoryRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Address;
use App\Model\BankAccountDetails;
use App\Model\LaboratoryInfo;
use App\Model\Orders;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory get profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "id": 1,
     *    "laboratory_unique_id": "LAB0000001",
     *    "laboratory_name": "Laboratory Name",
     *    "alt_mobile_number": null,
     *    "alt_country_code": null,
     *    "gstin": "GSTN49598E4",
     *    "lab_reg_number": "LAB12345",
     *    "lab_issuing_authority": "AIMS",
     *    "lab_date_of_issue": "2020-10-15",
     *    "lab_valid_upto": "2030-10-15",
     *    "sample_collection": 0,
     *    "order_amount": null,
     *    "payout_period": 0,
     *    "lab_file": null,
     *    "user": {
     *        "id": 30,
     *        "first_name": "Darby Watsica",
     *        "middle_name": "Jadyn Wehner",
     *        "last_name": "Prof. Edwina O'Connell",
     *        "email": "labortory@logidots.com",
     *        "username": "laboratory",
     *        "country_code": "+91",
     *        "mobile_number": "+1.986.227.1219",
     *        "user_type": "LABORATORY",
     *        "is_active": "1",
     *        "currency_code": "INR",
     *        "profile_photo_url": null
     *    },
     *    "address": [
     *        {
     *            "id": 73,
     *            "street_name": "East Road",
     *            "city_village": "Edamon",
     *            "district": "Kollam",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "691307",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": "10.53034500",
     *            "longitude": "76.21472900",
     *            "clinic_name": null
     *        }
     *    ],
     *    "bank_account_details": [
     *        {
     *            "id": 25,
     *            "bank_account_number": "BANK12345",
     *            "bank_account_holder": "BANKER",
     *            "bank_name": "BANK",
     *            "bank_city": "India",
     *            "bank_ifsc": "IFSC45098",
     *            "bank_account_type": "SAVINGS"
     *        }
     *    ]
     *}
     *
     * @response 404 {
     *    "message": "profile details not found."
     *}
     */
    public function getProfile()
    {
        $record = LaboratoryInfo::with('user')->with('address')->with('bankAccountDetails')->where('user_id', auth()->user()->id)->first();

        if ($record) {
            $record->makeHidden('lab_tests');
            return response()->json($record, 200);
        }
        return new ErrorMessage('profile details not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory edit profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam laboratory_name string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam gstin string required
     * @bodyParam lab_reg_number string required
     * @bodyParam lab_issuing_authority string required
     * @bodyParam lab_date_of_issue date required format:Y-m-d
     * @bodyParam lab_valid_upto date required format:Y-m-d
     * @bodyParam payout_period boolean required 0 or 1
     * @bodyParam lab_file image nullable mime:jpg,jpeg,png size max 2mb

     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam sample_collection boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if home_delivery is filled
     * @bodyParam currency_code stirng required
     * @bodyParam latitude double required
     * @bodyParam longitude double required
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
     *        "laboratory_name": [
     *            "The laboratory name field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "gstin": [
     *            "The gstin field is required."
     *        ],
     *        "lab_reg_number": [
     *            "The lab reg number field is required."
     *        ],
     *        "lab_issuing_authority": [
     *            "The lab issuing authority field is required."
     *        ],
     *        "lab_date_of_issue": [
     *            "The lab date of issue field is required."
     *        ],
     *        "lab_valid_upto": [
     *            "The lab valid upto field is required."
     *        ],
     *        "lab_file": [
     *            "The lab file field is required."
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
     *        ],
     *        "sample_collection": [
     *            "The sample collection field is required."
     *        ],
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ],
     *        "data_id": [
     *            "The data id field is required."
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
     *
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     * @response 422 {
     *    "message": "Something went wrong."
     *}
     */

    public function editProfile(LaboratoryRequest $request)
    {
        try {
            $userData = $labData = $bankData = $address = array();

            $userData['last_name'] = $request->laboratory_name;
            $userData['email'] = $request->email;
            $userData['country_code'] = $request->country_code;
            $userData['mobile_number'] = $request->mobile_number;
            $userData['currency_code'] = $request->currency_code;

            User::find(auth()->user()->id)->update($userData);
            //address table
            $address['street_name'] = $request->street_name;
            $address['city_village'] = $request->city_village;
            $address['district'] = $request->district;
            $address['state'] = $request->state;
            $address['country'] = $request->country;
            $address['pincode'] = $request->pincode;
            $address['latitude'] = $request->latitude;
            $address['longitude'] = $request->longitude;
            $address['updated_by'] = auth()->user()->id;

            Address::where('user_id', auth()->user()->id)->where('address_type', 'LABORATORY')->first()->update($address);

            $bankData['bank_account_number'] = $request->bank_account_number;
            $bankData['bank_account_holder'] = $request->bank_account_holder;
            $bankData['bank_name'] = $request->bank_name;
            $bankData['bank_city'] = $request->bank_city;
            $bankData['bank_ifsc'] = $request->bank_ifsc;
            $bankData['bank_account_type'] = $request->bank_account_type;
            BankAccountDetails::where('user_id', auth()->user()->id)->first()->update($bankData);

            //LaboratoryInfo table
            $labData['laboratory_name'] = $request->laboratory_name;
            $labData['alt_mobile_number'] = $request->alt_mobile_number;
            $labData['alt_country_code'] = $request->alt_country_code;
            $labData['gstin'] = $request->gstin;
            $labData['lab_reg_number'] = $request->lab_reg_number;
            $labData['lab_issuing_authority'] = $request->lab_issuing_authority;
            $labData['lab_date_of_issue'] = $request->lab_date_of_issue;
            $labData['lab_valid_upto'] = $request->lab_valid_upto;
            $labData['sample_collection'] = $request->sample_collection;
            $labData['order_amount'] = $request->order_amount;
            $labData['payout_period'] = $request->payout_period;

            if ($request->file('lab_file')) {
                $fileName = $request->lab_file->getClientOriginalName();
                $folder = 'public/uploads/' . auth()->user()->id;
                $filePath = $request->file('lab_file')->storeAs($folder, time() . $fileName);
                $labData['lab_file_path'] = $filePath;
            }

            LaboratoryInfo::where('user_id', auth()->user()->id)->first()->update($labData);

            return new SuccessMessage('Details saved successfully.');
        } catch (\Exception $exception) {
            \Log::debug('LaboratoryController.php editProfile', ['EXCEPTION' => $exception->getMessage()]);
            return new ErrorMessage('Something went wrong.', 422);
        }
    }
    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory edit test list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam lab_tests array nullable
     * @bodyParam lab_tests.*.id integer required test list ids
     * @bodyParam lab_tests.*.sample_collect boolean required 0 or 1
     *
     * @response 200 {
     *    "message": "Record saved successfully."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "lab_tests.0.id": [
     *            "The lab_tests.0.id field is required."
     *        ],
     *        "lab_tests.0.sample_collect": [
     *            "The lab_tests.0.sample_collect field is required."
     *        ]
     *    }
     *}
     */

    public function addLaboratoryTest(LaboratoryRequest $request)
    {
        try {

            $record = LaboratoryInfo::where('user_id', auth()->user()->id)->firstOrFail();
            $record->lab_tests = $request->lab_tests;
            $record->save();
            return new SuccessMessage('Record saved successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory get test list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "lab_tests": [
     *        {
     *            "id": "1",
     *            "sample_collect": "1"
     *        },
     *        {
     *            "id": "2",
     *            "sample_collect": "1"
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Record not found."
     *}
     */

    public function getLaboratoryTest()
    {
        try {
            $record = LaboratoryInfo::select('lab_tests')->where('user_id', auth()->user()->id)->first();
            $record->makeHidden('lab_file');
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found', 404);
        }
    }
    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory list payouts
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
     *    "next_payout_period": "28 March 2021 11:59 PM",
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 64,
     *            "unique_id": "ORD0000064",
     *            "user_id": 3,
     *            "tax": 1.8,
     *            "subtotal": 200,
     *            "discount": 5,
     *            "delivery_charge": 10,
     *            "total": 206.8,
     *            "commission": 10,
     *            "shipping_address_id": 75,
     *            "payment_status": "Paid",
     *            "delivery_status": "Open",
     *            "delivery_info": null,
     *            "created_at": "2021-03-23 06:08:39 pm",
     *            "user": {
     *                "id": 3,
     *                "first_name": "Test",
     *                "middle_name": "middle",
     *                "last_name": "Patient",
     *                "email": "patient@logidots.com",
     *                "country_code": "+91",
     *                "mobile_number": "9876543210",
     *                "profile_photo_url": null
     *            },
     *            "payments": {
     *                "id": 285,
     *                "unique_id": "PAY0000285",
     *                "total_amount": 206.8,
     *                "payment_status": "Paid",
     *                "created_at": "2021-03-23 06:08:39 pm"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/payouts?page=1",
     *    "from": 1,
     *    "last_page": 7,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/payouts?page=7",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/payouts?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/pharmacy/payouts",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 7
     *}
     *
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listPayouts(Request $request)
    {
        $request->validate([
            'paid' => 'present|nullable|in:0,1',
        ]);

        $list = Orders::where('pharma_lab_id', auth()->user()->id)->where('type', 'LAB')->with('user:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('payments')->whereHas('payments', function ($query) use ($request) {
            if ($request->filled('paid')) {
                if ($request->paid == 0) {
                    $query->where('payment_status', 'Not Paid');
                } else {
                    $query->where('payment_status', 'Paid');
                }
            }
        })->orderBy('id', 'desc')->paginate(Orders::$page);

        if ($list->count() > 0) {
            $list->makeVisible('commission');

            // find next payout date
            $next_payout_period = NULL;
            if (auth()->user()->laboratory->payout_period == 0) {
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
}
