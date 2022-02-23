<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaxServiceRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\TaxService;
use Illuminate\Http\Request;

class TaxServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group General
     *
     * List Tax Service
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam paginate nullable integer nullable paginate = 0
     *
     * @response 200 [
     *    {
     *        "id": 7,
     *        "unique_id": "TS0007",
     *        "name": "Lab test Lab",
     *        "taxes": null
     *    },
     *    {
     *        "id": 8,
     *        "unique_id": "TS0008",
     *        "name": "Offline charges",
     *        "taxes": [
     *            "1",
     *            "2"
     *        ]
     *    }
     *]
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 7,
     *            "unique_id": "TS0007",
     *            "name": "Lab test Lab",
     *            "taxes": null
     *        },
     *        {
     *            "id": 8,
     *            "unique_id": "TS0008",
     *            "name": "Offline charges",
     *            "taxes": [
     *                "1",
     *                "2"
     *            ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/taxservice?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/taxservice?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/taxservice",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 8,
     *    "total": 8
     *}
     * @response 404 {
     *    "message": "Tax service not found"
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);

        if ($request->filled('paginate')) {

            $list = TaxService::all();
        } else {
            $list = TaxService::orderBy('id', 'desc')->paginate(TaxService::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("Tax service not found.", 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin add Tax Service
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam name string required unique
     * @bodyParam taxes array nullable
     * @bodyParam taxes.* id required id of tax
     *
     * @response 200 {
     *    "message": "Tax added successfully"
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "taxes": [
     *            "The taxes must be an array."
     *        ]
     *    }
     *}
     */
    public function store(TaxServiceRequest $request)
    {

        $data = $request->validated();
        $data['unique_id'] = getTaxServiceId();
        TaxService::create($data);
        return new SuccessMessage('Tax added successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin edit Tax Service
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam name string required unique
     * @bodyParam taxes array nullable
     * @bodyParam taxes.* id required id of tax
     *
     * @response 200 {
     *    "message": "Tax service updated successfully"
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "taxes": [
     *            "The taxes must be an array."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "Tax service not found"
     *}
     */
    public function update(TaxServiceRequest $request, $id)
    {
        try {
            $data = $request->validated();

            if (empty($data['taxes'])) {
                $data['taxes'] = NULL;
            }

            TaxService::findOrFail($id)->update($data);
        } catch (\Exception $exception) {

            return new ErrorMessage('Tax service not found.', 404);
        }
        return new SuccessMessage('Tax service updated successfully.');
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * List Commission
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
     *            "commission": 2
     *        },
     *        {
     *            "id": 2,
     *            "commission": null
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/taxservice/commission?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/taxservice/commission?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/taxservice/commission",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 7,
     *    "total": 7
     *}
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "commission": 2
     *    },
     *    {
     *        "id": 2,
     *        "commission": null
     *    }
     *]
     */
    public function commisionList(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);

        if ($request->filled('paginate')) {

            $list = TaxService::select('id', 'commission')->orderBy('id', 'desc')->get();
        } else {
            $list = TaxService::select('id', 'commission')->paginate(TaxService::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("Tax service not found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin edit Commission
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of Tax Service id
     * @bodyParam commission numeric required
     *
     * @response 200 {
     *    "message": "Commission updated successfully"
     *}
     * @response 404 {
     *    "message": "Tax service not found"
     *}
     */
    public function commisionUpdate(TaxServiceRequest $request, $id)
    {
        try {
            $data = $request->validated();
            TaxService::findOrFail($id)->update($data);
        } catch (\Exception $exception) {

            return new ErrorMessage('Tax service not found.', 404);
        }
        return new SuccessMessage('Commission updated successfully.');
    }
}
