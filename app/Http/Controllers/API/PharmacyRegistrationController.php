<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PharmacyRegistrationRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\SendEmailJob;
use App\Model\Address;
use App\Model\AppOptions;
use App\Model\BankAccountDetails;
use App\Model\Pharmacy;
use Str;
use Carbon\Carbon;
use App\Traits\sendMobileOTPTrait;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Tzsk\Otp\Facades\Otp;

class PharmacyRegistrationController extends Controller
{
    use sendMobileOTPTrait;
    /**
     * @group Authenticaton and Authorization
     *
     * Pharmacy Registration - step(1) FD282
     *
     * @bodyParam pharmacy_name string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam gstin string required
     * @bodyParam dl_number string required
     * @bodyParam dl_issuing_authority string required
     * @bodyParam dl_date_of_issue date required format:Y-m-d
     * @bodyParam dl_valid_upto date required format:Y-m-d
     * @bodyParam dl_file image required required mime:jpg,jpeg,png size max 2mb
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "pharmacy_name": [
     *            "The pharmacy name field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ],
     *        "gstin": [
     *            "GSTIN (Goods and Services Tax Identification Number) is required."
     *        ],
     *        "dl_number": [
     *            "Drug licence number is required."
     *        ],
     *        "dl_issuing_authority": [
     *            "Drug licence Issuing Authority is required."
     *        ],
     *        "dl_date_of_issue": [
     *            "Drug licence date of issue is required."
     *        ],
     *        "dl_valid_upto": [
     *            "Drug licence valid upto is required."
     *        ],
     *        "dl_file": [
     *            "Drug licence image file is required."
     *        ]
     *    }
     *}
     *
     * @response 200{
     *    "data_id": 3
     *}
     */
    public function basicInfo(PharmacyRegistrationRequest $request)
    {
        $dl_file_path = NULL;
        if ($request->file('dl_file')) {
            $fileExtension = $request->dl_file->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/temp';
            $filePath = $request->file('dl_file')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $dl_file_path = $filePath;
        }
        $data = $request->validated();
        unset($data['dl_file']);
        $data['dl_file_path'] = $dl_file_path;
        $data['step'] = 1;
        $data['type'] = 'pharmacy';
        $appOptions = AppOptions::create(['options' => $data]);

        return response()->json(['data_id' => $appOptions->id], 200);
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Pharmacy Registration - step(2) FD283
     *
     * @bodyParam data_id integer required data_id returned from step 1
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam home_delivery boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if home_delivery is filled
     * @bodyParam currency_code string required
     * @bodyParam latitude double required
     * @bodyParam longitude double required
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
     *        ],
     *        "home_delivery": [
     *            "The home delivery field is required."
     *        ],
     *        "order_amount": [
     *            "The order amount field is required when home delivery is 1."
     *        ],
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ]
     *    }
     *}
     * @response 200{
     *    "data_id": 3
     *}
     * @response 404{
     *     "message": "data id not found"
     *}
     */
    public function address(PharmacyRegistrationRequest $request)
    {
        $data = $request->validated();
        try {
            $record = AppOptions::whereJsonContains('options', ['step' => 1, 'type' => 'pharmacy'])->findOrFail($data['data_id']);
            unset($data['data_id']);
            $data['step'] = 2;
            $info = array_merge($record->options, $data);
            $record->options = $info;
            $record->save();
            return response()->json(['data_id' => $record->id], 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('data id not found', 404);
        }
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Pharmacy Registration - step(3) FD284
     *
     * @bodyParam data_id integer required data_id returned from step 2
     * @bodyParam pharmacist_name string required
     * @bodyParam course string required
     * @bodyParam pharmacist_reg_number string required
     * @bodyParam issuing_authority string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam reg_certificate string required
     * @bodyParam reg_date string required
     * @bodyParam reg_valid_upto string required
     * @bodyParam bank_account_number string nullable
     * @bodyParam bank_account_holder string nullable required with bank_account_number
     * @bodyParam bank_name string nullable required with bank_account_number
     * @bodyParam bank_city string nullable required with bank_account_number
     * @bodyParam bank_ifsc string nullable required with bank_account_number
     * @bodyParam bank_account_type string nullable required with bank_account_number
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "data_id": [
     *            "The data id field is required."
     *        ],
     *        "pharmacist_name": [
     *            "The pharmacist name field is required."
     *        ],
     *        "course": [
     *            "The course field is required."
     *        ],
     *        "pharmacist_reg_number": [
     *            "Pharmacist Registration Number is required."
     *        ],
     *        "issuing_authority": [
     *            "The issuing authority field is required."
     *        ],
     *        "alt_country_code": [
     *            "The alt country code field is required when alt mobile number is present."
     *        ],
     *        "reg_certificate": [
     *            "The reg certificate field is required."
     *        ],
     *        "reg_date": [
     *            "The reg date field is required."
     *        ],
     *        "reg_valid_upto": [
     *            "The reg valid upto field is required."
     *        ],
     *        "bank_account_number": [
     *            "The bank account number field is required."
     *        ],
     *        "bank_account_holder": [
     *            "The bank account holder field is required."
     *        ],
     *        "bank_name": [
     *            "The bank name field is required."
     *        ],
     *        "bank_city": [
     *            "The bank city field is required."
     *        ],
     *        "bank_ifsc": [
     *            "The bank ifsc field is required."
     *        ],
     *        "bank_account_type": [
     *            "The bank account type field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Email, Mobile OTP has been sent",
     *    "data_id": 3,
     *    "mobile_number": "8940330539",
     *    "email": "theophilus1@logidots.com"
     *}
     * @response 404{
     *     "message": "data id not found"
     *}
     */
    public function additionalDetails(PharmacyRegistrationRequest $request)
    {
        $data = $request->validated();
        try {
            $record = AppOptions::whereJsonContains('options', ['step' => 2, 'type' => 'pharmacy'])->findOrFail($data['data_id']);
            unset($data['data_id']);
            $reg_certificate_path = NULL;
            if ($request->file('reg_certificate')) {
                $fileExtension = $request->reg_certificate->extension();
                $uuid = Str::uuid()->toString();
                $folder = 'public/uploads/temp';
                $filePath = $request->file('reg_certificate')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
                $reg_certificate_path = $filePath;
            }
            unset($data['reg_certificate']);
            $data['reg_certificate_path'] = $reg_certificate_path;
            $data['step'] = 3;
            $info = array_merge($record->options, $data);

            // now send email and mobile otp
            //for email verification

            $otp_info = getOTP();
            $info['otp_email'] = $otp_info['otp'];
            $info['verified_email'] = NULL;

            // validation key
            $info['email_key'] = $otp_info['key'];

            $message = str_replace('$$$OTPEMAIL$$$', $info['otp_email'], config('emailtext.otp_pharmacy_register'));

            SendEmailJob::dispatch(['subject' => config('emailtext.subject_pharmacy_register'), 'user_name' => $info['pharmacist_name'], 'email' => $info['email'], 'mail_type' => 'otpverification', 'message' => $message]);

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
            return new ErrorMessage('data id not found', 404);
        }
    }

    /**
     * @group Authenticaton and Authorization
     * Pharmacy Resend Email OTP
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

        $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'step' => 3, 'type' => 'pharmacy'])
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

                $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_pharmacy_register'));

                SendEmailJob::dispatch(['subject' => config('emailtext.subject_pharmacy_register'), 'user_name' => $user->options['pharmacist_name'], 'email' => $user->options['email'], 'mail_type' => 'otpverification', 'message' => $message]);

                return new SuccessMessage("Email OTP sent successfully", 200);
            } catch (\Exception $e) {

                return new ErrorMessage("OTP resend failed", 422);
            }
        }
        return new ErrorMessage("Email not registered", 404);
    }
    /**
     * @group Authenticaton and Authorization
     * Pharmacy Resend Mobile OTP
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

        $user =  AppOptions::whereJsonContains('options', ['mobile_number' => $validatedData['mobile_number'], 'step' => 3, 'type' => 'pharmacy'])
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
     * Pharmacy Verify Mobile and Email OTP
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

        $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'mobile_number' => $validatedData['mobile_number'], 'step' => 3, 'type' => 'pharmacy'])->orderBy('updated_at', 'desc')->first();


        $errors = new MessageBag();
        try {
            $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'step' => 3, 'type' => 'pharmacy'])->orderBy('updated_at', 'desc')->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('email', "Email not registered");
        }

        try {
            $user =  AppOptions::whereJsonContains('options', ['mobile_number' => $validatedData['mobile_number'], 'step' => 3, 'type' => 'pharmacy'])->orderBy('updated_at', 'desc')->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('mobile_number', "Mobile number not registered.");
        }

        if ($errors->has('email') || $errors->has('mobile_number')) {
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $errors;
            return response()->json($error, 422);
        }

        try {
            $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'mobile_number' => $validatedData['mobile_number'], 'step' => 3, 'type' => 'pharmacy'])->orderBy('updated_at', 'desc')->first();
        } catch (\Exception $exception) {
            $error = array();
            $errors = new MessageBag();
            $errors->add('error', "Email and Mobile number doesn't belongs to same user.");
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $errors;
            return response()->json($error, 422);
        }

        //verify email otp
        $options = $user->options;
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
        // after verify save all the details to respective tables
        if (is_null($user->options['verified_email']) && is_null($user->options['verified_mobile'])) {
            $user->options = $options;
            $user->save();

            //user table
            $data_user['last_name'] = $user->options['pharmacist_name'];
            $data_user['email'] = $user->options['email'];
            $data_user['country_code'] = $user->options['country_code'];
            $data_user['mobile_number'] = $user->options['mobile_number'];
            $data_user['password'] = Hash::make(Str::random(8));
            $data_user['username'] = uniqid('pha');
            $data_user['user_type'] = 'PHARMACIST';
            $data_user['email_verified_at'] = now();
            $data_user['mobile_number_verified_at'] = now();
            $data_user['currency_code'] = $user->options['currency_code'];

            $new_user = User::create($data_user);
            // to check user is added by admin
            $new_user->created_by = $new_user->id;
            $new_user->save();

            //address table
            $data_address['street_name'] = $user->options['street_name'];
            $data_address['city_village'] = $user->options['city_village'];
            $data_address['district'] = $user->options['district'];
            $data_address['state'] = $user->options['state'];
            $data_address['country'] = $user->options['country'];
            $data_address['pincode'] = $user->options['pincode'];
            $data_address['latitude'] = $user->options['latitude'];
            $data_address['longitude'] = $user->options['longitude'];
            $data_address['user_id'] = $new_user->id;
            $data_address['created_by'] = $new_user->id;
            $data_address['address_type'] = 'PHARMACY';

            Address::create($data_address);
            //bankaccounts table
            $data_bank['user_id'] = $new_user->id;
            $data_bank['bank_account_number'] = $user->options['bank_account_number'];
            $data_bank['bank_account_holder'] = $user->options['bank_account_holder'];
            $data_bank['bank_name'] = $user->options['bank_name'];
            $data_bank['bank_city'] = $user->options['bank_city'];
            $data_bank['bank_ifsc'] = $user->options['bank_ifsc'];
            $data_bank['bank_account_type'] = $user->options['bank_account_type'];
            BankAccountDetails::create($data_bank);
            //Pharmacy table
            $data_pharmacy['user_id'] = $new_user->id;
            $data_pharmacy['pharmacy_unique_id'] = getPharmacyId();
            $data_pharmacy['pharmacist_name'] = $user->options['pharmacist_name'];
            $data_pharmacy['pharmacy_name'] = $user->options['pharmacy_name'];
            $data_pharmacy['alt_mobile_number'] = $user->options['alt_mobile_number'];
            $data_pharmacy['alt_country_code'] = $user->options['alt_country_code'];
            $data_pharmacy['course'] = $user->options['course'];
            $data_pharmacy['dl_date_of_issue'] = $user->options['dl_date_of_issue'];

            $data_pharmacy['dl_issuing_authority'] = $user->options['dl_issuing_authority'];
            $data_pharmacy['dl_number'] = $user->options['dl_number'];
            $data_pharmacy['dl_valid_upto'] = $user->options['dl_valid_upto'];
            $data_pharmacy['issuing_authority'] = $user->options['issuing_authority'];
            $data_pharmacy['pharmacist_reg_number'] = $user->options['pharmacist_reg_number'];
            $data_pharmacy['reg_date'] = $user->options['reg_date'];
            $data_pharmacy['reg_valid_upto'] = $user->options['reg_valid_upto'];
            $data_pharmacy['home_delivery'] = $user->options['home_delivery'];
            $data_pharmacy['order_amount'] = $user->options['order_amount'];
            $data_pharmacy['gstin'] = $user->options['gstin'];

            $data_pharmacy['dl_file_path'] = NULL;
            $data_pharmacy['reg_certificate_path'] = NULL;

            if (Storage::disk('local')->exists($user->options['dl_file_path'])) {

                $uuid = Str::uuid()->toString();
                $fileExtension = \File::extension($user->options['dl_file_path']);
                $filePath = 'public/uploads/' . $new_user->id . '/' . time() . '-' . $uuid . '.' . $fileExtension;

                Storage::move($user->options['dl_file_path'], $filePath);
                $data_pharmacy['dl_file_path'] = $filePath;
            }
            if (Storage::disk('local')->exists($user->options['reg_certificate_path'])) {

                $uuid = Str::uuid()->toString();
                $fileExtension = \File::extension($user->options['reg_certificate_path']);
                $filePath = 'public/uploads/' . $new_user->id . '/' . time() . '-' . $uuid . '.' . $fileExtension;

                Storage::move($user->options['reg_certificate_path'], $filePath);
                $data_pharmacy['reg_certificate_path'] = $filePath;
            }
            Pharmacy::create($data_pharmacy);
        }

        return new SuccessMessage('You will receive notification mail once Admin approves registration.');
    }
}
