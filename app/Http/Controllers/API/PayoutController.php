<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Http\Services\ImportService;
use App\Jobs\ImportJob;
use App\Jobs\SendEmailJob;
use App\Mail\ImportMail;
use App\Model\Import;
use App\Model\Payout;
use App\Model\PayoutInformation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PayoutController extends Controller
{
    /**
     * @authenticated
     *
     * @group General
     *
     * Get payout list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     * @queryParam name present string pharmacy name
     * @queryParam status present send 0 for unpaid 1 for paid

     * @response 200 {
     *    "earnings": 3914.73,
     *    "total_payable": 25211.16,
     *    "total_paid": 3549.14,
     *    "balance": 900,
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 2,
     *            "payout_id": "PY0000002",
     *            "cycle": "WEEKLY",
     *            "period": "Feb 08,2021 - Feb 15,2021",
     *            "total_sales": 1000,
     *            "earnings": 300,
     *            "total_payable": 700,
     *            "total_paid": 0,
     *            "balance": 0,
     *            "status": 0,
     *            "previous_due": 500,
     *            "current_due": 500,
     *            "time": "2021-02-08 09:14:33 pm",
     *            "pharmacy": {
     *                "pharmacy_name": "Pharmacy Name",
     *                "dl_file": null,
     *                "reg_certificate": null
     *            },
     *            "bank_account_details": {
     *                "id": 4,
     *                "bank_account_number": "BANK12345",
     *                "bank_account_holder": "BANKER",
     *                "bank_name": "BANK",
     *                "bank_city": "India",
     *                "bank_ifsc": "IFSC4509899",
     *                "bank_account_type": "SAVINGS"
     *            },
     *            "address": {
     *                "id": 4,
     *                "street_name": "East Road",
     *                "city_village": "Edamon",
     *                "district": "Kollam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "691307",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": null
     *            },
     *            "payout_history_latest": null
     *        },
     *        {
     *            "id": 1,
     *            "payout_id": "PY0000001",
     *            "cycle": "WEEKLY",
     *            "period": "Feb 08,2021 - Feb 15,2021",
     *            "total_sales": 1000,
     *            "earnings": 300,
     *            "total_payable": 700,
     *            "total_paid": 200,
     *            "balance": 500,
     *            "status": 0,
     *            "previous_due": 0,
     *            "current_due": 500,
     *            "time": "2021-02-08 09:14:33 pm",
     *            "pharmacy": {
     *                "pharmacy_name": "Pharmacy Name",
     *                "dl_file": null,
     *                "reg_certificate": null
     *            },
     *            "bank_account_details": {
     *                "id": 4,
     *                "bank_account_number": "BANK12345",
     *                "bank_account_holder": "BANKER",
     *                "bank_name": "BANK",
     *                "bank_city": "India",
     *                "bank_ifsc": "IFSC4509899",
     *                "bank_account_type": "SAVINGS"
     *            },
     *            "address": {
     *                "id": 4,
     *                "street_name": "East Road",
     *                "city_village": "Edamon",
     *                "district": "Kollam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "691307",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": null
     *            },
     *            "payout_history_latest": null
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/payout",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 2,
     *    "total": 2
     *}
     * @response 200 {
     *    "earnings": 3914.73,
     *    "total_payable": 25211.16,
     *    "total_paid": 3549.14,
     *    "balance": 900,
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 3,
     *            "payout_id": "PY0000003",
     *            "cycle": "WEEKLY",
     *            "period": "Feb 08,2021 - Feb 15,2021",
     *            "total_sales": 7000,
     *            "earnings": 2000,
     *            "total_payable": 5000,
     *            "total_paid": 0,
     *            "balance": null,
     *            "status": 0,
     *            "previous_due": 700,
     *            "current_due": 500,
     *            "time": "2021-02-16 07:23:03 pm",
     *            "labortory": {
     *                "laboratory_name": "Laboratory Name",
     *                "lab_file": null
     *            },
     *            "bank_account_details": {
     *                "id": 3,
     *                "bank_account_number": "12345677",
     *                "bank_account_holder": "BANKER",
     *                "bank_name": "BANK",
     *                "bank_city": "India",
     *                "bank_ifsc": "IFSC4509845",
     *                "bank_account_type": "SAVINGS"
     *            },
     *            "address": {
     *                "id": 3,
     *                "street_name": "East Road",
     *                "city_village": "Edamon",
     *                "district": "Kollam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "691307",
     *                "country_code": null,
     *                "contact_number": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": null
     *            },
     *            "payout_history_latest": {
     *                "id": 12,
     *                "payout_id": 1,
     *                "amount": 220,
     *                "reference": "GHH",
     *                "comment": "FJJKL",
     *                "created_at": "2021-02-11 11:20:44 pm"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/payout",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 200 {
     *    "earnings": 3914.73,
     *    "total_payable": 25211.16,
     *    "total_paid": 3549.14,
     *    "balance": 900,
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 5,
     *            "payout_id": "PY0000005",
     *            "cycle": "WEEKLY",
     *            "period": "Feb 08,2021 - Feb 15,2021",
     *            "total_sales": 7000,
     *            "earnings": 2000,
     *            "total_payable": 2000,
     *            "total_paid": 0,
     *            "balance": null,
     *            "status": 0,
     *            "previous_due": 5000,
     *            "current_due": 500,
     *            "time": "2021-02-16 07:23:29 pm",
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "profile_photo_url": null
     *            },
     *            "bank_account_details": {
     *                "id": 1,
     *                "bank_account_number": "123456",
     *                "bank_account_holder": "Theo",
     *                "bank_name": "jcujsejdfecs",
     *                "bank_city": "Nagercoil",
     *                "bank_ifsc": "IFSC123456",
     *                "bank_account_type": "SAVINGS"
     *            },
     *            "address": {
     *                "id": 1,
     *                "street_name": "South Road",
     *                "city_village": "Edamatto",
     *                "district": "Kottayam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "686575",
     *                "country_code": null,
     *                "contact_number": "9786200983",
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "Neo clinic"
     *            },
     *            "payout_history_latest": {
     *                "id": 12,
     *                "payout_id": 1,
     *                "amount": 220,
     *                "reference": "GHH",
     *                "comment": "FJJKL",
     *                "created_at": "2021-02-11 11:20:44 pm"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/payout?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/payout",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "type": [
     *            "The type field is required."
     *        ],
     *        "name": [
     *            "The name field must be present."
     *        ],
     *        "status": [
     *            "The selected status is invalid."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function list(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB,DOC',
            'name' => 'present|nullable',
            'status' => 'present|nullable|in:0,1'
        ]);

        $list = Payout::where('type', $request->type); //
        if ($data['type'] == 'MED') {
            $list = $list->with('pharmacy:user_id,pharmacy_name');
            if ($request->filled('name')) {
                $list = $list->whereHas('pharmacy', function ($query) use ($data) {
                    $query->where('pharmacy_name', 'like', '%' . $data['name'] . '%');
                });
            }
        } else if ($data['type'] == 'LAB') {
            $list = $list->with('labortory:user_id,laboratory_name');
            if ($request->filled('name')) {
                $list = $list->whereHas('labortory', function ($query) use ($data) {
                    $query->where('laboratory_name', 'like', '%' . $data['name'] . '%');
                });
            }
        } else if ($data['type'] == 'DOC') {
            $list = $list->with('doctor:id,first_name,middle_name,last_name');
            if ($request->filled('name')) {
                $list = $list->whereHas('doctor', function ($query) use ($data) {
                    $query->orWhere('first_name', 'like', '%' . $data['name'] . '%');
                    $query->orWhere('middle_name', 'like', '%' . $data['name'] . '%');
                    $query->orWhere('last_name', 'like', '%' . $data['name'] . '%');
                });
            }
        }
        if ($request->filled('status')) {
            $list = $list->where('status', $data['status']);
        }
        $list->with('bank_account_details');
        $list->with('address');
        $list->with('payout_history_latest');

        $paginate = $list->orderBy('created_at', 'desc')->paginate(Payout::$page);


        if ($paginate->count() > 0) {

            $earnings = $list->offset(0)->limit($paginate->perPage() * $paginate->currentPage())->sum('earnings');
            $total_payable = $list->offset(0)->limit($paginate->perPage() * $paginate->currentPage())->sum('total_payable');
            $total_paid = $list->offset(0)->limit($paginate->perPage() * $paginate->currentPage())->sum('total_paid');
            $balance = $total_payable - $total_paid;
            $return = collect(['earnings' => round($earnings, 2), 'total_payable' => round($total_payable, 2), 'total_paid' => round($total_paid, 2), 'balance' => round($balance, 2)]);

            $data = $return->merge($paginate);
            return response()->json($data, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Get payout list by user
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     * @queryParam today present numeric send value 1 to apply filter
     * @queryParam last_30_days present numeric send value 1 to apply filter
     * @queryParam financial_year present numeric send value 1 to apply filter
     * @queryParam custom present array
     * @queryParam custom.start_date string format:Y-m-d
     * @queryParam custom.end_date string format:Y-m-d
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "payout_id": "PY0000001",
     *            "cycle": "WEEKLY",
     *            "period": "22 March 2021 - 28 March 2021",
     *            "total_sales": 8116.04,
     *            "earnings": 1145.54,
     *            "total_payable": 6970.5,
     *            "total_paid": 0,
     *            "balance": 0,
     *            "status": 0,
     *            "previous_due": 0,
     *            "time": "2021-03-25 07:33:28 pm",
     *            "current_due": 0
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/payout/user?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/payout/user?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/payout/user",
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
    public function listUserPayout(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB,DOC',
            'today' => 'present|nullable|in:1',
            'last_30_days' => 'present|nullable|in:1',
            'financial_year' => 'present|nullable|in:1',
            'custom' => 'array|present',
            'custom.start_date' => 'present|date_format:Y-m-d|nullable',
            'custom.end_date' => 'present|date_format:Y-m-d|nullable|required_with:custom.start_date|after_or_equal:custom.start_date'
        ]);

        $list = Payout::where('type', $data['type'])->where('type_id', auth()->user()->id);
        if ($request->filled('today')) {
            $list = $list->whereDate('created_at', Carbon::today());
        }
        if ($request->filled('last_30_days')) {
            $list = $list->whereDate('created_at', '>', Carbon::now()->subDays(30));
        }
        if ($request->filled('financial_year')) {

            if (Carbon::now()->format('m') >= 04) {
                $start_date = '01-04-' . Carbon::now()->format('Y');
                $end_date = '31-03-' . Carbon::now()->addYear(1)->format('Y');
            } else {
                $start_date = '01-04-' . Carbon::now()->subYear(1)->format('Y');
                $end_date = '31-03-' . Carbon::now()->format('Y');
            }

            $list = $list->whereBetween('created_at', [Carbon::parse($start_date . '00:00:00'), Carbon::parse($end_date . '23:59:59')]);
        }

        if ($request->filled('custom.start_date')) {
            $list = $list->whereBetween('created_at', [Carbon::parse($data['custom']['start_date'] . '00:00:00'), Carbon::parse($data['custom']['end_date'] . '23:59:59')]);
        }
        $list = $list->orderBy('created_at', 'desc')->paginate(Payout::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group General
     *
     * Get payout list by user - Payout Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     * @queryParam id required integer id of payouts
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "type": [
     *            "The type field is required."
     *        ],
     *        "id": [
     *            "The id field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "payout_id": "PY0000001",
     *        "cycle": "WEEKLY",
     *        "period": "22 March 2021 - 28 March 2021",
     *        "total_sales": 8116.04,
     *        "earnings": 1145.54,
     *        "total_payable": 6970.5,
     *        "total_paid": 0,
     *        "balance": 0,
     *        "status": 0,
     *        "previous_due": 0,
     *        "time": "2021-03-25 07:33:28 pm",
     *        "current_due": 0,
     *        "records": [
     *            {
     *                "unique_id": "AP0000340",
     *                "tax": 26.35,
     *                "commission": 55,
     *                "total": 576.35
     *            },
     *            {
     *                "unique_id": "AP0000369",
     *                "tax": 13.46,
     *                "commission": 28.1,
     *                "total": 294.46
     *            },
     *            {
     *                "unique_id": "AP0000372",
     *                "tax": 17.1,
     *                "commission": 35.7,
     *                "total": 374.1
     *            }
     *        ]
     *    }
     *]
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listUserPayoutById(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB,DOC',
            'id' => 'required|exists:payouts,id'
        ]);
        $list = Payout::where('type', $data['type'])->where('id', $data['id'])->where('type_id', auth()->user()->id)->get();

        if ($list->count() > 0) {
            $list->makeVisible('records');
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }


    /**
     * @authenticated
     *
     * @group General
     *
     * Get payout recent transaction
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     *
     * @response 200 [
     *    {
     *        "id": 2,
     *        "payout_id": "PY0000002",
     *        "cycle": "WEEKLY",
     *        "period": "Feb 08,2021 - Feb 15,2021",
     *        "total_sales": 1000,
     *        "earnings": 300,
     *        "total_payable": 700,
     *        "total_paid": 0,
     *        "balance": null,
     *        "status": 0,
     *        "previous_due": 700,
     *        "current_due": 500,
     *        "created_at": "2021-02-04 19:03 PM",
     *        "pharmacy": {
     *            "pharmacy_name": "Pharmacy Name",
     *            "dl_file": null,
     *            "reg_certificate": null
     *        }
     *    },
     *    {
     *        "id": 1,
     *        "payout_id": "PY0000001",
     *        "cycle": "WEEKLY",
     *        "period": "Feb 01,2021 - Feb 07,2021",
     *        "total_sales": 1000,
     *        "earnings": 300,
     *        "total_payable": 700,
     *        "total_paid": 0,
     *        "balance": null,
     *        "status": 0,
     *        "previous_due": 700,
     *        "current_due": 500,
     *        "created_at": "2021-02-04 19:01 PM",
     *        "pharmacy": {
     *            "pharmacy_name": "Pharmacy Name",
     *            "dl_file": null,
     *            "reg_certificate": null
     *        }
     *    }
     *]
     *
     * @response 200 [
     *    {
     *        "id": 3,
     *        "payout_id": "PY0000003",
     *        "cycle": "WEEKLY",
     *        "period": "Feb 08,2021 - Feb 15,2021",
     *        "total_sales": 7000,
     *        "earnings": 2000,
     *        "total_payable": 5000,
     *        "total_paid": 0,
     *        "balance": null,
     *        "status": 0,
     *        "previous_due": 700,
     *        "current_due": 500,
     *        "time": "2021-02-16 07:23:03 pm",
     *        "labortory": {
     *            "laboratory_name": "Laboratory Name",
     *            "lab_file": null
     *        }
     *    },
     *    {
     *        "id": 2,
     *        "payout_id": "PY0000002",
     *        "cycle": "WEEKLY",
     *        "period": "Feb 08,2021 - Feb 15,2021",
     *        "total_sales": 1000,
     *        "earnings": 300,
     *        "total_payable": 700,
     *        "total_paid": 0,
     *        "balance": null,
     *        "status": 0,
     *        "previous_due": 0,
     *        "current_due": 500,
     *        "time": "2021-02-16 07:22:17 pm",
     *        "labortory": {
     *            "laboratory_name": "Laboratory Name",
     *            "lab_file": null
     *        }
     *    }
     *]
     * @response 200 [
     *    {
     *        "id": 5,
     *        "payout_id": "PY0000005",
     *        "cycle": "WEEKLY",
     *        "period": "Feb 08,2021 - Feb 15,2021",
     *        "total_sales": 7000,
     *        "earnings": 2000,
     *        "total_payable": 2000,
     *        "total_paid": 0,
     *        "balance": null,
     *        "status": 0,
     *        "previous_due": 5000,
     *        "current_due": 500,
     *        "time": "2021-02-16 07:23:29 pm",
     *        "doctor": {
     *            "id": 2,
     *            "first_name": "Theophilus",
     *            "middle_name": "Jos",
     *            "last_name": "Simeon",
     *            "profile_photo_url": null
     *        }
     *    },
     *    {
     *        "id": 4,
     *        "payout_id": "PY0000004",
     *        "cycle": "WEEKLY",
     *        "period": "Feb 08,2021 - Feb 15,2021",
     *        "total_sales": 7000,
     *        "earnings": 2000,
     *        "total_payable": 5000,
     *        "total_paid": 0,
     *        "balance": null,
     *        "status": 0,
     *        "previous_due": 0,
     *        "current_due": 500,
     *        "time": "2021-02-16 07:23:13 pm",
     *        "doctor": {
     *            "id": 2,
     *            "first_name": "Theophilus",
     *            "middle_name": "Jos",
     *            "last_name": "Simeon",
     *            "profile_photo_url": null
     *        }
     *    }
     *]
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listRecentTransaction(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB,DOC',
        ]);

        $list = Payout::where('type', $request->type);
        if ($data['type'] == 'MED') {
            $list = $list->with('pharmacy:user_id,pharmacy_name');
        } else if ($data['type'] == 'DOC') {
            $list = $list->with('doctor:id,first_name,middle_name,last_name');
        } else if ($data['type'] == 'LAB') {
            $list = $list->with('labortory:user_id,laboratory_name');
        }
        $list = $list->orderBy('id', 'desc')->take(5)->get();

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Get payout histories
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     * @queryParam payout_id required id of payout list
     *
     * @reponse 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "type": [
     *            "The type field is required."
     *        ],
     *        "payout_id": [
     *            "The payout id field is required."
     *        ]
     *    }
     *}
     * @response 200 [
     *    {
     *        "id": 1,
     *        "payout_id": "PY0000001",
     *        "cycle": "WEEKLY",
     *        "period": "Feb 01,2021 - Feb 07,2021",
     *        "total_sales": 1000,
     *        "earnings": 300,
     *        "total_payable": 700,
     *        "total_paid": 0,
     *        "balance": null,
     *        "status": 0,
     *        "created_at": "2021-02-04 19:01 PM",
     *        "payout_history": [
     *            {
     *                "id": 1,
     *                "payout_id": 1,
     *                "amount": 300,
     *                "reference": "REFLKM",
     *                "comment": "No comments",
     *                "created_at": "2021-02-05 19:19 PM"
     *            },
     *            {
     *                "id": 2,
     *                "payout_id": 1,
     *                "amount": 100,
     *                "reference": "REFLKM",
     *                "comment": "Payment 2",
     *                "created_at": "2021-02-05 19:50 PM"
     *            }
     *        ]
     *    }
     *]
     * @response 404 {
     *    "message": "No records found."
     *}
     */

    public function getPayoutHistory(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB,DOC',
            'payout_id' => 'required|integer|exists:payouts,id'
        ]);
        return $data;
        $list = Payout::where('id', $data['payout_id'])->where('type', $data['type'])->whereHas('payout_history')->with('payout_history')->orderBy('id', 'desc')->get();

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group General
     *
     * Single payout
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam payout_id integer required id from payout list
     * @bodyParam amount numeric required
     * @bodyParam reference string required
     * @bodyParam comment string nullable present
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "payout_id": [
     *            "The payout id field is required."
     *        ],
     *        "amount": [
     *            "The amount field is required."
     *        ],
     *        "reference": [
     *            "The reference field is required."
     *        ],
     *        "comment": [
     *            "The comment field must be present."
     *        ]
     *    }
     *}
     *
     *
     * @response 403 {
     *    "message": "Payable amount is higher than current due."
     *}
     * @response 200 {
     *    "message": "Payment successfull."
     *}
     */
    public function makeSinglePayout(Request $request)
    {
        $data = $request->validate([
            'payout_id' => 'required|exists:payouts,id,status,0',
            'amount' => 'required|numeric',
            'reference' => 'required',
            'comment' => 'present|nullable'
        ]);

        $record = Payout::find($data['payout_id']);

        $value = $record->total_payable - $record->total_paid;

        if ($data['amount'] > $value) {
            return new ErrorMessage("Payable amount is higher than current due.", 403);
        }

        $total_paid = $record->total_paid + $data['amount'];
        $record->total_paid = $total_paid;

        $balance = $record->total_payable - $total_paid;
        $record->balance = $balance;

        if ($record->total_payable == $total_paid) {
            $record->status = 1;
        }
        $record->save();

        $info =  PayoutInformation::create([
            'type' => $request->type,
            'payout_id' => $request->payout_id,
            'amount' => $request->amount,
            'reference' => $request->reference,
            'comment' => $request->comment
        ]);
        $user = User::find($record->type_id);

        SendEmailJob::dispatch(['name' => $user->last_name, 'email' => $user->email, 'mail_type' => 'payment_notification', 'record' => $record, 'info' => $info]);

        return new SuccessMessage('Payment successfull.');
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Bulk payout
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam file file required file type -> xlsx,csv
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "file": [
     *            "The file must be a file of type: csv, xls, xlsx."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "File uploaded successfully."
     *}
     * @response 422 {
     *    "message": "All headers are not found."
     *}
     * @response 422 {
     *    "message": "Headers are not in order."
     *}
     * @response 422 {
     *    "message": "Invalid File Format."
     *}
     */
    public function makeBulkPayout(Request $request)
    {

        $data = $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,txt,xls',
        ]);
        $fileName = $request->file->getClientOriginalName();
        $folder = 'public/uploads/imports';
        $filePath = $request->file('file')->storeAs($folder, time() . $fileName);
        $data['file_name'] = $fileName;
        $data['file_path'] = $filePath;
        $data['user_id'] = auth()->user()->id;
        $file_extension = $request->file->getClientOriginalExtension();

        $import = Import::create($data);
        try {
            $importService = new ImportService;
            $data = $importService->getHeaderAndData(Storage::path($import->file_path), $file_extension);
            //get headers only from file
            $search = $data['raw_header'];
            $headers = array('Payout ID', 'Amount', 'Payment Reference', 'Comments');

            $contains_all_header = 0 == count(array_diff($headers, $search));
            //check all headers are found
            if ($contains_all_header) { // headers found

                $search = array_filter($search);
                // check all hearders are in order
                if ($headers !== $search) {
                    return new ErrorMessage('Headers are not in order.', 422);
                }
                ImportJob::dispatch($import, $data, $search, auth()->user());
                return new SuccessMessage('File uploaded successfully.');
            } else {
                return new ErrorMessage('All headers are not found.', 422);
            }
        } catch (\Exception $e) {
            return new ErrorMessage($e->getMessage(), 422);
        }
    }
}
