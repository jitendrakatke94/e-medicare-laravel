<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Specializations;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Str;


class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Admin, Employee list specialization
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
     *            "name": "Orthopedician",
     *            "image": "http://localhost/fms-api-laravel/public/storage/uploads/specializations/1625137134-34034151-f758-4743-827b-1d3fbee34063.jpg"
     *        },
     *        {
     *            "id": 2,
     *            "name": "Dermatologist",
     *            "image": "http://localhost/fms-api-laravel/public/storage/uploads/specializations/1625137134-34034151-f758-4743-827b-1d3fbee34063.jpg"
     *        },
     *        {
     *            "id": 3,
     *            "name": "Pediatrician",
     *            "image": "http://localhost/fms-api-laravel/public/storage/uploads/specializations/1625137134-34034151-f758-4743-827b-1d3fbee34063.jpg"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/specialization?page=1",
     *    "from": 1,
     *    "last_page": 8,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/specialization?page=8",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/admin/specialization?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/specialization",
     *    "per_page": 3,
     *    "prev_page_url": null,
     *    "to": 3,
     *    "total": 24
     *}
     * @response 404 {
     *    "message": "Specializations not found"
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);

        if ($request->filled('paginate')) {

            $list = Specializations::all();
        } else {
            $list = Specializations::orderBy('id', 'desc')->paginate(Specializations::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("Specializations not found", 404);
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
     * Admin add specialization
     *
     *Authorization: "Bearer {access_token}"
     *
     * @bodyParam name string required unique
     * @bodyParam image file nullable format-> jpg,jpeg,png max:2048
     *
     * @response 200 {
     *    "message": "Specialization added successfully"
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
            'name' => 'required|string|unique:specializations,name,NULL,id,deleted_at,NULL',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);
        $validatedData['created_by'] = auth()->user()->id;

        if ($request->file('image')) {
            $fileExtension = $request->image->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/specializations';
            $path = $request->file('image')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $validatedData['image'] = $path;
        }

        Specializations::create($validatedData);

        return new SuccessMessage('Specialization added successfully');
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
     * Admin get specialization by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200{
     *    "id": 2,
     *    "name": "Dermatologist"
     *}
     * @response 404 {
     *    "message": "Specialization not found"
     *}
     */
    public function show($id)
    {
        try {
            $record = Specializations::findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Specialization not found', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin edit specialization by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     * @bodyParam name string required unique
     * @bodyParam image file nullable format-> jpg,jpeg,png max:2048
     *
     * @response 404 {
     *    "message": "Specialization not found"
     *}
     * @response 200 {
     *    "message": "Specialization updated successfully"
     *}
     */
    public function update(Request $request, $id)
    {
        $validatedData =  $request->validate([
            'name' => 'required|unique:specializations,name,' . $id . ',id,deleted_at,NULL',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);
        try {

            if ($request->file('image')) {
                $fileExtension = $request->image->extension();
                $uuid = Str::uuid()->toString();
                $folder = 'public/uploads/specializations';
                $path = $request->file('image')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
                $validatedData['image'] = $path;
            }

            $validatedData['updated_by'] = auth()->user()->id;
            Specializations::findOrFail($id)->update($validatedData);
        } catch (\Exception $exception) {

            return new ErrorMessage('Specialization not found', 404);
        }
        return new SuccessMessage('Specialization updated successfully');
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
     * Admin delete specialization by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 404 {
     *    "message": "Specialization not found"
     *}
     * @response 200 {
     *    "message": "Specialization deleted successfully"
     *}
     */
    public function destroy($id)
    {
        try {
            Specializations::findOrFail($id)->destroy($id);
            return new SuccessMessage('Specialization deleted successfully');
        } catch (\Exception $exception) {
            return new ErrorMessage('Specialization not found', 404);
        }
    }
}
