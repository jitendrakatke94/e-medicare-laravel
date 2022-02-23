<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewsRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Reviews;
use App\User;
use Illuminate\Http\Request;

class PatientReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @authenticated
     *
     * @group Reviews
     *
     * Patient Review list
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 21,
     *            "rating": 2,
     *            "title": "very good doctor",
     *            "review": "wait and update",
     *            "created_time": "Reviewed 5 minutes ago",
     *            "doctor": {
     *                "id": 1,
     *                "first_name": "theophilus",
     *                "middle_name": null,
     *                "last_name": "simeon"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/review?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/review?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/review",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     * @response 404 {
     *    "message": "Reviews not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function index()
    {
        $list = Reviews::with('doctor:id,first_name,middle_name,last_name')->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(Reviews::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('Reviews not found', 404);
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
     * @group Reviews
     *
     * Patient Review add
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam to_id integer required id of doctor
     * @bodyParam rating integer required
     * @bodyParam title string required
     * @bodyParam review string nullable
     *
     *
     * @response 200 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "to_id": [
     *            "The to id field is required."
     *        ],
     *        "rating": [
     *            "The rating field is required."
     *        ],
     *        "title": [
     *            "The title field is required."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "Doctor not found"
     *}
     * @response 200 {
     *    "message": "Review added successfully"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function store(ReviewsRequest $request)
    {
        $data = $request->validated();
        $doctor = User::where('user_type', 'DOCTOR')->where('id', $data['to_id'])->first();

        if (!$doctor) {
            return new ErrorMessage('Doctor not found', 404);
        }
        $data['user_id'] = auth()->user()->id;
        Reviews::updateOrCreate([
            'user_id' => auth()->user()->id,
            'to_id' => $data['to_id'],
        ], $data);
        return new SuccessMessage('Review added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @group Reviews
     *
     * Patient Review update
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record

     * @bodyParam rating integer required
     * @bodyParam title string required
     * @bodyParam review string nullable
     *
     *
     * @response 200 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "rating": [
     *            "The rating field is required."
     *        ],
     *        "title": [
     *            "The title field is required."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "Review not found"
     *}
     * @response 200 {
     *    "message": "Review updated successfully"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function update(ReviewsRequest $request, $id)
    {
        try {
            $data = $request->validated();
            Reviews::findOrFail($id)->update($data);
        } catch (\Exception $exception) {
            return new ErrorMessage('Review not found', 404);
        }
        return new SuccessMessage('Review updated successfully');
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
     * @group Reviews
     *
     * Patient Review delete
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "message": "Review deleted successfully"
     *}
     *@response 404 {
     *    "message": "Review not found"
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function destroy($id)
    {
        try {
            Reviews::where('user_id', auth()->user()->id)->findOrFail($id)->destroy($id);
            return new SuccessMessage('Review deleted successfully');
        } catch (\Exception $exception) {
            return new ErrorMessage('Review not found', 404);
        }
    }
}
