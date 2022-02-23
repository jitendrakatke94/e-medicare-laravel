<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\UserCommissions;
use App\User;
use Illuminate\Http\Request;

class UserCommissionsController extends Controller
{
    /**
     * @authenticated
     *
     * @group Admin
     *
     * List UserCommissions
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam search nullable present
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "search": [
     *            "The search field must be present."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 34,
     *            "unique_id": "CO0000033",
     *            "online": 0,
     *            "in_clinic": 0,
     *            "emergency": 0,
     *            "doctorinfo": {
     *                "user_id": 302,
     *                "doctor_unique_id": "D0000065",
     *                "doctor_profile_photo": null,
     *                "average_rating": null
     *            },
     *            "user": {
     *                "id": 302,
     *                "first_name": "Martin",
     *                "middle_name": null,
     *                "last_name": "KIng",
     *                "profile_photo_url": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/user/commission?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/user/commission?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/user/commission",
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
            'search' => 'present|nullable'
        ]);

        $users = User::where('is_active', '1')->where('user_type', 'DOCTOR')->whereDoesntHave('user_commission')->pluck('id');
        foreach ($users as $key => $user_id) {
            UserCommissions::create([
                'unique_id' => getUserCommissionId(),
                'user_id' => $user_id
            ]);
        }

        $lists = UserCommissions::with('doctorinfo:user_id,doctor_unique_id')->with('user:id,first_name,middle_name,last_name')->whereHas('doctorinfo');

        if ($request->filled('search')) {
            if (strpos($request->search, 'D') !== false) {

                $lists = $lists->whereHas('doctorinfo', function ($query) use ($request) {
                    $query->where('doctor_unique_id', $request->search);
                });
            } else {
                $lists = $lists->whereHas('user', function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%');
                    $query->orWhere('middle_name', 'like', '%' . $request->search . '%');
                    $query->orWhere('last_name', 'like', '%' . $request->search . '%');
                    // $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like '%" . $request->search . "%' ");
                });
            }
        }

        $lists = $lists->paginate(UserCommissions::$page);
        if ($lists->count() > 0) {
            return response()->json($lists, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Get UserCommissions by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "id": 34,
     *    "unique_id": "CO0000033",
     *    "online": 0,
     *    "in_clinic": 0,
     *    "emergency": 0,
     *    "doctorinfo": {
     *        "user_id": 302,
     *        "doctor_unique_id": "D0000065",
     *        "doctor_profile_photo": null,
     *        "average_rating": null
     *    },
     *    "user": {
     *        "id": 302,
     *        "first_name": "Martin",
     *        "middle_name": null,
     *        "last_name": "KIng",
     *        "profile_photo_url": null
     *    }
     *}
     * @response 404 {
     *    "message": "UserCommissions not found."
     *}
     */
    public function show($id)
    {
        try {
            $record = UserCommissions::with('doctorinfo:user_id,doctor_unique_id')->with('user:id,first_name,middle_name,last_name')->findOrFail($id);
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('User Commissions not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Edit UserCommissions by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam commission_id id required
     * @bodyParam online numeric required
     * @bodyParam in_clinic numeric required
     * @bodyParam emergency numeric required

     * @response 404 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "commission_id": [
     *            "The commission id field is required."
     *        ],
     *        "online": [
     *            "The online field is required."
     *        ],
     *        "in_clinic": [
     *            "The in clinic field is required."
     *        ],
     *        "emergency": [
     *            "The emergency field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "User Commissions updated successfully."
     *}
     */
    public function update(Request $request)
    {
        $data =  $request->validate([
            'commission_id' => 'required|numeric|exists:user_commissions,id',
            'online' => 'required|numeric',
            'in_clinic' => 'required|numeric',
            'emergency' => 'required|numeric',

        ], [
            'commission_id.exists' => 'Commission id not found.'
        ]);
        UserCommissions::find($request->commission_id)->update($data);
        return new SuccessMessage('User Commissions updated successfully.');
    }
}
