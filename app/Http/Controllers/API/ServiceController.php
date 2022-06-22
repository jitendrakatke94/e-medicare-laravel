<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Address;
use App\Model\DoctorPersonalInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Model\AppVersions;

class ServiceController extends Controller
{
    /**
     *
     * @authenticated
     *
     * @group General
     *
     * Get Pharamacies, Laboratory based on the given coordinates and distance
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam latitude numeric required latitude
     * @bodyParam longitude numeric required longitude
     * @bodyParam radius numeric required send in meters
     *
     * @reponse 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 4,
     *            "street_name": "East Road",
     *            "city_village": "Edamon",
     *            "district": "Kollam",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "691307",
     *            "distance": 23.642860227950514,
     *            "pharmacy": {
     *                "id": 2,
     *                "pharmacy_name": "Pharmacy Name",
     *                "dl_file": null,
     *                "reg_certificate": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/search/pharmacy?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/search/pharmacy?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/search/pharmacy",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 2,
     *            "street_name": "South Road",
     *            "city_village": "Edamattom",
     *            "district": "Kottayam",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "686575",
     *            "distance": 5.583404514320457,
     *            "laboratory": {
     *                "id": 2,
     *                "laboratory_name": "Laboratory Name",
     *                "lab_file": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/search/laboratory?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/search/laboratory?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/search/laboratory",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 2,
     *    "total": 1
     *}
     */

    public function search(Request $request)
    {
        $request->validate([
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],        'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'radius' => 'required|numeric',
        ]);
        $distance_in_km = $request->radius / 1000; // convert to KM

