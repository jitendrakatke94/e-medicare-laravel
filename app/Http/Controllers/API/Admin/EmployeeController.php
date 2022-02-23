<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\SendEmailJob;
use App\Model\Address;
use App\Model\Employee;
use App\Model\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;
use App\Traits\sendMobileOTPTrait;


class EmployeeController extends Controller
{
    use sendMobileOTPTrait;

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin add employee - BasicInfo
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam father_first_name string required
     * @bodyParam father_middle_name string nullable
     * @bodyParam father_last_name string required
     * @bodyParam gender string required any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth string required format -> Y-m-d
     * @bodyParam age integer required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam date_of_joining string nullable format -> Y-m-d
     * @bodyParam role array required
     * @bodyParam role.* interger required id of role
     *
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "first_name": [
     *            "The first name field is required."
     *        ],
     *        "last_name": [
     *            "The last name field is required."
     *        ],
     *        "father_first_name": [
     *            "The father first name field is required."
     *        ],
     *        "father_last_name": [
     *            "The father last name field is required."
     *        ],
     *        "gender": [
     *            "The gender field is required."
     *        ],
     *        "date_of_birth": [
     *            "The date of birth field is required."
     *        ],
     *        "age": [
     *            "The age field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "role": [
     *            "The role must be a array."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "user_id": 1
     *}
     * @response 422 {
     *    "message": "Something went wrong."
     *}
     */
    public function employeeBasicInfo(EmployeeRequest $request)
    {
        \DB::beginTransaction();
        try {
            $userData = $employeeData = array();
            $role = Role::whereIn('id', $request->role)->pluck('name')->toArray();
            // to get user_type
            $role_name = strtoupper(str_replace('_', '', $role[0]));

            $userData['first_name'] = $request->first_name;
            $userData['middle_name'] = $request->middle_name;
            $userData['last_name'] = $request->last_name;
            $userData['email'] = $request->email;
            $userData['country_code'] = $request->country_code;
            $userData['mobile_number'] = $request->mobile_number;
            $userData['role'] = $request->role;
            $password = Str::random(8);
            $userData['password'] = Hash::make($password);
            $userData['username'] = uniqid('emp');
            $userData['user_type'] = $role_name;
            $userData['is_active'] = '1';

            $message = $subject = '';
            if ($role_name == 'EMPLOYEE') {

                $userData['email_verified_at'] = now();
                $userData['mobile_number_verified_at'] = now();
                $employeeData['unique_id'] = getEmployeeId();

                $subject = config('emailtext.profile_activation_subject');
                $message = config('emailtext.profile_activation_mail') . config('emailtext.login_credentials');
            } else if ($role_name == 'HEALTHASSOCIATE') {
                $employeeData['unique_id'] = getHealthAssociateId();
                $subject = config('emailtext.health_associate_account_activation_subject');
                $message = config('emailtext.health_associate_account_activation_mail') . config('emailtext.login_credentials');
            } else {
                $subject = config('emailtext.profile_activation_subject');
                $message = config('emailtext.profile_activation_mail') . config('emailtext.login_credentials');
            }

            $user =  User::create($userData);
            $user->syncRoles($role);

            $employeeData['user_id'] = $user->id;

            $employeeData['father_first_name'] = $request->father_first_name;
            $employeeData['father_middle_name'] = $request->father_middle_name;
            $employeeData['father_last_name'] = $request->father_last_name;
            $employeeData['gender'] = $request->gender;
            $employeeData['date_of_birth'] = $request->date_of_birth;
            $employeeData['age'] = $request->age;
            if ($request->filled('date_of_joining')) {
                $employeeData['date_of_joining'] = $request->date_of_joining;
            }
            $employeeData['created_by'] = auth()->user()->id;
            Employee::create($employeeData);

            $send_user_name = $userData['email'];
            $send_password = $password;

            $message = str_replace('$$$USERNAME$$$', $send_user_name, $message);
            $message = str_replace('$$$PASSWORD$$$', $send_password, $message);

            SendEmailJob::dispatch(['subject' => $subject, 'user_name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            //EMAIL CODE

            //TODO uncomment in production
            $sms = "Welcome to EMedicare, Indian's health passport. Login with Username: " . $send_user_name . " and Password: " . $send_password . ".";
            //$this->send($user->country_code . $user->mobile_number, $sms);
            \DB::commit();

            return response()->json(['user_id' => $user->id], 200);
        } catch (\Exception $exception) {
            \DB::rollBack();
            \Log::debug('EmployeeController.php employeeBasicInfo', ['EXCEPTION' => $exception->getMessage()]);
            return new ErrorMessage('Something went wrong.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin add employee - Address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam user_id integer required
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
     *        "user_id": [
     *            "The user id field is required."
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
     * @response 200 {
     *    "message": "Address added successfully."
     *}
     * @response 403 {
     *    "message": "Employee not found."
     *}
     */
    public function employeeAddress(EmployeeRequest $request)
    {

        $data = $request->validated();
        try {
            Employee::where('user_id', $data['user_id'])->has('user')->firstOrFail();
        } catch (\Exception $exception) {
            return new ErrorMessage('Employee not found.', 403);
        }
        $data['address_type'] = 'HOME';
        $data['user_id'] = $data['user_id'];
        $data['created_by'] = auth()->user()->id;
        Address::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'address_type' => $data['address_type'],
            ],
            $data
        );
        return new SuccessMessage('Address added successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin get employee details by id
     *
     * @queryParam id integer required id in user object
     *
     * @response 200 {
     *    "id": 3,
     *    "unique_id": "EMP0000003",
     *    "father_first_name": "dad",
     *    "father_middle_name": "dad midle",
     *    "father_last_name": "dad last",
     *    "date_of_birth": "1995-10-10",
     *    "age": 25,
     *    "date_of_joining": "2020-10-10",
     *    "gender": "MALE",
     *    "user": {
     *        "id": 33,
     *        "first_name": "Employee",
     *        "middle_name": "middle",
     *        "last_name": "last",
     *        "email": "employee@logidots",
     *        "username": "Emp5f9c0972bf270",
     *        "country_code": "+91",
     *        "mobile_number": "9876543288",
     *        "user_type": "EMPLOYEE",
     *        "is_active": "0",
     *        "profile_photo_url": null
     *    },
     *    "address": [
     *        {
     *            "id": 75,
     *            "street_name": "Lane",
     *            "city_village": "land",
     *            "district": "CA",
     *            "state": "KL",
     *            "country": "IN",
     *            "pincode": "654321",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": null,
     *            "longitude": null,
     *            "clinic_name": null
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Employee not found."
     *}
     */

    public function getEmployeeProfile($id)
    {
        try {
            $record = Employee::with('user')->has('user')->with('address')->where('user_id', $id)->firstOrFail();
        } catch (\Exception $e) {
            return new ErrorMessage('Employee not found.', 404);
        }
        return response()->json($record, 200);
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin deactivate employee
     *
     * @queryParam id integer required id in user object
     *
     * @response 200 {
     *    "message": "Employee deactivated."
     *}
     * @response 404 {
     *    "message": "Employee not found."
     *}
     */
    public function deactivateEmployee($id)
    {
        try {
            $record = User::findOrFail($id);
            $record->is_active = '2';
            $record->save();
            return new SuccessMessage('Employee deactivated.');
        } catch (\Exception $e) {
            return new ErrorMessage('Employee not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin edit employee BasicInfo
     *
     * @queryParam id integer required id in user object
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam father_first_name string required
     * @bodyParam father_middle_name string nullable
     * @bodyParam father_last_name string required
     * @bodyParam gender string required any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth string required format -> Y-m-d
     * @bodyParam age integer required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam date_of_joining string nullable format -> Y-m-d
     * @bodyParam role array required
     * @bodyParam role.* interger required id of role
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "first_name": [
     *            "The first name field is required."
     *        ],
     *        "last_name": [
     *            "The last name field is required."
     *        ],
     *        "father_first_name": [
     *            "The father first name field is required."
     *        ],
     *        "father_last_name": [
     *            "The father last name field is required."
     *        ],
     *        "gender": [
     *            "The gender field is required."
     *        ],
     *        "date_of_birth": [
     *            "The date of birth field is required."
     *        ],
     *        "age": [
     *            "The age field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "role": [
     *            "The role must be a array."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Details saved successfully."
     *}
     */
    public function editEmployeeBasicInfo($id, EmployeeRequest $request)
    {
        try {
            $employee = Employee::where('user_id', $id)->with('user')->has('user')->firstOrFail();
        } catch (\Exception $e) {

            return new ErrorMessage('Employee not found.', 404);
        }

        //send notification if email is changed
        $user = User::find($id);

        if ($user->email != $request->email) {

            $message = "Your email has been changed to  " . $request->email . " by Admin.";
            SendEmailJob::dispatch(['user_name' => $user->last_name, 'email' => $user->email, 'mail_type' => 'notification', 'message' => $message]);
        }
        $userData = $employeeData = array();

        $userData['first_name'] = $request->first_name;
        $userData['middle_name'] = $request->middle_name;
        $userData['last_name'] = $request->last_name;
        $userData['email'] = $request->email;
        $userData['country_code'] = $request->country_code;
        $userData['mobile_number'] = $request->mobile_number;
        $userData['role'] = $request->role;
        $employee->user()->update($userData);
        $role = Role::whereIn('id', $request->role)->pluck('name');

        $user->syncRoles($role);

        $employeeData['father_first_name'] = $request->father_first_name;
        $employeeData['father_middle_name'] = $request->father_middle_name;
        $employeeData['father_last_name'] = $request->father_last_name;
        $employeeData['gender'] = $request->gender;
        $employeeData['date_of_birth'] = $request->date_of_birth;
        $employeeData['age'] = $request->age;
        if ($request->filled('date_of_joining')) {
            $employeeData['date_of_joining'] = $request->date_of_joining;
        }
        $employeeData['updated_by'] = auth()->user()->id;
        $employee->update($employeeData);

        return new SuccessMessage('Details saved successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin edit employee - Address
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id integer required id in user object
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
     * @response 200 {
     *    "message": "Address updated successfully."
     *}
     * @response 403 {
     *    "message": "Employee not found."
     *}
     */
    public function editEmployeeAddress($id, EmployeeRequest $request)
    {
        $data = $request->validated();
        try {
            Employee::where('user_id', $id)->has('user')->firstOrFail();
        } catch (\Exception $exception) {
            return new ErrorMessage('Employee not found.', 403);
        }

        $data['updated_by'] = auth()->user()->id;
        $data['user_id'] = $id;
        $data['address_type'] = 'HOME';
        Address::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'address_type' => $data['address_type'],
            ],
            $data
        );
        return new SuccessMessage('Address updated successfully.');
    }
}
