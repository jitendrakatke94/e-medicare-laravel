<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\LabTest;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    /**
     *
     * @group Lab test
     *
     * List Laboratory tests
     *
     * @queryParam paginate integer nullable paginate = 0
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "name": "Eco",
     *        "unique_id": "LAT0000001",
     *        "price": 300,
     *        "currency_code": "INR",
     *        "code": "ECO",
     *        "image": "http://localhost/fms-api-laravel/public/storage/uploads/labtest/1608825075tiger.jpg"
     *    }
     *]
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "name": "Eco",
     *            "unique_id": "LAT0000001",
     *            "price": 300,
     *            "currency_code": "INR",
     *            "code": "ECO",
     *            "image": "http://localhost/fms-api-laravel/public/storage/uploads/labtest/1608825075tiger.jpg"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/guest/labtest?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/guest/labtest?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/guest/labtest",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);
        if ($request->filled('paginate')) {
            $list = LabTest::all();
        } else {
            $list = LabTest::orderBy('id', 'desc')->paginate(LabTest::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Lab test
     *
     * Admin add Laboratory test
     *
     * @bodyParam name string required
     * @bodyParam image file nullable mimes:jpg,jpeg,png max:2mb
     * @bodyParam code string nullable
     * @bodyParam price float required
     * @bodyParam currency_code string nullable
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "price": [
     *            "The price field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Saved successfully."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name has already been taken."
     *        ]
     *    }
     *}
     */
    public function store(Request $request)
    {

        $validatedData =  $request->validate([
            'name' => 'required|unique:lab_tests,name,NULL,id,deleted_at,NULL',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'code' => 'nullable|string',
            'price' => 'required|numeric',
            'currency_code' => 'nullable|string',
            'short_disc'=> 'nullable|string'
        ]);

        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/labtest';
            $filePath = $request->file('image')->storeAs($folder, time() . $fileName);
            $validatedData['image_path'] = $filePath;
        }

        $validatedData['created_by'] = auth()->user()->id;
        $validatedData['unique_id'] = getLabTestId();
        LabTest::create($validatedData);

        return new SuccessMessage('Saved successfully.');
    }

    /**
     * @authenticated
     *
     * @group Lab test
     *
     * Admin update Laboratory test
     *
     * @queryParam id required integer id of record
     * @bodyParam name string required
     * @bodyParam price float required
     * @bodyParam currency_code string nullable
     * @bodyParam image file nullable mimes:jpg,jpeg,png max:2mb
     * @bodyParam code string nullable
     *
     * @response 404 {
     *    "message": "Record not found."
     *}
     * @response 200 {
     *    "message": "Record updated successfully."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name has already been taken."
     *        ]
     *    }
     *}
     */
    public function update(Request $request, $id)
    {
        $validatedData =  $request->validate([
            'name' => 'required|unique:lab_tests,name,' . $id . ',id,deleted_at,NULL',
            'price' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'code' => 'nullable|string',
            'currency_code' => 'nullable|string',
            'short_disc'=> 'nullable|string'
        ]);
        try {
            $labTest = LabTest::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }

        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/labtest';
            $filePath = $request->file('image')->storeAs($folder, time() . $fileName);
            $validatedData['image_path'] = $filePath;
        }
        $validatedData['updated_by'] = auth()->user()->id;
        $labTest->update($validatedData);
        return $labTest;
        return new SuccessMessage('Record updated successfully.');
    }

    /**
     * @authenticated
     *
     * @group Lab test
     *
     * Admin delete Laboratory test
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
            LabTest::findOrFail($id)->destroy($id);
            return new SuccessMessage('Record deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Lab test
     *
     * Admin get Laboratory test by id
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
            $record = LabTest::findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }

    /**
     *
     * @group Lab test
     *
     * Search Laboratory tests
     *
     * @queryParam paginate integer nullable paginate = 0
     * @queryParam name nullable string
     *
     */
    public function search(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'paginate' => 'nullable|in:0',
        ]);
        $labTest = LabTest::where(function ($query) use ($request) {
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
        });
        if ($request->filled('paginate')) {
            $labTest = $labTest->get();
        } else {
            $labTest = $labTest->orderBy('id', 'desc')->paginate(LabTest::$page);
        }

        if ($labTest->count() > 0) {
            return response()->json($labTest, 200);
        }
        return new ErrorMessage('Records not found.', 404);
    }
}
