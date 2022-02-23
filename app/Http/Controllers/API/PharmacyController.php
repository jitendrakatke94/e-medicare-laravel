<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Address;
use App\Model\BankAccountDetails;
use App\Model\Orders;
use App\Model\Pharmacy;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy get profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "id": 1,
     *    "pharmacy_unique_id": "PHA0000001",
     *    "gstin": "GSTN49598E4",
     *    "dl_number": "LAB12345",
     *    "dl_issuing_authority": "AIMS",
     *    "dl_date_of_issue": "2020-10-15",
     *    "dl_valid_upto": "2030-10-15",
     *    "pharmacy_name": "Pharmacy Name",
     *    "pharmacist_name": "Dereck Konopelski",
     *    "course": "Bsc",
     *    "pharmacist_reg_number": "PHAR1234",
     *    "issuing_authority": "GOVT",
     *    "alt_mobile_number": null,
     *    "alt_country_code": null,
     *    "reg_date": "2020-10-15",
     *    "reg_valid_upto": "2030-10-15",
     *    "home_delivery": 0,
     *    "order_amount": "300.00",
     *    "payout_period": 0,
     *    "dl_file": "http://localhost/fms-api-laravel/public/storage",
     *    "reg_certificate": "http://localhost/fms-api-laravel/public/storage",
     *    "user": {
     *        "id": 31,
     *        "first_name": "Dedric Ortiz",
     *        "middle_name": "Grayce Schiller",
     *        "last_name": "Dereck Konopelski",
     *        "email": "pharmacy@logidots.com",
     *        "username": "pharmacy",
     *        "country_code": "+91",
     *        "mobile_number": "602-904-9875",
     *        "user_type": "PHARMACIST",
     *        "is_active": "0",
     *        "currency_code": "INR",
     *        "profile_photo_url": null
     *    },
     *    "address": [
     *        {
     *            "id": 74,
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
     *            "id": 26,
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
        $record = Pharmacy::with('user')->with('address')->with('bankAccountDetails')->where('user_id', auth()->user()->id)->first();
        if ($record) {
            return response()->json($record, 200);
        }
        return new ErrorMessage('profile details not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy edit profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     *
     * @bodyParam pharmacy_name string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam gstin string required
     * @bodyParam dl_number string required
     * @bodyParam dl_issuing_authority string required
     * @bodyParam dl_date_of_issue date required format:Y-m-d
     * @bodyParam dl_valid_upto date required format:Y-m-d
     * @bodyParam dl_file image file nullable mime:jpg,jpeg,png size max 2mb
     * @bodyParam payout_period boolean required 0 or 1

     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam home_delivery boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if home_delivery is filled
     * @bodyParam currency_code stirng required
     * @bodyParam latitude double required
     * @bodyParam longitude double required
     *
     * @bodyParam pharmacist_name string required
     * @bodyParam course string required
     * @bodyParam pharmacist_reg_number string required
     * @bodyParam issuing_authority string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam reg_certificate file nullable mime:jpg,jpeg,png size max 2mb
     * @bodyParam reg_date string required
     * @bodyParam reg_valid_upto string required
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
     *        "pharmacy_name": [
     *            "The pharmacy name field is required."
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
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ],
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
     *        "reg_date": [
     *            "Registration date field is required."
     *        ],
     *        "reg_valid_upto": [
     *            "Registration valid up to is required."
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

    public function editProfile(PharmacyRequest $request)
    {
        try {
            $userData = $pharmacyData = $bankData = $address = array();

            $userData['last_name'] = $request->pharmacist_name;
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

            Address::where('user_id', auth()->user()->id)->where('address_type', 'PHARMACY')->first()->update($address);

            $bankData['bank_account_number'] = $request->bank_account_number;
            $bankData['bank_account_holder'] = $request->bank_account_holder;
            $bankData['bank_name'] = $request->bank_name;
            $bankData['bank_city'] = $request->bank_city;
            $bankData['bank_ifsc'] = $request->bank_ifsc;
            $bankData['bank_account_type'] = $request->bank_account_type;

            BankAccountDetails::where('user_id', auth()->user()->id)->first()->update($bankData);
            $pharmacyData['pharmacist_name'] = $request->pharmacist_name;
            $pharmacyData['pharmacy_name'] = $request->pharmacy_name;
            $pharmacyData['alt_mobile_number'] = $request->alt_mobile_number;
            $pharmacyData['alt_country_code'] = $request->alt_country_code;
            $pharmacyData['course'] = $request->course;
            $pharmacyData['dl_date_of_issue'] = $request->dl_date_of_issue;

            $pharmacyData['dl_issuing_authority'] = $request->dl_issuing_authority;
            $pharmacyData['dl_number'] = $request->dl_number;
            $pharmacyData['dl_valid_upto'] = $request->dl_valid_upto;
            $pharmacyData['issuing_authority'] = $request->issuing_authority;
            $pharmacyData['pharmacist_reg_number'] = $request->pharmacist_reg_number;
            $pharmacyData['reg_date'] = $request->reg_date;
            $pharmacyData['reg_valid_upto'] = $request->reg_valid_upto;
            $pharmacyData['home_delivery'] = $request->home_delivery;
            $pharmacyData['order_amount'] = $request->order_amount;
            $pharmacyData['payout_period'] = $request->payout_period;
            $pharmacyData['gstin'] = $request->gstin;

            // for dl_file data maybe available
            if ($request->file('dl_file')) {
                $fileName = $request->dl_file->getClientOriginalName();
                $folder = 'public/uploads/' . auth()->user()->id;
                $filePath = $request->file('dl_file')->storeAs($folder, time() . $fileName);
                $pharmacyData['dl_file_path'] = $filePath;
            }
            if ($request->file('reg_certificate')) {
                $fileName = $request->reg_certificate->getClientOriginalName();
                $folder = 'public/uploads/' . auth()->user()->id;
                $filePath = $request->file('reg_certificate')->storeAs($folder, time() . $fileName);
                $pharmacyData['reg_certificate_path'] = $filePath;
            }
            Pharmacy::where('user_id', auth()->user()->id)->first()->update($pharmacyData);
            return new SuccessMessage('Details saved successfully.');
        } catch (\Exception $exception) {
            \Log::debug('PharmacyController.php editProfile', ['EXCEPTION' => $exception->getMessage()]);
            return new ErrorMessage('Something went wrong.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy list payouts
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

        $list = Orders::where('pharma_lab_id', auth()->user()->id)->where('type', 'MED')->with('user:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('payments')->whereHas('payments', function ($query) use ($request) {
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
            if (auth()->user()->pharmacy->payout_period == 0) {
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
