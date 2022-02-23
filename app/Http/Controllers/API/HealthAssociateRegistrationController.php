<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\HealthAssociateRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\SendEmailJob;
use App\Model\Address;
use App\Model\AppOptions;
use App\Model\Employee;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Traits\sendMobileOTPTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Tzsk\Otp\Facades\Otp;
use Str;


class HealthAssociateRegistrationController extends Controller
{
    use sendMobileOTPTrait;

    /**
     * @group Authenticaton and Authorization
     *
     * Health associate Registration - step(1)
     *
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable present
     * @bodyParam last_name string required
     * @bodyParam father_first_name string required
     * @bodyParam father_middle_name string nullable present
     * @bodyParam father_last_name string required
     * @bodyParam gender string required any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth string required format -> Y-m-d
     * @bodyParam age integer required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam resume file nullable File mime:doc,pdf,docx size max 2mb
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "first_name": [
     *            "The first name field is required."
     *        ],
     *        "middle_name": [
     *            "The middle name field must be present."
     *        ],
     *        "last_name": [
     *            "The last name field is required."
     *        ],
     *        "father_first_name": [
     *            "The father first name field is required."
     *        ],
     *        "father_middle_name": [
     *            "The father middle name field must be present."
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
     *        ]
     *    }
     *}
     *
     * @response 200{
     *    "data_id": 1
     *}
     */
    public function basicInfo(HealthAssociateRequest $request)
    {
        $data = $request->validated();

        $resume = NULL;
        if ($request->file('resume')) {
            $fileExtension = $request->resume->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/temp';
            $filePath = $request->file('resume')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $resume = $filePath;
        }
        $data['resume'] = $resume;
        $data['step'] = 1;
        $data['type'] = 'health_associate';
        //$data['date_of_joining'] = now()->format('Y-m-d');
        $appOptions = AppOptions::create(['options' => $data]);
        return response()->json(['data_id' => $appOptions->id], 200);
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Health associate Registration - step(2)
     *
     * @bodyParam data_id integer required data_id returned from step 1
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
     *        "data_id": [
     *            "The data id field is required."
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
     *
     * @response 404{
     *     "message": "data id not found"
     *}
     * @response 200 {
     *    "message": "Email, Mobile OTP has been sent",
     *    "data_id": 3,
     *    "mobile_number": "8940330539",
     *    "email": "theophilus1@logidots.com"
     *}
     * @response 403{
     *     "message": "Email, Mobile OTP already been sent"
     *}
     */
    public function address(HealthAssociateRequest $request)
    {
        $data = $request->validated();
        try {
            $record = AppOptions::whereJsonContains('options', ['step' => 1, 'type' => 'health_associate'])->findOrFail($data['data_id']);

            unset($data['data_id']);
            $data['step'] = 2;
            $info = array_merge($record->options, $data);
            $record->options = $info;

            // now send email and mobile otp
            //for email verification

            $otp_info = getOTP();
            $info['otp_email'] = $otp_info['otp'];
            $info['verified_email'] = NULL;

            // validation key
            $info['email_key'] = $otp_info['key'];

            $message = str_replace('$$$OTPEMAIL$$$', $info['otp_email'], config('emailtext.otp_health_associate_register'));

            SendEmailJob::dispatch(['subject' => config('emailtext.subject_health_associate_register'), 'user_name' => $info['last_name'], 'email' => $info['email'], 'mail_type' => 'otpverification', 'message' => $message]);

            $otp_info = getOTP();
            $info['otp_mobile'] = $otp_info['otp'];
            $info['mobile_key'] = $otp_info['key'];
            $info['verified_mobile'] = NULL;
            $record->options = $info;
            $record->save();
            $mobile_number = $info['country_code'] . $info['mobile_number'];

            //TODO uncomment in production
            //for mobile number verification
            $message = "Welcome to EMedicare, Indian's health passport. Your verification OTP for account registration is " . $info['otp_mobile'] . ".";
            $this->send($mobile_number, $message);

            return response()->json(['message' => 'Email, Mobile OTP has been sent', 'data_id' => $record->id, 'mobile_number' => $info['mobile_number'], 'email' => $info['email']], 200);
        } catch (\Exception $exception) {

            if ($exception->getMessage() == 'No query results for model [App\Model\AppOptions] 1')
                return new ErrorMessage('Email, Mobile OTP already been sent', 403);

            return new ErrorMessage('data id not found', 404);
        }
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Health associate Resend Email OTP
     *
     * @bodyParam email email required
     *
     * @response 200 {
     *      "message": "Email OTP sent successfully"
     * }
     * @response 404 {
     *      "message": "Email not registered"
     * }
     * @response 403 {
     *      "message": "Email already verified"
     * }
     * @response 422 {
     *      "message": "OTP resend failed"
     * }
     * @response 422{
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email": [
     *            "The email field is required."
     *        ]
     *    }
     *}
     * */
    public function ResendEmailOTP(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
        ]);

