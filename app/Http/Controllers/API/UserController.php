<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\EcommerceRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\SendEmailJob;
use App\Model\OTPVerifications;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Tzsk\Otp\Facades\Otp;
use App\Traits\sendMobileOTPTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Client as PasswordGrantClient;


class UserController extends Controller
{
    use sendMobileOTPTrait;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Register User
     *
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam username string required unique max 15 chars min 4 chars
     * @bodyParam user_type string required any one of ['PATIENT','DOCTOR']
     * @bodyParam login_type string required any one of ['WEB', 'FACEBOOK', 'GOOGLE']
     *
     * @response 422{
     *   "message": "The given data was invalid.",
     *   "errors": {
     *       "first_name": [
     *           "The first name field is required."
     *       ],
     *       "middle_name": [
     *           "The middle name field is required."
     *       ],
     *       "last_name": [
     *           "The last name field is required."
     *       ],
     *       "password": [
     *           "The password field is required."
     *       ],
     *       "country_code": [
     *           "The country code field is required."
     *       ],
     *       "mobile_number": [
     *           "The mobile number field is required."
     *       ],
     *       "email": [
     *           "The email field is required."
     *       ],
     *        "username": [
     *            "The username has already been taken."
     *       ],
     *      "user_type": [
     *           "The user type field is required."
     *       ],
     *      "login_type": [
     *           "The login type field is required."
     *       ]
     *   }
     * }
     * @response 422 {
     *   "message": "The given data was invalid.",
     *      "errors": {
     *          "mobile_number": [
     *              "The mobile number has already been taken."
     *          ],
     *          "email": [
     *              "The email has already been taken."
     *          ]
     *   }
     * }
     * @response 200 {
     *      "message": "Email, Mobile OTP has been sent",
     *      "user_id": 2,
     *      "mobile_number": "+918610025593",
     *      "email": "theophilus1@logidots.com"
     *  }
     * @response 422 {
     *      "message": "OTP sending failed"
     * }
     */
    public function register(UserRegisterRequest $request)
    {
        $send_email_otp = false;
        $send_mobile_otp = false;
        $message_email = '';
        $message_mobile = '';
        // after validation create a user
        $user = $this->user->create($request->validated());
        try {
            //google and facebook register code begin
            if ($request->login_type == 'GOOGLE' || $request->login_type == 'FACEBOOK') {

                $send_mobile_otp = true;
                $user->markEmailAsVerified();
            } else {
                $send_email_otp = true;
                $send_mobile_otp = true;
            }
            //google and facebook register code end
            //for email verification
            if ($send_email_otp) {
                $otp_email = $this->initiateOTP($user, 'EMAILOTP');

                $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_message'));
                SendEmailJob::dispatch(['subject' => config('emailtext.otp_subject'), 'user_name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);

                $message_email = 'Email, ';
            }

            //for mobile number verification
            if ($send_mobile_otp) {

                $otp_mobile = $this->initiateOTP($user, 'MOBILEOTP');
                $mobile_number = $user->country_code . $user->mobile_number;
                $message = "Welcome to EMedicare, Indian's health passport. Your verification OTP for account registration is " . $otp_mobile . ".";
                $this->send($mobile_number, $message);
                $message_mobile = 'Mobile';
            }
            return response()->json(['message' => $message_email . $message_mobile . ' OTP has been sent', 'user_id' => $user->id, 'mobile_number' => $user->mobile_number, 'email' => $user->email], 200);
        } catch (\Exception $e) {
            return new ErrorMessage("OTP sending failed", 422);
        }
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Ecommerce Register User
     *
     * @bodyParam first_name string required
     * @bodyParam last_name string required
     * @bodyParam password string required
     * @bodyParam email string required
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
     *        "password": [
     *            "The password field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ]
     *    }
     *}
     * @response {
     *    "message": "Email OTP has been sent",
     *    "user_id": 53,
     *    "email": "theo@gmail.com"
     *}
     */
    public function registerEcommerce(EcommerceRequest $request)
    {
        $data = $request->validated();
        $data['user_type'] = 'PATIENT';
        $data['username'] = uniqid('pa');
        $data['login_type'] = 'ECOMMERCE';

        $user = $this->user->create($data);

        $otp_email = $this->initiateOTP($user, 'EMAILOTP');

        $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_message'));
        SendEmailJob::dispatch(['subject' => config('emailtext.otp_subject'), 'user_name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);


        return response()->json(['message' => 'Email OTP has been sent', 'user_id' => $user->id, 'email' => $user->email], 200);
    }

    /**
     *  function to initiate OTP request
     *
     * @param [type] $user
     * @param [type] $type
     * @return string
     */
    public function initiateOTP($user, $type)
    {
        $key = mt_rand(100000, 999999);
        $otp = Otp::digits(6)->expiry(10)->generate($key);
        $user->fillVerificationCode($user->id, $otp, $key, $type);
        return $otp;
    }

    /**
     * @group Authenticaton and Authorization
     * Resend Email OTP
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
        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {
            if ($user->hasVerifiedEmail()) {
                return new ErrorMessage("Email already verified", 403);
            }
            try {
                $otp_email = $this->initiateOTP($user, 'EMAILOTP');

                $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_message'));
                SendEmailJob::dispatch(['subject' => config('emailtext.otp_subject'), 'user_name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
                
                return new SuccessMessage("Email OTP sent successfully" , 200);
            } catch (\Exception $e) {
                return new ErrorMessage("OTP resend failed", 422);
            }
        }
        return new ErrorMessage("Email not registered", 404);
    }
    /**
     * @group Authenticaton and Authorization
     * Resend Mobile OTP
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
        $request->validate([
            'mobile_number' => 'required',
        ]);

        $user = User::where('mobile_number', $request->mobile_number)->first();
        if ($user) {

            if ($user->hasVerifiedMobileNumber()) {
                return new ErrorMessage("Mobile number already verified", 403);
            }
            try {
                //for mobile number verification
                $otp_mobile = $this->initiateOTP($user, 'MOBILEOTP');
                $mobile_number = $user->country_code . $user->mobile_number;
                $message = "Welcome to EMedicare, Indian's health passport. Your verification OTP for account registration is " . $otp_mobile . ".";
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
     * Verify Email OTP
     *
     * @bodyParam email email required
     * @bodyParam email_otp integer required

     * @response 200 {
     *    "token_type": "Bearer",
     *    "expires_in": 31536000,
     *    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmI4YWIyM2Q0YWQ5MzdiMWJlOGNj",
     *    "refresh_token":null,
     *    "first_name": "theo",
     *    "middle_name": "Heart",
     *    "last_name": "lineee",
     *    "email": "theophilus@logidots.com",
     *    "user_type": "DOCTOR",
     *    "first_login": 1,
     *    "current_user_id": 2,
     *    "currency_code": "EUR",
     *    "is_active": "3",
     *    "profile_photo": "http://localhost/fms-api-laravel/public/storage/uploads/1/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
     *    "roles": [
     *        "patient"
     *    ]
     *}
     * @response 403 {
     *      "message": "Email already verified"
     * }
     * @response 422 {
     *      "message": "Email OTP expired"
     * }
     * @response 422 {
     *      "message": "Incorrect Email OTP"
     * }
     * @response 404 {
     *      "message": "Email verification request not found"
     * }
     * @response 404 {
     *      "message": "Email not registered"
     * }
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "email_otp": [
     *            "The email otp field is required."
     *        ]
     *    }
     *}
     * @response  403 {
     *      "message": "Waiting for Admin to approve your account."
     * }
     * @response  403 {
     *      "message": "Admin has suspended your account."
     * }
     */

    public function verifyEmailOTP(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'email_otp' => 'required|size:6'
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {

            if ($user->hasVerifiedEmail()) {
                return new ErrorMessage("Email already verified", 403);
            }
            try {
                $verify = OTPVerifications::where('user_id', $user->id)->where('type', 'EMAILOTP')->firstOrFail();
                if (Otp::digits(6)->expiry(10)->check($validatedData['email_otp'], $verify->key)) {

                    $user->markEmailAsVerified();
                    return $this->getTokenAndRefreshToken($user);
                } else {
                    if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
                        return new ErrorMessage('Email OTP expired', 422);
                    } else {
                        return new ErrorMessage("Incorrect Email OTP", 422);
                    }
                }
            } catch (\Exception $e) {
                return new ErrorMessage('Email verification request not found', 404);
            }
        }

        return new ErrorMessage("Email not registered", 404);
    }
    /**
     * @group Authenticaton and Authorization
     * Verify Mobile OTP
     *
     * @bodyParam mobile_number string required send number with country code "+919876543210"
     * @bodyParam mobile_otp integer required
     *
     * @response 403 {
     *      "message": "Mobile number already verified"
     * }
     * @response 200 {
     *    "token_type": "Bearer",
     *    "expires_in": 31536000,
     *    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmI4YWIyM2Q0YWQ5MzdiMWJlOGNj",
     *    "refresh_token":null,
     *    "first_name": "theo",
     *    "middle_name": "Heart",
     *    "last_name": "lineee",
     *    "email": "theophilus@logidots.com",
     *    "user_type": "DOCTOR",
     *    "first_login": 1,
     *    "current_user_id": 2,
     *    "currency_code": "EUR",
     *    "is_active": "3",
     *    "profile_photo": "http://localhost/fms-api-laravel/public/storage/uploads/1/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
     *    "roles": [
     *        "patient"
     *    ]
     *}
     *
     * @response 404 {
     *      "message": "Mobile number not registered"
     * }
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "mobile_otp": [
     *            "The mobile otp field is required."
     *        ]
     *    }
     *}
     * @response 422 {
     *      "message": "Mobile number OTP expired"
     * }
     * @response 422 {
     *      "message": "Incorrect Mobile number OTP"
     * }
     * @response 404 {
     *      "message": "Mobile number verification request not found"
     * }
     * @response  403 {
     *      "message": "Waiting for Admin to approve your account."
     * }
     * @response  403 {
     *      "message": "Admin has suspended your account."
     * }
     */

    public function verifyMobileOTP(Request $request)
    {
        $validatedData = $request->validate([
            'mobile_number' => 'required',
            'mobile_otp' => 'required|size:6'
        ]);

        $user = User::where('mobile_number', $validatedData['mobile_number'])->first();

        if ($user) {
            if ($user->hasVerifiedMobileNumber()) {
                return new ErrorMessage("Mobile number already verified", 403);
            }

            try {
                $verify = OTPVerifications::where('user_id', $user->id)->where('type', 'MOBILEOTP')->firstOrFail();
                if (Otp::digits(6)->expiry(10)->check($validatedData['mobile_otp'], $verify->key)) {

                    $user->markMobileNumberAsVerified();
                    return $this->getTokenAndRefreshToken($user);
                } else {
                    if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
                        return new ErrorMessage('Mobile number OTP expired', 422);
                    } else {
                        return new ErrorMessage("Incorrect Mobile number OTP", 422);
                    }
                }
            } catch (\Exception $e) {
                return new ErrorMessage('Mobile number verification request not found', 404);
            }
        }
        return new ErrorMessage("Mobile number not registered", 404);
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Verify Mobile and Email OTP
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
     *      "message": "Email and Mobile number already verified."
     * }
     * @response 403 {
     *      "message": "Email, Mobile number already verified. Waiting for admin to approve your account."
     * }
     * @response  403 {
     *      "message": "Waiting for Admin to approve your account."
     * }
     * @response  403 {
     *      "message": "Admin has suspended your account."
     * }
     * @response 200 {
     *    "token_type": "Bearer",
     *    "expires_in": 31536000,
     *    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmI4YWIyM2Q0YWQ5MzdiMWJlOGNj",
     *    "refresh_token":null,
     *    "first_name": "theo",
     *    "middle_name": "Heart",
     *    "last_name": "lineee",
     *    "email": "theophilus@logidots.com",
     *    "user_type": "DOCTOR",
     *    "first_login": 1,
     *    "current_user_id": 2,
     *    "currency_code": "EUR",
     *    "is_active": "3",
     *    "profile_photo": "http://localhost/fms-api-laravel/public/storage/uploads/1/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
     *    "roles": [
     *        "patient"
     *    ]
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

        $errors = new MessageBag();
        try {
            User::where('email', $validatedData['email'])->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('email', "Email not registered");
        }

        try {
            User::where('mobile_number', $validatedData['mobile_number'])->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('mobile_number', "Mobile number not registered");
        }

        if ($errors->has('email') || $errors->has('mobile_number')) {
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $errors;
            return response()->json($error, 422);
        }

        try {
            $user = User::where('email', $validatedData['email'])->where('mobile_number', $validatedData['mobile_number'])->firstOrFail();
        } catch (\Exception $exception) {
            $error = array();
            $errors = new MessageBag();
            $errors->add('error', "Email and Mobile number doesn't belongs to same user");
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $errors;
            return response()->json($error, 422);
        }

        if ($user->hasVerifiedEmail() && $user->hasVerifiedMobileNumber()) {
            // if ($user->id == $user->created_by && is_null($user->approved)) {
            //     return new ErrorMessage("Email, Mobile number already verified. Waiting for admin to approve your account.", 403);
            // }
            return new ErrorMessage("Email and Mobile number already verified.", 403);
        }

        //verify email otp
        $messageBag = new MessageBag();
        try {
            $verify = OTPVerifications::where('user_id', $user->id)->where('type', 'EMAILOTP')->firstOrFail();
            if (Otp::digits(6)->expiry(10)->check($validatedData['email_otp'], $verify->key)) {
                $user->markEmailAsVerified();
            } else {
                if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
                    $messageBag->add('email_otp', 'Email OTP expired');
                } else {
                    $messageBag->add('email_otp', 'Incorrect Email OTP');
                }
            }
        } catch (\Exception $e) {
            $messageBag->add('email_request', 'Email verification request not found');
        }

        try {
            $verify = OTPVerifications::where('user_id', $user->id)->where('type', 'MOBILEOTP')->firstOrFail();
            if (Otp::digits(6)->expiry(10)->check($validatedData['mobile_otp'], $verify->key)) {
                $user->markMobileNumberAsVerified();
            } else {
                if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
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
        return $this->getTokenAndRefreshToken($user);
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Forgot Password Send OTP
     * send OTP through email or mobile number
     *
     * @bodyParam email_or_mobile string required email or mobile number
     *
     * @response 200 {
     *      "message": "Email OTP sent successfully"
     * }
     * @response 200 {
     *      "message": "Mobile OTP sent successfully"
     * }
     * @response 404 {
     *      "message": "User doesn't exist"
     * }
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_or_mobile": [
     *            "The email or mobile field is required."
     *        ]
     *    }
     *}
     */
    public function forgotPassword(Request $request)
    {
        $validatedData = $request->validate([
            'email_or_mobile' => 'required',
        ]);

        $fieldType = filter_var($validatedData['email_or_mobile'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
        try {
            $user = User::where($fieldType, $validatedData['email_or_mobile'])->firstOrFail();

            if ($fieldType == 'email') {
                $otp_email = $this->initiateOTP($user, 'FORGOTEMAIL');

                $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_forgot_passward'));
                SendEmailJob::dispatch(['subject' => config('emailtext.subject_forgot_password'), 'user_name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);

                return new SuccessMessage('Email OTP sent successfully', 200);
            } else {

                //TODO uncommet in production
                $otp_mobile = $this->initiateOTP($user, 'FORGOTMOBILE');
                $mobile_number = $user->country_code . $user->mobile_number;

                $message = "Welcome to EMedicare, Indian's health passport. Your verification OTP for password reset is " . $otp_mobile . ".";
                $this->send($mobile_number, $message);
                return new SuccessMessage('Mobile OTP sent successfully', 200);
            }
        } catch (\Exception $e) {
            return new ErrorMessage("User doesn't exist", 404);
        }
    }
    /**
     * @group Authenticaton and Authorization
     *
     * Forgot Password Verify OTP
     *
     * verify forgot password OTP sent through email or mobile number and change password
     *
     *
     * @bodyParam email_or_mobile string required email or mobile number.
     * @bodyParam otp integer required length 6 digits
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     *
     * @response 200 {
     *      "message": "password reset successfull"
     * }
     * @response 422 {
     *      "message": "Email OTP expired"
     * }
     * @response 422 {
     *      "message": "Incorrect Email OTP"
     * }
     * @response 404 {
     *      "message": "Forgot password request using Email not found"
     * }
     * @response 422 {
     *      "message": "Mobile number OTP expired"
     * }
     * @response 422 {
     *      "message": "Incorrect Mobile number OTP"
     * }
     * @response 404 {
     *      "message": "Forgot password request using Mobile number not found"
     * }
     * @response 404 {
     *      "message": "User doesn't exist"
     * }
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_or_mobile": [
     *            "The email or mobile field is required."
     *        ],
     *        "otp": [
     *            "The otp must be 6 characters."
     *        ],
     *        "password": [
     *            "The password field is required."
     *        ]
     *    }
     *}
     */
    public function forgotPasswordVerify(Request $request)
    {
        $validatedData = $request->validate([
            'email_or_mobile' => 'required',
            'otp' => 'required|size:6',
            'password' => ['required', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'confirmed'],
        ]);

        $fieldType = filter_var($validatedData['email_or_mobile'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        try {
            $user = User::where($fieldType, $validatedData['email_or_mobile'])->firstOrFail();

            if ($fieldType == 'email') {

                try {
                    $verify = OTPVerifications::where('user_id', $user->id)->where('type', 'FORGOTEMAIL')->firstOrFail();
                    if (Otp::digits(6)->expiry(10)->check($validatedData['otp'], $verify->key)) {
                        $user->updatePassword($validatedData['password']);
                        $verify->key = '';
                        $verify->save();
                        return new SuccessMessage("password reset successfull", 200);
                    } else {
                        if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
                            return new ErrorMessage('Email OTP expired', 422);
                        } else {
                            return new ErrorMessage("Incorrect Email OTP", 422);
                        }
                    }
                } catch (\Exception $e) {
                    return new ErrorMessage('Forgot password request using Email not found', 404);
                }
            } else {

                try {
                    $verify = OTPVerifications::where('user_id', $user->id)->where('type', 'FORGOTMOBILE')->firstOrFail();
                    if (Otp::digits(6)->expiry(10)->check($validatedData['otp'], $verify->key)) {

                        $user->updatePassword($validatedData['password']);
                        $verify->key = '';
                        $verify->save();
                        return new SuccessMessage("password reset successfull", 200);
                    } else {
                        if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
                            return new ErrorMessage('Mobile number OTP expired', 422);
                        } else {
                            return new ErrorMessage("Incorrect Mobile number OTP", 422);
                        }
                    }
                } catch (\Exception $e) {
                    return new ErrorMessage('Forgot password request using Mobile number not found', 404);
                }
            }
        } catch (\Exception $e) {
            return new ErrorMessage("User doesn't exist", 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Authenticaton and Authorization
     *
     * Change Password
     *
     * All tokens issued previously will be revoked.
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam current_password string required
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "password": [
     *            "The password must be at least 8 characters.",
     *            "The password format is invalid.",
     *            "The password confirmation does not match."
     *        ],
     *        "current_password": [
     *            "The current password field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *      "message": "password reset successfull."
     * }
     * @response 400 {
     *      "message": "Current password is invalid."
     * }
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => ['required', 'min:8', 'max:20', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'confirmed'],
            'current_password' => 'required'
        ]);

        if (Hash::check($validatedData['current_password'], auth()->user()->password)) {
            //auth()->user()->updatePassword($validatedData['password']);
            $user = Auth::user();
            $user->password = Hash::make($validatedData['password']);
            if ($user->user_type != 'PATIENT') {
                $user->first_login = 1;
            }
            $user->save();
            $token = $request->user()->token();
            $token->revoke();
            return new SuccessMessage("password reset successfull.", 200);
        }
        return new ErrorMessage('Current password is invalid.');
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Check UserName
     *
     * @queryParam username required string
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "username": [
     *            "The username has already been taken."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "username is unique."
     *}
     */
    public function checkUserName(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
        ]);
        return new SuccessMessage("username is unique", 200);
    }
    /**
     * @group Authenticaton and Authorization
     *
     * Change UserName
     *
     * @bodyParam username string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "username": [
     *            "The username has already been taken."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Username saved successfully."
     *}
     */
    public function changeUserName(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
        ]);
        auth()->user()->update(['username' => $request->username]);
        return new SuccessMessage("Username saved successfully.", 200);
    }

    /**
     * getTokenAndRefreshToken
     *
     * @param array $loginData
     * @return access_token,refresh_token
     */
    public function getTokenAndRefreshToken($user)
    {


        if ($user->user_type == 'DOCTOR' && is_null($user->approved)) {
            //return token
        } elseif ($user->is_active == 0) {
            // check if admin has suspended the account
            return new SuccessMessage('Waiting for Admin to approve your account.', 200);
        } elseif ($user->is_active == 2) {
            // return new ErrorMessage('Admin has suspended your account.', 403);
            return new ErrorMessage('Your account has been deactivated. Please contact support.', 403);
        }

        $client = PasswordGrantClient::where('personal_access_client', 1)->first();
        $http = new \GuzzleHttp\Client;
            $response = $http->request('POST', url('/') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'personal_access',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'user_id' => $user->id,
                    'scope' => '*',
                ],
            ]);
                $result = json_decode((string) $response->getBody(), true);
                $result['refresh_token'] = NULL;
                $result['first_name'] = $user->first_name;
                $result['middle_name'] = $user->middle_name;
                $result['last_name'] = $user->last_name;
                $result['email'] = $user->email;
                $result['user_type'] = $user->user_type;
                $result['first_login'] = $user->first_login;
                $result['current_user_id'] = $user->id;
                $result['is_active'] = $user->is_active;
                $result['roles'] = $user->getRoleNames();
                $photo =  $user->profile_photo;
                $result['profile_photo'] = NULL;
                if ($photo != NULL) {

                    $path = storage_path() . "/app/" . $photo;
                    if (file_exists($path)) {
                        $path = Storage::url($photo);
                        $result['profile_photo'] = asset($path);
                    }
                }
                $lab_pharma_name = NULL;
                if ($user->user_type == 'PHARMACIST') {
                    $lab_pharma_name = $user->pharmacy->pharmacy_name;
                } else if ($user->user_type == 'LABORATORY') {
                    $lab_pharma_name = $user->laboratory->laboratory_name;
                }
                $result['lab_pharma_name'] = $lab_pharma_name;
                return response()->json($result, 200);
    }

