<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaboratoryRegistrationRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\SendEmailJob;
use App\Model\Address;
use App\Model\AppOptions;
use App\Model\BankAccountDetails;
use App\Model\LaboratoryInfo;
use App\Traits\sendMobileOTPTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tzsk\Otp\Facades\Otp;
use Str;

class LaboratoryRegistrationController extends Controller
{
    use sendMobileOTPTrait;
    /**
     * @group Authenticaton and Authorization
     *
     * Laboratory Registration - step(1) FD288
     *
     * @bodyParam laboratory_name string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam email string required
     * @bodyParam gstin string required
     * @bodyParam lab_reg_number string required
     * @bodyParam lab_issuing_authority string required
     * @bodyParam lab_date_of_issue date required format:Y-m-d
     * @bodyParam lab_valid_upto date required format:Y-m-d
     * @bodyParam lab_file image required required mime:jpg,jpeg,png size max 2mb
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "laboratory_name": [
     *            "The laboratory name field is required."
     *        ],
     *        "country_code": [
     *            "The country code field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "alt_country_code": [
     *            "The Alternative country code field is required when Alternative mobile number is present."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "gstin": [
     *            "GSTIN (Goods and Services Tax Identification Number) is required."
     *        ],
     *        "lab_reg_number": [
     *            "Laboratory Registraton number is required."
     *        ],
     *        "lab_issuing_authority": [
     *            "Laboratory Registraton Issuing Authority is required."
     *        ],
     *        "lab_date_of_issue": [
     *            "Laboratory Registraton date of issue is required."
     *        ],
     *        "lab_valid_upto": [
     *            "Laboratory Registraton valid upto is required."
     *        ],
     *        "lab_file": [
     *            "Laboratory Registraton image file is required."
     *        ]
     *    }
     *}
     *
     * @response 200{
     *    "data_id": 3
     *}
     */
    public function basicInfo(LaboratoryRegistrationRequest $request)
    {
        $dl_file_path = NULL;
        if ($request->file('lab_file')) {
            $fileExtension = $request->lab_file->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/temp';
            $filePath = $request->file('lab_file')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $dl_file_path = $filePath;
        }
        $data = $request->validated();
        unset($data['lab_file']);
        $data['lab_file_path'] = $dl_file_path;
        $data['step'] = 1;
        $data['type'] = 'laboratory';
        $appOptions = AppOptions::create(['options' => $data]);
        return response()->json(['data_id' => $appOptions->id], 200);
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Laboratory Registration - step(2) FD290
     *
     * @bodyParam data_id integer required data_id returned from step 1
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam sample_collection boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if sample_collection is filled
     * @bodyParam currency_code stirng required
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
     *        "sample_collection": [
     *            "Sample collection from home field is required."
     *        ],
     *        "order_amount": [
     *            "Order amount is required when Sample collection from home field is yes."
     *        ],
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "data_id": 1
     *}
     * @response 404{
     *     "message": "data id not found"
     *}
     */
    public function address(LaboratoryRegistrationRequest $request)
    {
        $data = $request->validated();
        try {
            $record = AppOptions::whereJsonContains('options', ['step' => 1, 'type' => 'laboratory'])->findOrFail($data['data_id']);
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
     * Laboratory Registration - step(3) FD292
     *
     * @bodyParam data_id integer required data_id returned from step 1
     * @bodyParam row array nullable
     * @bodyParam row[0][id] integer required id of Laboratory Test List, Unique
     * @bodyParam row[0][sample_collect] boolean required 1 0r 0
     *
     *  @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "data_id": [
     *            "The data id field is required."
     *        ],
     *        "row.0.id": [
     *            "The row.0.id field is required."
     *        ],
     *        "row.1.id": [
     *            "The row.1.id field is required."
     *        ],
     *        "row.0.sample_collect": [
     *            "The row.0.sample_collect field is required."
     *        ],
     *        "row.1.sample_collect": [
     *            "The row.1.sample_collect field is required."
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
    public function addTestList(LaboratoryRegistrationRequest $request)
    {
        $data = $request->validated();
        try {
            $record = AppOptions::whereJsonContains('options', ['step' => 2, 'type' => 'laboratory'])->findOrFail($data['data_id']);
            unset($data['data_id']);
            $data['step'] = 3;
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
     * Laboratory Registration - step(4) FD291
     *
     * @bodyParam data_id integer required data_id returned from step 1
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
     *
     */
    public function addBankDetails(LaboratoryRegistrationRequest $request)
    {
        $data = $request->validated();
        try {
            $record = AppOptions::whereJsonContains('options', ['step' => 3, 'type' => 'laboratory'])->findOrFail($data['data_id']);

            unset($data['data_id']);
            $data['step'] = 4;
            $info = array_merge($record->options, $data);
            $record->options = $info;

            // now send email and mobile otp
            //for email verification

            $otp_info = getOTP();
            $info['otp_email'] = $otp_info['otp'];
            $info['verified_email'] = NULL;

            // validation key
            $info['email_key'] = $otp_info['key'];

            $message = str_replace('$$$OTPEMAIL$$$', $info['otp_email'], config('emailtext.otp_laboratory_register'));

            SendEmailJob::dispatch(['subject' => config('emailtext.subject_laboratory_register'), 'user_name' => $info['laboratory_name'], 'email' => $info['email'], 'mail_type' => 'otpverification', 'message' => $message]);

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

            return response()->json(['data_id' => $record->id], 200);
        } catch (\Exception $exception) {

            if ($exception->getMessage() == 'No query results for model [App\Model\AppOptions] 1')
                return new ErrorMessage('Email, Mobile OTP already been sent', 403);

            return new ErrorMessage('data id not found', 404);
        }
    }
    /**
     * @group Authenticaton and Authorization
     *
     * Laboratory Resend Email OTP
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

        $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'step' => 4, 'type' => 'laboratory'])
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

                $message = str_replace('$$$OTPEMAIL$$$', $otp_email, config('emailtext.otp_laboratory_register'));

                SendEmailJob::dispatch(['subject' => config('emailtext.subject_laboratory_register'), 'user_name' => $user->options['laboratory_name'], 'email' => $user->options['email'], 'mail_type' => 'otpverification', 'message' => $message]);

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
     * Laboratory Resend Mobile OTP
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

        $user =  AppOptions::whereJsonContains('options', ['mobile_number' => $validatedData['mobile_number'], 'step' => 4, 'type' => 'laboratory'])
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
     * Laboratory Verify Mobile and Email OTP
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

        $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'mobile_number' => $validatedData['mobile_number'], 'step' => 4, 'type' => 'laboratory'])->orderBy('updated_at', 'desc')->first();

        $errors = new MessageBag();
        try {
            $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'step' => 4, 'type' => 'laboratory'])->orderBy('updated_at', 'desc')->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('email', "Email not registered");
        }

        try {
            $user =  AppOptions::whereJsonContains('options', ['mobile_number' => $validatedData['mobile_number'], 'step' => 4, 'type' => 'laboratory'])->orderBy('updated_at', 'desc')->firstOrFail();
        } catch (\Exception $exception) {
            $errors->add('mobile_number', "Mobile number not registered");
        }

        if ($errors->has('email') || $errors->has('mobile_number')) {
            $error['message'] = 'The given data was invalid.';
            $error['errors'] = $errors;
            return response()->json($error, 422);
        }

        try {
            $user =  AppOptions::whereJsonContains('options', ['email' => $validatedData['email'], 'mobile_number' => $validatedData['mobile_number'], 'step' => 4, 'type' => 'laboratory'])->orderBy('updated_at', 'desc')->first();
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
            $data_user['last_name'] = $user->options['laboratory_name'];
            $data_user['email'] = $user->options['email'];
            $data_user['country_code'] = $user->options['country_code'];
            $data_user['mobile_number'] = $user->options['mobile_number'];
            $data_user['password'] = Hash::make(Str::random(8));
            $data_user['username'] = uniqid('lab');
            $data_user['user_type'] = 'LABORATORY';
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
            $data_address['address_type'] = 'LABORATORY';
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
            //LaboratoryInfo table
            $data_lab['user_id'] = $new_user->id;
            $data_lab['laboratory_unique_id'] = getLaboratoryId();
            $data_lab['laboratory_name'] = $user->options['laboratory_name'];
            $data_lab['alt_mobile_number'] = $user->options['alt_mobile_number'];
            $data_lab['alt_country_code'] = $user->options['alt_country_code'];
            $data_lab['gstin'] = $user->options['gstin'];
            $data_lab['lab_reg_number'] = $user->options['lab_reg_number'];
            $data_lab['lab_issuing_authority'] = $user->options['lab_issuing_authority'];
            $data_lab['lab_date_of_issue'] = $user->options['lab_date_of_issue'];
            $data_lab['lab_valid_upto'] = $user->options['lab_valid_upto'];
            $data_lab['sample_collection'] = $user->options['sample_collection'];
            $data_lab['order_amount'] = $user->options['order_amount'];
            $data_lab['lab_tests'] = $user->options['row'];
            $data_lab['lab_file_path'] = NULL;

            if (Storage::disk('local')->exists($user->options['lab_file_path'])) {

                $uuid = Str::uuid()->toString();
                $fileExtension = \File::extension($user->options['lab_file_path']);
                $filePath = 'public/uploads/' . $new_user->id . '/' . time() . '-' . $uuid . '.' . $fileExtension;

                Storage::move($user->options['lab_file_path'], $filePath);
                $data_lab['lab_file_path'] = $filePath;
            }

            LaboratoryInfo::create($data_lab);
        }

        return new SuccessMessage('You will receive notification mail once Admin approves registration.');
    }
}