        $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'step' => 2, 'type' => 'health_associate'])
            ->orderBy('updated_at', 'desc')->first();
        if ($user) {

            if ($user->options['verified_email']) {
                return new ErrorMessage("Email already verified", 403);
            }
            try {
                $otp_info = getOTP();
                $otp_email = $otp_info['otp'];
                $options = $user->options;
                $options['otp_email'] = $otp_email;
                // validation key
                $options['email_key'] = $otp_info['key'];
                $user->options = $options;
                $user->save();

                $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_health_associate_register'));

                SendEmailJob::dispatch(['subject' => config('emailtext.subject_health_associate_register'), 'user_name' => $user->options['last_name'], 'email' => $user->options['email'], 'mail_type' => 'otpverification', 'message' => $message]);

                return new SuccessMessage("Email OTP sent successfully", 200);
            } catch (\Exception $e) {

                return new ErrorMessage("OTP resend failed", 422);
            }
        }
        return new ErrorMessage("Email not registered", 404);
    }
    /**
     * @group Authenticaton and Authorization
     *
     * Health associate Resend Mobile OTP
     *
     * @bodyParam mobile_number string required
     *
     * @response 200 {
     *      "message": "Mobile OTP resent successfully"
     * }
     *
     * @response 404 {
     *      "message": "Mobile number not registered"
     * }
     * @response 403 {
     *      "message": "Mobile number already verified"
     * }
     * @response 422 {
     *      "message": "OTP resend failed"
     * }
     *@response 422{
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ]
     *    }
     *}
     * */

    public function resendMobileOTP(Request $request)
    {
        $validatedData = $request->validate([
            'mobile_number' => 'required',
        ]);

        $user =  AppOptions::whereJsonContains('options', ['mobile_number' => $validatedData['mobile_number'], 'step' => 2, 'type' => 'health_associate'])
            ->orderBy('updated_at', 'desc')->first();
        if ($user) {

            if ($user->options['verified_mobile']) {
                return new ErrorMessage("Mobile number already verified", 403);
            }
            try {
                $options = $user->options;
                //for mobile number verification

                $otp_info = getOTP();
                $otp_mobile = $otp_info['otp'];
                $options = $user->options;
                $options['otp_mobile'] = $otp_mobile;
                // validation key
                $options['mobile_key'] = $otp_info['key'];
                $user->options = $options;
                $user->save();

                $mobile_number = $options['country_code'] . $options['mobile_number'];
                //TODO uncomment in production
                $message = "Welcome to EMedicare, Indian's health passport. Your verification OTP for account registration is " . $options['otp_mobile'] . ".";
                $this->send($mobile_number, $message);
                return new SuccessMessage('Mobile OTP resent successfully', 200);
            } catch (\Exception $e) {
                return new ErrorMessage("OTP resend failed", 422);
            }
        }
        return new ErrorMessage("Mobile number not registered", 404);
    }


    /**
     * @group Authenticaton and Authorization
     *
     * Health associate Verify Mobile and Email OTP
     *
     * @bodyParam mobile_number string required
     * @bodyParam mobile_otp integer required
     * @bodyParam email string required
     * @bodyParam email_otp integer required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "email_otp": [
     *            "The email otp field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "mobile_otp": [
     *            "The mobile otp field is required."
     *        ]
     *    }
     *}
     * @respose 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email": [
     *            "Email not registered"
     *        ],
     *        "mobile_number": [
     *            "Mobile number not registered"
     *        ]
     *    }
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_request": [
     *            "Email verification request not found"
     *        ],
     *        "mobile_request": [
     *            "Mobile number verification request not found"
     *        ]
     *    }
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "mobile_otp": [
     *            "The mobile otp must be 6 digits."
     *        ],
     *        "email_otp": [
     *            "The email otp must be an integer.",
     *            "The email otp must be 6 digits."
     *        ]
     *    }
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_otp": [
     *            "Incorrect Email OTP"
     *        ],
     *        "mobile_otp": [
     *            "Incorrect Mobile number OTP"
     *        ]
     *    }
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_otp": [
     *            "Email OTP expired"
     *        ],
     *        "mobile_otp": [
     *            "Mobile number OTP expired"
     *        ]
     *    }
     *}
     * @response 403 {
     *      "message": "Email and Mobile number already verified"
     * }
     *
     * @response 200 {
     *    "message": "You will receive notification mail once Admin approves registration."
     *}
     */
    public function verifyEmailandMobileOTP(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'email_otp' => 'required|size:6',
            'mobile_number' => 'required',
            'mobile_otp' => 'required|size:6',
        ]);

        $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'mobile_number' => $validatedData['mobile_number'], 'step' => 2, 'type' => 'health_associate'])->orderBy('updated_at', 'desc')->first();

        $errors = new MessageBag();
        try {
            $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'step' => 2, 'type' => 'health_associate'])->orderBy('updated_at', 'desc')->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('email', "Email not registered");
        }

        try {
            $user =  AppOptions::whereJsonContains('options', ['mobile_number' => $validatedData['mobile_number'], 'step' => 2, 'type' => 'health_associate'])->orderBy('updated_at', 'desc')->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('mobile_number', "Mobile number not registered");
        }

        if ($errors->has('email') || $errors->has('mobile_number')) {
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $errors;
            return response()->json($error, 422);
        }

        try {
            $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'mobile_number' => $validatedData['mobile_number'], 'step' => 2, 'type' => 'health_associate'])->orderBy('updated_at', 'desc')->first();
        } catch (\Exception $exception) {
            $error = array();
            $errors = new MessageBag();
            $errors->add('error', "Email and Mobile number doesn't belongs to same user");
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $errors;
            return response()->json($error, 422);
        }

        $options = $user->options;

        //verify email otp
        $messageBag = new MessageBag();
        try {

            if (Otp::digits(6)->expiry(10)->check($validatedData['email_otp'], $user->options['email_key'])) {
                $options['verified_email'] = now();
            } else {
                if (Carbon::now() > Carbon::parse($user->options['verified_email'])->addMinutes(10) && $user->options['email_key'] != null) {
                    $messageBag->add('email_otp', 'Email OTP expired');
                } else {
                    $messageBag->add('email_otp', 'Incorrect Email OTP');
                }
            }
        } catch (\Exception $e) {
            $messageBag->add('email_request', 'Email verification request not found');
        }

        try {

            if (Otp::digits(6)->expiry(10)->check($validatedData['mobile_otp'], $user->options['mobile_key'])) {
                $options['verified_mobile'] = now();
            } else {
                if (Carbon::now() > Carbon::parse($user->options['verified_mobile'])->addMinutes(10) && $user->options['mobile_key'] != null) {
                    $messageBag->add('mobile_otp', 'Mobile number OTP expired');
                } else {
                    $messageBag->add('mobile_otp', 'Incorrect Mobile number OTP');
                }
            }
        } catch (\Exception $e) {
            $messageBag->add('mobile_request', 'Mobile number verification request not found');
        }
        if ($messageBag->has('email_otp') || $messageBag->has('mobile_otp') || $messageBag->has('email_request') || $messageBag->has('mobile_request')) {
            $error = array();
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $messageBag;
            return response()->json($error, 422);
        }

        //save all the details to respective tables

        if (is_null($user->options['verified_email']) && is_null($user->options['verified_mobile'])) {
            $user->options = $options;
            $user->save();
            // make entry in all tables
            //user table
            $data_user['first_name'] = $user->options['first_name'];
            $data_user['middle_name'] = $user->options['middle_name'];
            $data_user['last_name'] = $user->options['last_name'];

            $data_user['email'] = $user->options['email'];
            $data_user['country_code'] = $user->options['country_code'];
            $data_user['mobile_number'] = $user->options['mobile_number'];
            $data_user['password'] = Hash::make(Str::random(8));
            $data_user['username'] = uniqid('emp');

            $data_user['user_type'] = 'HEALTHASSOCIATE';
            $data_user['email_verified_at'] = now();
            $data_user['mobile_number_verified_at'] = now();
            $data_user['role'] = [8];
            $new_user = User::create($data_user);
            // to check user is added by admin
            $new_user->created_by = $new_user->id;
            $new_user->save();
            $role = Role::where('name', 'health_associate')->pluck('id')->toArray();
            $new_user->syncRoles($role);

            //address table
            $data_address['street_name'] = $user->options['street_name'];
            $data_address['city_village'] = $user->options['city_village'];
            $data_address['district'] = $user->options['district'];
            $data_address['state'] = $user->options['state'];
            $data_address['country'] = $user->options['country'];
            $data_address['pincode'] = $user->options['pincode'];
            $data_address['user_id'] = $new_user->id;
            $data_address['created_by'] = $new_user->id;
            $data_address['address_type'] = 'HOME';
            Address::create($data_address);

            $employeeData['user_id'] = $new_user->id;
            $employeeData['unique_id'] = getHealthAssociateId();
            $employeeData['father_first_name'] = $user->options['father_first_name'];
            $employeeData['father_middle_name'] = $user->options['father_middle_name'];
            $employeeData['father_last_name'] = $user->options['father_last_name'];
            $employeeData['gender'] = $user->options['gender'];
            $employeeData['date_of_birth'] = $user->options['date_of_birth'];
            $employeeData['age'] = $user->options['age'];
            //$employeeData['date_of_joining'] = $user->options['date_of_joining'];
            $employeeData['created_by'] = $new_user->id;

            if (Storage::disk('local')->exists($user->options['resume'])) {

                $uuid = Str::uuid()->toString();
                $fileExtension = \File::extension($user->options['resume']);
                $filePath = 'public/uploads/' . $new_user->id . '/' . time() . '-' . $uuid . '.' . $fileExtension;

                Storage::move($user->options['resume'], $filePath);
                $employeeData['resume'] = $filePath;
            }
            Employee::create($employeeData);
        }
        return new SuccessMessage('You will receive notification mail once Admin approves registration.');
    }
}
