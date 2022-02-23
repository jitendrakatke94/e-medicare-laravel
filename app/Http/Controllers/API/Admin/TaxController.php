<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Tax;
use App\Model\TaxService;
use Illuminate\Http\Request;

class TaxController extends Controller
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
     * List Taxes
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam paginate nullable integer nullable paginate = 0
     *
     * @reponse 200 [
     *    {
     *        "id": 1,
     *        "name": "GST",
     *        "percent": 18
     *    },
     *    {
     *        "id": 2,
     *        "name": "SGST",
     *        "percent": 9
     *    },
     *    {
     *        "id": 3,
     *        "name": "CGST",
     *        "percent": 9
     *    }
     *]
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "name": "GST",
     *            "percent": 18
     *        },
     *        {
     *            "id": 2,
     *            "name": "SGST",
     *            "percent": 9
     *        },
     *        {
     *            "id": 3,
     *            "name": "CGST",
     *            "percent": 9
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/tax?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/tax?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/tax",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 3,
     *    "total": 3
     *}
     * @response 404 {
     *    "message": "Taxes not found."
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);

        if ($request->filled('paginate')) {

            $list = Tax::all();
        } else {
            $list = Tax::orderBy('id', 'desc')->paginate(Tax::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("Taxes not found.", 404);
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
     * Admin add Tax
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam name string required unique
     * @bodyParam percent numeric required
     *
     * @response 200 {
     *    "message": "Tax added successfully."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "percent": [
     *            "The percent must be a number."
     *        ]
     *    }
     *}
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'name' => 'required|string|unique:taxes,name,NULL,id,deleted_at,NULL',
            'percent' => 'required|numeric'
        ]);
        $validatedData['created_by'] = auth()->user()->id;
        Tax::create($validatedData);

        return new SuccessMessage('Tax added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin get Tax by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "id": 1,
     *    "name": "GST",
     *    "percent": 9
     *}
     * @response 404 {
     *    "message": "Tax not found."
     *}
     */
    public function show($id)
    {

        try {
            $record = Tax::findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Tax not found.', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * Admin edit Tax by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam name string required unique
     * @bodyParam percent numeric required
     *
     * @response 404 {
     *    "message": "Tax not found."
     *}
     * @response 200 {
     *    "message": "Tax updated successfully."
     *}
     */
    public function update(Request $request, $id)
    {
        $validatedData =  $request->validate([
            'name' => 'required|unique:taxes,name,' . $id . ',id,deleted_at,NULL', 'percent' => 'required|numeric'

        ]);
        try {
            $validatedData['updated_by'] = auth()->user()->id;
            Tax::findOrFail($id)->update($validatedData);
        } catch (\Exception $exception) {

            return new ErrorMessage('Tax not found.', 404);
        }
        return new SuccessMessage('Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin delete Tax by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 404 {
     *    "message": "Tax not found."
     *}
     * @response 200 {
     *    "message": "Tax deleted successfully."
     *}
     * @response 403 {
     *    "message": "Tax can't be deleted."
     *}
     */
    public function destroy($id)
    {
        try {

            $tax = Tax::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Tax not found.', 404);
        }
        $tax_services = TaxService::all();
        foreach ($tax_services as $key => $tax_service) {

            if (is_array($tax_service->taxes) && in_array($id, $tax_service->taxes)) {
                return new ErrorMessage('Tax can\'t be deleted.', 403);
            }
        }
        $tax->destroy($id);
        return new SuccessMessage('Tax deleted successfully.');
    }
}
