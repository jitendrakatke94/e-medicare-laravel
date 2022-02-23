<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\HealthAssociateRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Address;
use App\Model\Employee;
use App\User;
use Illuminate\Http\Request;

class HealthAssociateController extends Controller
{
    /**
     * @authenticated
     *
     * @group Health Associate
     *
     * Health Associate get profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "id": 4,
     *    "unique_id": "EMP0000004",
     *    "father_first_name": "sdcjsj",
     *    "father_middle_name": null,
     *    "father_last_name": "hdfh",
     *    "date_of_birth": "2020-12-28",
     *    "age": 0,
     *    "date_of_joining": "2021-01-05",
     *    "gender": "MALE",
     *    "user": {
     *        "id": 52,
     *        "first_name": "hjsjda",
     *        "middle_name": null,
     *        "last_name": "nhdhsh",
     *        "email": "krishnan5.ak@gmail.com",
     *        "username": "emp60080cfadb6e9",
     *        "country_code": "+91",
     *        "mobile_number": "8281837600",
     *        "user_type": "HEALTHASSOCIATE",
     *        "is_active": "1",
     *        "role": [
     *            8
     *        ],
     *        "currency_code": null,
     *        "approved_date": "2021-01-21",
     *        "profile_photo_url": null
     *    },
     *    "address": [
     *        {
     *            "id": 65,
     *            "street_name": "d",
     *            "city_village": "q",
     *            "district": "Alappuzha",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "688004",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Details not found."
     *}
     */

    public function getProfile(Request $request)
    {
        try {
            $record = Employee::with('user')->with('address')->where('user_id', auth()->user()->id)->firstOrFail();
        } catch (\Exception $e) {

            return new ErrorMessage('Details not found.', 404);
        }
        return response()->json($record, 200);
    }

    /**
     * @authenticated
     *
     * @group Health Associate
     *
     * Health Associate edit profile details
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     *
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Details updated successfully."
     *}
     */
    public function editProfile(HealthAssociateRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->mobile_number = $request->mobile_number;
        $user->save();
        return new SuccessMessage('Details updated successfully.');
    }
    /**
     * @authenticated
     *
     * @group Health Associate
     *
     * Health Associate edit address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam address_id integer required id from address object
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "address_id": [
     *            "The address id field is required."
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
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Address updated successfully."
     *}
     *
     */
    public function editAddress(HealthAssociateRequest $request)
    {
        $data = $request->validated();
        unset($data['address_id']);
        Address::find($request->address_id)->update($data);
        return new SuccessMessage('Address updated successfully.');
    }
}
