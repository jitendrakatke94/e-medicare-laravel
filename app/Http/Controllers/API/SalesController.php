<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * @authenticated
     *
     * @group General
     *
     * Get sales list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     * @queryParam name present string pharmacy name
     * @queryParam today present numeric send value 1 to apply filter
     * @queryParam last_30_days present numeric send value 1 to apply filter
     * @queryParam financial_year present numeric send value 1 to apply filter
     * @queryParam custom present array
     * @queryParam custom.start_date string format:Y-m-d
     * @queryParam custom.end_date string format:Y-m-d
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "type": [
     *            "The type field is required."
     *        ],
     *        "today": [
     *            "The today field must be present."
     *        ],
     *        "last_30_days": [
     *            "The last 30 days field must be present."
     *        ],
     *        "financial_year": [
     *            "The financial year field must be present."
     *        ],
     *        "custom": [
     *            "The custom must be an array."
     *        ],
     *        "custom.start_date": [
     *            "The custom.start date field must be present."
     *        ],
     *        "custom.end_date": [
     *            "The custom.end date field must be present."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "earnings": 8060,
     *    "over_due": 4280,
     *    "total_sales": 8520,
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "payout_id": "SL0000001",
     *            "service": "direct",
     *            "total": 300,
     *            "tax_amount": 10,
     *            "earnings": 20,
     *            "payable_to_vendor": 270,
     *            "pdf_url": null,
     *            "created_at": "2021-02-02 19:33 PM",
     *            "patient": {
     *                "id": 3,
     *                "first_name": "Test",
     *                "middle_name": null,
     *                "last_name": "Patient",
     *                "profile_photo_url": null
     *            },
     *            "pharmacy": {
     *                "pharmacy_name": "Pharmacy Name",
     *                "dl_file": null,
     *                "reg_certificate": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=1",
     *    "from": 1,
     *    "last_page": 4,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=4",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/sales",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 4
     *}
     * @response 200 {
     *    "earnings": 1000,
     *    "over_due": 500,
     *    "total_sales": 1100,
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 6,
     *            "payout_id": "SL0000006",
     *            "service": "Direct",
     *            "total": 500,
     *            "tax_amount": 100,
     *            "earnings": 500,
     *            "payable_to_vendor": 200,
     *            "pdf_url": null,
     *            "created_at": "2021-02-16 06:25:02 pm",
     *            "patient": {
     *                "id": 3,
     *                "first_name": "Ben",
     *                "middle_name": null,
     *                "last_name": "Patient",
     *                "profile_photo_url": null
     *            },
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "profile_photo_url": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/sales",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 200 {
     *    "earnings": 1000,
     *    "over_due": 500,
     *    "total_sales": 1100,
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 4,
     *            "payout_id": "SL0000004",
     *            "service": "Direct",
     *            "total": 600,
     *            "tax_amount": 100,
     *            "earnings": 500,
     *            "payable_to_vendor": 300,
     *            "pdf_url": null,
     *            "created_at": "2021-02-16 06:24:40 pm",
     *            "patient": {
     *                "id": 3,
     *                "first_name": "Ben",
     *                "middle_name": null,
     *                "last_name": "Patient",
     *                "profile_photo_url": null
     *            },
     *            "labortory": {
     *                "laboratory_name": "Laboratory Name",
     *                "lab_file": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/sales?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/sales",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     *
     */
    public function list(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB,DOC',
            'name' => 'present|nullable',
            'today' => 'present|nullable|in:1',
            'last_30_days' => 'present|nullable|in:1',
            'financial_year' => 'present|nullable|in:1',
            'custom' => 'array|present',
            'custom.start_date' => 'present|date_format:Y-m-d|nullable',
            'custom.end_date' => 'present|date_format:Y-m-d|nullable|required_with:custom.start_date|after_or_equal:custom.start_date'
        ]);
        $list = Sales::where('type', $request->type)->with('patient:id,first_name,middle_name,last_name'); //
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
        $paginate = $list->orderBy('id', 'desc')->paginate(Sales::$page);


        if ($paginate->count() > 0) {
            $earnings = $list->offset(0)->limit($paginate->perPage() * $paginate->currentPage())->sum('earnings');
            $paid = $list->offset(0)->limit($paginate->perPage() * $paginate->currentPage())->sum('paid');
            $payable_to_vendor = $list->offset(0)->limit($paginate->perPage() * $paginate->currentPage())->sum('payable_to_vendor');
            $total_sales = $list->offset(0)->limit($paginate->perPage() * $paginate->currentPage())->sum('total');
            $over_due = $payable_to_vendor - $paid;

            $return = collect(['earnings' => round($earnings, 2), 'over_due' => round($over_due, 2), 'total_sales' => round($total_sales, 2)]);
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
     * Get sales recent transaction
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     *
     * @response 200 [
     *    {
     *        "id": 4,
     *        "payout_id": "SL0000004",
     *        "service": "direct",
     *        "total": 300,
     *        "tax_amount": 10,
     *        "earnings": 10,
     *        "payable_to_vendor": 270,
     *        "pdf_url": null,
     *        "created_at": "2021-02-02 19:33 PM",
     *        "patient": {
     *            "id": 3,
     *            "first_name": "Test",
     *            "middle_name": null,
     *            "last_name": "Patient",
     *            "profile_photo_url": null
     *        },
     *        "pharmacy": {
     *            "pharmacy_name": "Pharmacy Name",
     *            "dl_file": null,
     *            "reg_certificate": null
     *        }
     *    },
     *    {
     *        "id": 3,
     *        "payout_id": "SL0000003",
     *        "service": "direct",
     *        "total": 300,
     *        "tax_amount": 10,
     *        "earnings": 10,
     *        "payable_to_vendor": 270,
     *        "pdf_url": null,
     *        "created_at": "2021-02-02 19:33 PM",
     *        "patient": {
     *            "id": 3,
     *            "first_name": "Test",
     *            "middle_name": null,
     *            "last_name": "Patient",
     *            "profile_photo_url": null
     *        },
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
     *        "id": 4,
     *        "payout_id": "SL0000004",
     *        "service": "Direct",
     *        "total": 600,
     *        "tax_amount": 100,
     *        "earnings": 500,
     *        "payable_to_vendor": 300,
     *        "pdf_url": null,
     *        "created_at": "2021-02-16 06:24:40 pm",
     *        "patient": {
     *            "id": 3,
     *            "first_name": "Ben",
     *            "middle_name": null,
     *            "last_name": "Patient",
     *            "profile_photo_url": null
     *        },
     *        "labortory": {
     *            "laboratory_name": "Laboratory Name",
     *            "lab_file": null
     *        }
     *    },
     *    {
     *        "id": 3,
     *        "payout_id": "SL0000003",
     *        "service": "Direct",
     *        "total": 500,
     *        "tax_amount": 100,
     *        "earnings": 500,
     *        "payable_to_vendor": 200,
     *        "pdf_url": null,
     *        "created_at": "2021-02-16 06:24:28 pm",
     *        "patient": {
     *            "id": 3,
     *            "first_name": "Ben",
     *            "middle_name": null,
     *            "last_name": "Patient",
     *            "profile_photo_url": null
     *        },
     *        "labortory": {
     *            "laboratory_name": "Laboratory Name",
     *            "lab_file": null
     *        }
     *    }
     *]
     * @response 200 [
     *    {
     *        "id": 6,
     *        "payout_id": "SL0000006",
     *        "service": "Direct",
     *        "total": 500,
     *        "tax_amount": 100,
     *        "earnings": 500,
     *        "payable_to_vendor": 200,
     *        "pdf_url": null,
     *        "created_at": "2021-02-16 06:25:02 pm",
     *        "patient": {
     *            "id": 3,
     *            "first_name": "Ben",
     *            "middle_name": null,
     *            "last_name": "Patient",
     *            "profile_photo_url": null
     *        },
     *        "doctor": {
     *            "id": 2,
     *            "first_name": "Theophilus",
     *            "middle_name": "Jos",
     *            "last_name": "Simeon",
     *            "profile_photo_url": null
     *        }
     *    },
     *    {
     *        "id": 5,
     *        "payout_id": "SL0000005",
     *        "service": "Direct",
     *        "total": 600,
     *        "tax_amount": 100,
     *        "earnings": 500,
     *        "payable_to_vendor": 300,
     *        "pdf_url": null,
     *        "created_at": "2021-02-16 06:24:50 pm",
     *        "patient": {
     *            "id": 3,
     *            "first_name": "Ben",
     *            "middle_name": null,
     *            "last_name": "Patient",
     *            "profile_photo_url": null
     *        },
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

        $list = Sales::where('type', $request->type)->with('patient:id,first_name,middle_name,last_name');
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
     * Get sales chart data
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string anyone of MED,LAB,DOC
     *
     * @response 200 [
     *    {
     *        "total_amount": 7020,
     *        "earnings": 6560,
     *        "month": "February 2021",
     *        "month_key": "02"
     *    },
     *    {
     *        "total_amount": 1000,
     *        "earnings": 1000,
     *        "month": "May 2021",
     *        "month_key": "05"
     *    },
     *    {
     *        "total_amount": 500,
     *        "earnings": 500,
     *        "month": "April 2021",
     *        "month_key": "04"
     *    },
     *    {
     *        "total_amount": 500,
     *        "earnings": 500,
     *        "month": "March 2021",
     *        "month_key": "03"
     *    }
     *]
     *
     *
     * @response 404 {
     *    "message": "No data found."
     *}
     */
    public function getChartData(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB,DOC',
        ]);

        $list = Sales::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->select(
            \DB::raw('ROUND(sum(total),2) as total_amount'),
            \DB::raw('ROUND(sum(earnings),2) as earnings'),
            \DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"),
            \DB::raw("DATE_FORMAT(created_at,'%m') as month_key")
        )->where('type', $data['type'])->groupBy('month', 'month_key')->get();

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No data found.", 404);
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Get sales list by User id
     *
     * Authorization: "Bearer {access_token}"
     *
     */
    public function listByUserId(Request $request)
    {
        $list = Sales::where('type', 'DOC')->with('patient:id,first_name,middle_name,last_name')->paginate(Sales::$page);
    }
}