        if ($request->route()->getName() == 'search.pharmacy') {

            $type = 'PHARMACY';
            $with = 'pharmacy:user_id,id,pharmacy_name';
        } else {
            $type = 'LABORATORY';
            $with = 'laboratory:user_id,id,laboratory_name';
        }
        $list = Address::whereHas('user', function ($query) {
            $query->where('is_active', '1');
        })->with($with)->where('address_type', $type)->selectRaw("id,user_id,street_name,city_village,district,state,country,pincode,
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ) AS distance", [$request->latitude, $request->longitude, $request->latitude])
            ->having("distance", "<", $distance_in_km)
            ->orderBy("distance", 'asc')
            ->paginate(Address::$page);
        return response()->json($list, 200);
    }

    /**
     *
     * @authenticated
     *
     * @group General
     *
     * Get Doctor list for pharmacy and laboratory
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 [
     *    {
     *        "id": 2,
     *        "first_name": "Theophilus",
     *        "last_name": "Simeon",
     *        "middle_name": "Jos",
     *        "profile_photo_url": null
     *    },
     *    {
     *        "id": 31,
     *        "first_name": "Stephen",
     *        "middle_name": "Jos",
     *        "last_name": "Nedumaplly",
     *        "profile_photo_url": null
     *    }
     *]
     *
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listDoctor()
    {
        $list = User::where('is_active', '1')->select('id', 'first_name', 'middle_name', 'last_name')->whereHas('doctor')->get();
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     *
     * @authenticated
     *
     * @group General
     *
     * Geocoding
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam address  string required
     *
     *@response 200 {
     *    "latitude": 8.5847419,
     *    "longitude": 76.8376797
     *}
     *@response 422 {
     *    "message": "Maps API error."
     *}
     *@response 422 {
     *    "message": "The address given is invalid."
     *}
     */
    public function geocoding(Request $request)
    {
        $data = $request->validate([
            'address' => 'required',
        ]);

        $apikey = config('app.google')['maps_key'];
        $addressresponse = json_decode(file_get_contents(
            'https://maps.googleapis.com/maps/api/geocode/json?address=' .
                urlencode(implode(",", [
                    $data['address'] ?? '',
                ])) . '&key=' . $apikey
        ), true);
        try {
            if ($addressresponse['status'] == 'OK') {
                return [
                    'latitude' => isset($addressresponse['results'][0]['geometry']['location']['lat']) ? $addressresponse['results'][0]['geometry']['location']['lat'] : "",
                    'longitude' => isset($addressresponse['results'][0]['geometry']['location']['lng']) ? $addressresponse['results'][0]['geometry']['location']['lng'] : ""
                ];
            } else if ($addressresponse['status'] == 'REQUEST_DENIED') {
                return new ErrorMessage('Maps API error.', 422);
            }
        } catch (\Exception $e) {
            if ($addressresponse['status'] == 'REQUEST_DENIED') {
                return new ErrorMessage('Maps API error.', 422);
            }
            return new ErrorMessage("The address given is invalid.", 422);
        }
    }
    /**
     *
     * @authenticated
     *
     * @group General
     *
     * Reverse Geocoding
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam type string required anyone of CLINIC,LABORATORY,PHARMACY
     * @bodyParam latitude numeric required latitude
     * @bodyParam longitude numeric required longitude
     *
     *@response 200 {
     *  "country": "India",
     *  "state": "Kerala",
     *  "city": "Chalavara",
     *  "postal_code": "679335",
     *  "route": "Unnamed Road",
     *  "county": "Palakkad"
     *}
     *@response 422 {
     *    "message": "Maps API error."
     *}
     *@response 422 {
     *    "message": "The address given is invalid."
     *}
     */
    public function reverseGeocoding(Request $request)
    {
        $data = $request->validate([
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],        'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);
        //facing google map issue so thats why we are return this null values and after we are deploy this project on live server then we have to remove this code
        $geoResult = [];
        $geoResult['country'] = NULL;
        $geoResult['state'] = NULL;
        $geoResult['city'] = NULL;
        $geoResult['postal_code'] = NULL;
        $geoResult['route'] = NULL;

        // return response()->json($geoResult, 200);

        $apikey = config('app.google')['maps_key'];
        $addressresponse = json_decode(file_get_contents(
            'https://maps.googleapis.com/maps/api/geocode/json?latlng=' .
                urlencode(implode(",", [
                    $data['latitude'] ?? '',
                    $data['longitude'] ?? '',
                ])) . '&key=' . $apikey
        ));

        try {
            if ($addressresponse->status == 'OK') {
                $geoResult = [];
                $geoResult['country'] = NULL;
                $geoResult['state'] = NULL;
                $geoResult['city'] = NULL;
                $geoResult['postal_code'] = NULL;
                $geoResult['route'] = NULL;
                foreach ($addressresponse->results as $result) {
                    foreach ($result->address_components as $address) {
                        if (in_array('country', $address->types)) {
                            $geoResult['country'] = $geoResult['country'] ?? $address->long_name;
                        }
                        if (in_array('administrative_area_level_1', $address->types)) {
                            $geoResult['state'] = $geoResult['state'] ?? $address->long_name;
                        }
                        if (in_array('administrative_area_level_2', $address->types)) {
                            $geoResult['county'] = $geoResult['county'] ?? $address->long_name;
                        }
                        if (in_array('locality', $address->types)) {
                            $geoResult['city'] = $geoResult['city'] ?? $address->long_name;
                        }
                        if (in_array('postal_code', $address->types)) {
                            $geoResult['postal_code'] = $geoResult['postal_code'] ?? $address->long_name;
                        }
                        if (in_array('route', $address->types)) {
                            $geoResult['route'] = $geoResult['route'] ?? $address->long_name;
                        }
                    }
                }
                return response()->json($geoResult, 200);
            } else if ($addressresponse->status == 'REQUEST_DENIED') {
                return new ErrorMessage('Maps API error.', 422);
            }
        } catch (\Exception $e) {
            if ($addressresponse['status'] == 'REQUEST_DENIED') {
                return new ErrorMessage('Maps API error.', 422);
            }
            return new ErrorMessage("The address given is invalid.", 404);
        }
    }
    /**
     * @authenticated
     *
     * @group General
     *
     * Add profile photo
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam profile_photo file nullable File mime:jpg,jpeg,png size max 2mb
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "profile_photo": [
     *            "The profile photo field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Profile photo updated successfully."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function addProfilePhoto(Request $request)
    {
        $data = $request->validate([
            'profile_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        //upload profile_photo is found
        if ($request->file('profile_photo')) {
            $fileExtension = $request->profile_photo->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/' . auth()->user()->id;
            $filePath = $request->file('profile_photo')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            User::where('id', auth()->user()->id)->update(['profile_photo' => $filePath]);
        }
        return new SuccessMessage('Profile photo updated successfully.');
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Validate Address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country_code string nullable required if contact_number is filled
     * @bodyParam latitude double required
     * @bodyParam longitude double required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
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
     *        ],
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": true
     *}
     *@response 200 {
     *    "message": false
     *}
     *@response 422 {
     *    "message": "The address given is invalid."
     *}
     *
     *@response 422 {
     *    "message": "Maps API error."
     *}
     *@response 422 {
     *    "message": "The address given is invalid."
     *}
     */
    public function validateAddress(Request $request)
    {
        $data = $request->validate([
            'pincode' => 'required|digits:6',
            'street_name'  => 'required|string',
            'city_village'  => 'required|string',
            'district'   => 'required|string',
            'state'   => 'required|string',
            'country' => 'required|string',
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],  'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
        ]);

        $apikey = config('app.google')['maps_key'];
        $addressresponse = json_decode(file_get_contents(
            'https://maps.googleapis.com/maps/api/geocode/json?address=' .
                urlencode(implode(",", [
                    $data['street_name'] ?? '',
                    $data['city_village'] ?? '',
                    $data['district'] ?? '',
                    $data['state'] ?? '',
                    $data['pincode'] ?? '',
                    $data['country']
                ])) . '&key=' . $apikey
        ), true);

        try {
            if ($addressresponse['status'] == 'OK') {
                $latitude = isset($addressresponse['results'][0]['geometry']['location']['lat']) ? $addressresponse['results'][0]['geometry']['location']['lat'] : "";
                $longitude = isset($addressresponse['results'][0]['geometry']['location']['lng']) ? $addressresponse['results'][0]['geometry']['location']['lng'] : "";

                if (!empty($latitude) && !empty($longitude)) {
                    $distance = $this->getDistance($latitude, $longitude, $data['latitude'], $data['longitude']);

                    if ($distance <= 10) {
                        return new SuccessMessage(true);
                    } else {
                        return new SuccessMessage(false);
                    }
                }
                return new ErrorMessage("The address given is invalid.", 422);
            } else if ($addressresponse['status'] == 'REQUEST_DENIED') {
                return new ErrorMessage('Maps API error.', 422);
            }
        } catch (\Exception $e) {

            if ($addressresponse['status'] == 'REQUEST_DENIED') {
                return new ErrorMessage('Maps API error.', 422);
            }
        }
        return new ErrorMessage("The address given is invalid.", 422);
    }

    function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }

    public function getAppVersion() {
        $app_version = AppVersions::where('is_force_update', 1)->orderBy('id', 'desc')->first();
        return response()->json($app_version, 200);
    }
}