    /**
     * @authenticated
     *
     * @group Authenticaton and Authorization
     *
     * Get profile info for logged in user
     *
     * @response 200 {
     *    "first_name": "Theophilus",
     *    "middle_name": "Jos",
     *    "last_name": "Simeon",
     *    "email": "theophilus@logidots.com",
     *    "user_type": "DOCTOR",
     *    "first_login": 0,
     *    "current_user_id": 2,
     *    "currency_code": "EUR",
     *    "is_active": "3",
     *    "username":"user_name",
     *    "profile_photo": "http://localhost/fms-api-laravel/public/storage//var/www/html/fms-api-laravel/storage/app/public/uploads/2/1606756408-d4288ed1-62ea-4ba4-8759-e1305675f465.jpeg",
     *   "roles": [
     *        "patient"
     *    ]
     *}
     *
     */
    public function me()
    {
        $profile_photo = NULL;
        $photo = auth()->user()->profile_photo;
        if ($photo != NULL) {

            $path = storage_path() . "/app/" . $photo;
            if (file_exists($path)) {
                $path = Storage::url($photo);
                $profile_photo = asset($path);
            }
        }

        $lab_pharma_name = NULL;
        if (auth()->user()->user_type == 'PHARMACIST') {
            $lab_pharma_name = auth()->user()->pharmacy->pharmacy_name;
        } else if (auth()->user()->user_type == 'LABORATORY') {
            $lab_pharma_name = auth()->user()->laboratory->laboratory_name;
        }

        return response()->json([
            'first_name' => auth()->user()->first_name,
            'middle_name' => auth()->user()->middle_name,
            'last_name' => auth()->user()->last_name,
            'email' => auth()->user()->email,
            'user_type' => auth()->user()->user_type,
            'first_login' => auth()->user()->first_login,
            'current_user_id' => auth()->user()->id,
            'currency_code' => auth()->user()->currency_code,
            'is_active' => auth()->user()->is_active,
            'profile_photo' =>  $profile_photo,
            'roles' => auth()->user()->getRoleNames(),
            'username' => auth()->user()->username,
            'lab_pharma_name' => $lab_pharma_name,
            'signature' => hash_hmac('sha256', auth()->user()->email, config('app.beacon_key')),
        ]);
    }

