<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Service;
use Illuminate\Http\Request;

//TODO delete
class ServiceController extends Controller
{

    /**
     *
     * @group Admin Lab test, Medicine
     *
     * Admin,Doctor,pharmacy,laboratory List Laboratory tests, Medicine
     *
     * @queryParam type required string any one of LAB,MED. Lab will give list of Test available, MED will give list of medicine available with pagination if paginate param is inclued in request.
     * @queryParam paginate integer nullable paginate = 0
     *
     * @response 200 [
     *    {
     *        "id": 2,
     *        "name": "Chloroform",
     *        "unique_id": "MED0000002",
     *        "code": null,
     *        "image": null
     *    },
     *    {
     *        "id": 3,
     *        "name": "Chloroform1",
     *        "unique_id": "MED0000003",
     *        "code": null,
     *        "image": null
     *    }
     *]
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "name": "Chloroform",
     *            "unique_id": "LAB0000001",
     *            "code": null,
     *            "image": null
     *        },
     *        {
     *            "id": 4,
     *            "name": "Chloroform1",
     *            "unique_id": "LAB0000004",
     *            "code": null,
     *            "image": null
     *        },
     *        {
     *            "id": 5,
     *            "name": "Tiger pill",
     *            "unique_id": "LAB0000005",
     *            "code": null,
     *            "image": "http://localhost/fms-api-laravel/public/storage/uploads/labmedimages/1605181925tiger.jpg"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/service?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/service?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/service",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 3,
     *    "total": 3
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'required|in:LAB,MED',
            'paginate' => 'nullable|in:0',
        ]);
        if ($request->filled('paginate')) {
            $list = Service::where('type', $request->type)->orderBy('id', 'desc')->get();
        } else {
            $list = Service::where('type', $request->type)->orderBy('id', 'desc')->paginate(Service::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Admin Lab test, Medicine
     *
     * Admin add Laboratory tests , Medicine
     *
     * @bodyParam name string required
     * @bodyParam type string required any one of LAB,MED
     * @bodyParam image file nullable mimes:jpg,jpeg,png max:2mb
     * @bodyParam code string nullable
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "type": [
     *            "The type field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Saved successfully."
     *}
     */
    public function store(Request $request)
    {

        $validatedData =  $request->validate([
            'name' => 'required|unique:services,name,NULL,id,deleted_at,NULL,type,' . $request->type,
            'type' => 'required|in:LAB,MED',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'code' => 'nullable|string'
        ]);

        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/labmedimages';
            $filePath = $request->file('image')->storeAs($folder, time() . $fileName);
            $validatedData['image_path'] = $filePath;
        }

        $validatedData['created_by'] = auth()->user()->id;
        $validatedData['unique_id'] = getServicesId($request->type);
        Service::create($validatedData);

        return new SuccessMessage('Saved successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin Lab test, Medicine
     *
     * Admin update Laboratory tests , Medicine
     *
     * @queryParam id required integer id of record
     * @bodyParam type string required any one of LAB,MED
     * @bodyParam name string required
     *
     * @response 404 {
     *    "message": "Record not found."
     *}
     * @response 200 {
     *    "message": "Record updated successfully."
     *}
     */
    public function update(Request $request, $id)
    {
        $validatedData =  $request->validate([
            'name' => 'required|unique:services,name,' . $id . ',id,deleted_at,NULL,type,' . $request->type,
            'type' => 'required|in:LAB,MED',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'code' => 'nullable|string'
        ]);
        try {
            $service = Service::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }

        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/labmedimages';
            $filePath = $request->file('image')->storeAs($folder, time() . $fileName);
            $validatedData['image_path'] = $filePath;
        }
        $validatedData['updated_by'] = auth()->user()->id;
        $service->update($validatedData);
        return new SuccessMessage('Record updated successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin Lab test, Medicine
     *
     * Admin delete Laboratory tests , Medicine
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 404 {
     *    "message": "Record not found."
     *}
     * @response 200 {
     *    "message": "Record deleted successfully."
     *}
     */
    public function destroy($id)
    {
        try {
            Service::findOrFail($id)->destroy($id);
            return new SuccessMessage('Record deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Admin Lab test, Medicine
     *
     * Admin get Laboratory tests , Medicine by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "id": 1,
     *    "name": "Chloroform",
     *    "unique_id": "LAB0000001",
     *    "code": null,
     *    "image": null
     *}
     * @response 404 {
     *    "message": "Record not found."
     *}
     */
    public function show($id)
    {
        try {
            $record = Service::findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }
}