    /**
     * @authenticated
     *
     * @group Authenticaton and Authorization
     *
     * Check unique Email and mobile number
     *
     * @queryParam email_or_mobile required string
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_or_mobile": [
     *            "The email or mobile field is required.."
     *        ]
     *    }
     *}
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_or_mobile": [
     *            "The Mobile number has already been taken."
     *        ]
     *    }
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_or_mobile": [
     *            "The Email has already been taken."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Mobile number is unique."
     *}
     * @response 200 {
     *    "message": "Email is unique."
     *}
     */
    public function checkUnique(Request $request)
    {
        $request->validate([
            'email_or_mobile' => 'required',
        ]);

        $fieldType = filter_var($request->email_or_mobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        $request->validate(
            [
                'email_or_mobile' => 'present|unique:users,' . $fieldType,
            ],
            [
                'email_or_mobile.unique' => 'The ' . ucfirst(
                    str_replace('_', ' ', $fieldType)
                ) . ' has already been taken.'
            ]
        );
        return new SuccessMessage(ucfirst(str_replace('_', ' ', $fieldType)) . " is unique.", 200);
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Send OTP for Email or mobile number
     *
     * @queryParam email_or_mobile required string
     * @queryParam country_code present string
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_or_mobile": [
     *            "The email or mobile field is required."
     *        ],
     *        "country_code": [
     *            "The country code field must be present."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Email OTP sent successfully."
     *}
     * @response 200 {
     *    "message": "Mobile OTP resent successfully."
     *}
     * @response 422 {
     *    "message": "OTP send failed."
     *}
     */
    public function authUserSendOTP(Request $request)
    {
        $request->validate([
            'email_or_mobile' => 'required',
            'country_code' => 'present'
        ]);

        $fieldType = filter_var($request->email_or_mobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        if ($fieldType == 'email') {
            try {
                $otp_email = $this->initiateOTP(auth()->user(), 'NEWEMAILOTP');

                $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_password_change'));
                SendEmailJob::dispatch(['subject' => config('emailtext.subject_password_change'), 'user_name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);

                return new SuccessMessage("Email OTP sent successfully.", 200);
            } catch (\Exception $e) {

                return new ErrorMessage("OTP send failed.", 422);
            }
        } else {
            try {
                //for mobile number verification
                $otp_mobile = $this->initiateOTP(auth()->user(), 'NEWMOBILEOTP');
                $mobile_number = $request->country_code . $request->email_or_mobile;

                //TODO uncomment in production
                // $message = 'Your verification OTP for changing mobile number is : ' . $otp_mobile . ' valid for 10 minutes.';

                $message = " Welcome to EMedicare, Indian's health passport. Your verification OTP for changing mobile number is " . $otp_mobile . ".";
                $this->send($mobile_number, $message);
                return new SuccessMessage('Mobile OTP resent successfully.', 200);
            } catch (\Exception $e) {
                return new ErrorMessage("OTP send failed.", 422);
            }
        }
    }
    /**
     * @authenticated
     *
     * @group General
     *
     * Verify OTP for Email or mobile number
     *
     * @queryParam email_or_mobile required string
     * @queryParam otp required integer
     * @queryParam country_code present string
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email_or_mobile": [
     *            "The email or mobile field is required."
     *        ],
     *        "country_code": [
     *            "The country code field must be present."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Email changed successfully."
     *}
     * @response 200 {
     *    "message": "Mobile number changed successfully."
     *}
     * @response 422 {
     *    "message": "Email OTP expired."
     *}
     * @response 422 {
     *    "message": "Incorrect Email OTP."
     *}
     * @response 404 {
     *    "message": "Email change request not found."
     *}
     * @response 422 {
     *    "message": "Mobile number OTP expired."
     *}
     * @response 422 {
     *    "message": "Incorrect Mobile number OTP."
     *}
     * @response 404 {
     *    "message": "Mobile number request not found."
     *}
     */
    public function authUserVerifyOTP(Request $request)
    {
        $validatedData = $request->validate([
            'email_or_mobile' => 'required',
            'otp' => 'required|size:6',
            'country_code' => 'present'

        ]);

        $fieldType = filter_var($validatedData['email_or_mobile'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        if ($fieldType == 'email') {
            try {
                $verify = OTPVerifications::where('user_id', auth()->user()->id)->where('type', 'NEWEMAILOTP')->firstOrFail();
                if (Otp::digits(6)->expiry(10)->check($validatedData['otp'], $verify->key)) {
                    auth()->user()->update(['email' => $validatedData['email_or_mobile']]);
                    $verify->key = '';
                    $verify->save();
                    return new SuccessMessage("Email changed successfully.", 200);
                } else {
                    if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
                        return new ErrorMessage('Email OTP expired.', 422);
                    } else {
                        return new ErrorMessage("Incorrect Email OTP.", 422);
                    }
                }
            } catch (\Exception $e) {
                return new ErrorMessage('Email change request not found.', 404);
            }
        } else {

            try {
                $verify = OTPVerifications::where('user_id', auth()->user()->id)->where('type', 'NEWMOBILEOTP')->firstOrFail();
                if (Otp::digits(6)->expiry(10)->check($validatedData['otp'], $verify->key)) {

                    auth()->user()->update(['mobile_number' => $validatedData['email_or_mobile'], 'country_code' => $validatedData['country_code']]);
                    $verify->key = '';
                    $verify->save();
                    return new SuccessMessage("Mobile number changed successfully.", 200);
                } else {
                    if (Carbon::now() > Carbon::parse($verify->updated_at)->addMinutes(10) && $verify->key != null) {
                        return new ErrorMessage('Mobile number OTP expired.', 422);
                    } else {
                        return new ErrorMessage("Incorrect Mobile number OTP.", 422);
                    }
                }
            } catch (\Exception $e) {
                return new ErrorMessage('Mobile number request not found.', 404);
            }
        }
    }
}
