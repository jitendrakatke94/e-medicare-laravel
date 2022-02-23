<?php

namespace App\Http\Controllers\API\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdministratorRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\SendEmailJob;
use App\Model\Address;
use App\Model\Appointments;
use App\Model\BankAccountDetails;
use App\Model\DoctorClinicDetails;
use App\Model\DoctorPersonalInfo;
use App\Model\EmergencyContactdetails;
use App\Model\LaboratoryInfo;
use App\Model\PatientPersonalInfo;
use App\Model\Pharmacy;
use App\Model\UserCommissions;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;
use App\Traits\sendMobileOTPTrait;


class AdministratorController extends Controller
{
    use sendMobileOTPTrait;

    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Administrator add Patient
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam title string required
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam gender string required  any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth date required format -> Y-m-d
     * @bodyParam age float required
     * @bodyParam blood_group string nullable
     * @bodyParam height float nullable
     * @bodyParam weight float nullable
     * @bodyParam marital_status string nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
     * @bodyParam occupation string nullable
     * @bodyParam email email required
     * @bodyParam mobile_number string required
     * @bodyParam country_code string required
     * @bodyParam profile_photo file nullable File mime:jpg,jpeg,png size max 2mb
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string nullable required if alt_mobile_number is filled
     * @bodyParam pincode string nullable if filled strictly validate in frontend
     * @bodyParam street_name string nullable Street Name/ House No./ Area if filled strictly validate in frontend
     * @bodyParam city_village string nullable City/Village if filled strictly validate in frontend
     * @bodyParam district string nullable if filled strictly validate in frontend
     * @bodyParam state string nullable if filled strictly validate in frontend
     * @bodyParam country string nullable if filled strictly validate in frontend
     * @bodyParam address_type string required anyone of ['HOME', 'WORK', 'OTHERS'] strictly validate in frontend
     * @bodyParam current_medication string nullable
     * @bodyParam bpl_file_number string nullable
     * @bodyParam bpl_file string nullable if bpl_file_number is filled required File mime:pdf,jpg,jpeg,png size max 2mb
     * @bodyParam first_name_primary string nullable if filled strictly validate in frontend
     * @bodyParam middle_name_primary string nullable
     * @bodyParam last_name_primary string nullable if filled strictly validate in frontend
     * @bodyParam mobile_number_primary string nullable if filled strictly validate in frontend
     * @bodyParam country_code_primary string nullable if filled strictly validate in frontend
     * @bodyParam relationship_primary string nullable any one of['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS'] nullable if filled strictly validate in frontend
     * @bodyParam first_name_secondary string nullable
     * @bodyParam middle_name_secondary string nullable
     * @bodyParam last_name_secondary string nullable
     * @bodyParam mobile_number_secondary string nullable
     * @bodyParam country_code_secondary string nullable if mobile_number_secondary is filled
     * @bodyParam relationship_secondary string nullable if filled, any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER','BROTHER', 'GRANDMOTHER', 'OTHERS']
     *
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "title": [
     *            "The title field is required."
     *        ],
     *        "first_name": [
     *            "The first name field is required."
     *        ],
     *        "last_name": [
     *            "The last name field is required."
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
     *        "blood_group": [
     *            "The blood group field is required."
     *        ],
     *        "height": [
     *            "The height field is required."
     *        ],
     *        "weight": [
     *            "The weight field is required."
     *        ],
     *        "marital_status": [
     *            "The marital status field is required."
     *        ],
     *        "occupation": [
     *            "The occupation field is required."
     *        ],
     *        "alt_mobile_number": [
     *            "The alt mobile number field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ]
     *    }
     *}
     * @response 422 {
     *    "message": "Something went wrong."
     *}
     *
     * @response 200 {
     *    "message": "Patient added successfully."
     *}
     */
    public function addPatient(AdministratorRequest $request)
    {
        \DB::beginTransaction();
        try {

            $userData = $patientData = $addressData = $primary_address = $secondary_address = array();
            $userData['first_name'] = $request->first_name;
            $userData['middle_name'] = $request->middle_name;
            $userData['last_name'] = $request->last_name;
            $userData['email'] = $request->email;
            $userData['country_code'] = $request->country_code;
            $userData['mobile_number'] = $request->mobile_number;
            $userData['role'] = [3];
            $password = Str::random(8);
            $userData['password'] = Hash::make($password);
            $userData['username'] = uniqid('p');
            $userData['user_type'] = 'PATIENT';

            $userData['is_active'] = '1';
            if (auth()->user()->user_type == 'HEALTHASSOCIATE') {
                $userData['is_active'] = '0';
                $userData['email_verified_at'] = now();
                $userData['mobile_number_verified_at'] = now();
            } else {
                $userData['approved_date'] = now();
                $userData['approved'] = auth()->user()->id;
            }

            $userData['created_by'] = auth()->user()->id;
            $user =  User::create($userData);
            $user->assignRole(strtolower($user->user_type));

            // for profile picture data maybe available
            if ($request->file('profile_photo')) {
                $fileName = $request->profile_photo->getClientOriginalName();
                $folder = 'public/uploads/' . $user->id;
                $filePath = $request->file('profile_photo')->storeAs($folder, time() . $fileName);
                $user->profile_photo = $filePath;
                $user->save();
            }

            $patientData['user_id'] = $user->id;
            $patientData['patient_unique_id'] = getPatientId();
            $patientData['title'] = $request->title;
            $patientData['gender'] = $request->gender;
            $patientData['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
            $patientData['age'] = $request->age;
            $patientData['blood_group'] = $request->blood_group;
            $patientData['height'] = $request->height;
            $patientData['weight'] = $request->weight;
            $patientData['marital_status'] = $request->marital_status;
            $patientData['occupation'] = $request->occupation;
            $patientData['alt_country_code'] = $request->alt_country_code;
            $patientData['alt_mobile_number'] = $request->alt_mobile_number;

            // bpl_file_path
            if ($request->filled('bpl_file_number') && $request->file('bpl_file')) {
                $fileName = $request->bpl_file->getClientOriginalName();
                $folder = 'public/uploads/' . $user->id;
                $filePath = $request->file('bpl_file')->storeAs($folder, time() . $fileName);
                $patientData['bpl_file_name'] = $fileName;
                $patientData['bpl_file_number'] = $request->bpl_file_number;
                $patientData['bpl_file_path'] = $filePath;
            }
            // data maybe available
            $patientData['national_health_id'] = $request->national_health_id;
            $patientData['current_medication'] = $request->current_medication;
            PatientPersonalInfo::create($patientData);

            //data maybe available
            if ($request->filled('pincode') && $request->filled('street_name') && $request->filled('city_village') && $request->filled('district') && $request->filled('state') && $request->filled('country')) {

                $addressData['user_id'] = $user->id;
                $addressData['pincode'] = $request->pincode;
                $addressData['street_name'] = $request->street_name;
                $addressData['city_village'] = $request->city_village;
                $addressData['district'] = $request->district;
                $addressData['state'] = $request->state;
                $addressData['country'] = $request->country;
                $addressData['address_type'] = $request->address_type;

                Address::create($addressData);
            }
            //save emergency contact details
            //assign primary contact
            if ($request->filled('first_name_primary') && $request->filled('last_name_primary')) {
                $primary_address['user_id'] = $user->id;
                $primary_address['first_name'] = $request->first_name_primary;
                $primary_address['middle_name'] = $request->middle_name_primary;
                $primary_address['last_name'] = $request->last_name_primary;
                $primary_address['country_code'] = $request->country_code_primary;
                $primary_address['mobile_number'] = $request->mobile_number_primary;
                $primary_address['relationship'] = $request->relationship_primary;
                $primary_address['contact_type'] = 1;
                EmergencyContactdetails::create($primary_address);
            }

            //assign secondary contact
            if ($request->filled('first_name_secondary') && $request->filled('last_name_secondary')) {
                $secondary_address['user_id'] = $user->id;
                $secondary_address['first_name'] = $request->first_name_secondary;
                $secondary_address['middle_name'] = $request->middle_name_secondary;
                $secondary_address['last_name'] = $request->last_name_secondary;
                $secondary_address['country_code'] = $request->country_code_secondary;
                $secondary_address['mobile_number'] = $request->mobile_number_secondary;
                $secondary_address['relationship'] = $request->relationship_secondary;
                $secondary_address['contact_type'] = 0;
                EmergencyContactdetails::create($secondary_address);
            }

            //EMAIL CODE
            $send_user_name = $userData['email'];
            $send_password = $password;

            $message = config('emailtext.patient_profile_activation_mail') . config('emailtext.login_credentials');
            $message = str_replace('$$$USERNAME$$$', $send_user_name, $message);
            $message = str_replace('$$$PASSWORD$$$', $send_password, $message);

            SendEmailJob::dispatch(['subject' => config('emailtext.patient_profile_activation_subject'), 'user_name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            //EMAIL CODE
            //TODO uncomment in production
            $sms = "Welcome to EMedicare, Indian's health passport. Login with Username: " . $send_user_name . " and Password: " . $send_password . ".";
            $this->send($user->country_code . $user->mobile_number, $sms);

            \DB::commit();
            return new SuccessMessage('Patient added successfully.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            \Log::debug('AdministratorController.php addPatient', ['EXCEPTION' => $exception->getMessage()]);
            return new ErrorMessage('Something went wrong.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Administrator add Doctor
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam first_name string required
     * @bodyParam middle_name string nullable
     * @bodyParam last_name string required
     * @bodyParam gender string required any one of ['MALE', 'FEMALE', 'OTHERS']
     * @bodyParam date_of_birth string required format -> Y-m-d
     * @bodyParam age float required
     * @bodyParam qualification string required
     * @bodyParam specialization array required example specialization[0] = 1
     * @bodyParam years_of_experience string required
     * @bodyParam mobile_number string required if edited verify using OTP
     * @bodyParam country_code string required if mobile_number is edited
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string nullable required if alt_mobile_number is filled
     * @bodyParam email string required if edited verify using OTP
     * @bodyParam clinic_name string nullable
     *
     * @bodyParam pincode integer nullable length 6
     * @bodyParam street_name string nullable
     * @bodyParam city_village string nullable
     * @bodyParam district string nullable
     * @bodyParam state string nullable
     * @bodyParam country string nullable
     *
     * @bodyParam address array required
     * @bodyParam address.*.clinic_name string required
     * @bodyParam address.*.pincode integer required length 6
     * @bodyParam address.*.street_name string required Street Name/ House No./ Area
     * @bodyParam address.*.city_village string required City/Village
     * @bodyParam address.*.district string required
     * @bodyParam address.*.state string required
     * @bodyParam address.*.country string required
     * @bodyParam address.*.contact_number string nullable
     * @bodyParam address.*.country_code string nullable required if contact_number is filled
     *
     * @bodyParam address.*.pharmacy_list array nullable
     * @bodyParam address.*.pharmacy_list.* integer required unique id of pharmacy
     * @bodyParam address.*.laboratory_list array nullable
     * @bodyParam address.*.laboratory_list.* integer required unique id of laboratory
     *
     * @bodyParam address.*.latitude double required
     * @bodyParam address.*.longitude double required
     *
     * @bodyParam career_profile string required
     * @bodyParam education_training string required
     * @bodyParam clinical_focus string required
     * @bodyParam awards_achievements string nullable
     * @bodyParam memberships string nullable
     * @bodyParam experience string nullable
     * @bodyParam profile_photo image required required only if image is edited by user. image mime:jpg,jpeg,png size max 2mb
     * @bodyParam service string required anyone of ['INPATIENT', 'OUTPATIENT', 'BOTH']
     * @bodyParam appointment_type_online boolean nullable 0 or 1
     * @bodyParam appointment_type_offline boolean nullable 0 or 1
     * @bodyParam currency_code stirng required
     * @bodyParam consulting_online_fee decimal The consulting online fee field is required when appointment type is 1.
     * @bodyParam consulting_offline_fee decimal The consulting offline fee field is required when appointment type is 1.
     * @bodyParam emergency_fee double nullable
     * @bodyParam emergency_appointment integer
     * @bodyParam no_of_followup integer required values 1 to 10
     * @bodyParam followups_after integer required values 1 to 4
     * @bodyParam cancel_time_period integer nullable send 12 for 12 hours, 48 for 2 days
     * @bodyParam reschedule_time_period integer nullable send 12 for 12 hours, 48 for 2 days
     *
     * @bodyParam bank_account_number string nullable
     * @bodyParam bank_account_holder string nullable required with bank_account_number
     * @bodyParam bank_name string nullable required with bank_account_number
     * @bodyParam bank_city string nullable required with bank_account_number
     * @bodyParam bank_ifsc string nullable required with bank_account_number
     * @bodyParam bank_account_type string nullable required with bank_account_number
     *
     * @response 422 {
     *    "message": "Something went wrong."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "first_name": [
     *            "The first name field is required."
     *        ],
     *        "last_name": [
     *            "The last name field is required."
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
     *        "mobile_number": [
     *            "The mobile number field is required."
     *        ],
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "service": [
     *            "The selected service is invalid."
     *        ],
     *        "no_of_followup": [
     *            "The number of followup field is required"
     *        ],
     *        "followups_after": [
     *            "The number of followup after field is required"
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Doctor added successfully."
     *}
     */
    public function addDoctor(AdministratorRequest $request)
    {
        \DB::beginTransaction();
        try {
            $userData = $doctorData = $bankData = $addressHome = array();
            $userData['first_name'] = $request->first_name;
            $userData['middle_name'] = $request->middle_name;
            $userData['last_name'] = $request->last_name;
            $userData['email'] = $request->email;
            $userData['country_code'] = $request->country_code;
            $userData['mobile_number'] = $request->mobile_number;
            $userData['currency_code'] = $request->currency_code;
            $userData['role'] = [4];
            $password = Str::random(8);
            $userData['password'] = Hash::make($password);
            $userData['username'] = uniqid('d');
            $userData['user_type'] = 'DOCTOR';
            $userData['is_active'] = '1';

            if (auth()->user()->user_type == 'HEALTHASSOCIATE') {
                $userData['is_active'] = '0';
                $userData['email_verified_at'] = now();
                $userData['mobile_number_verified_at'] = now();
            } else {
                $userData['approved_date'] = now();
                $userData['approved'] = auth()->user()->id;
            }


            $userData['created_by'] = auth()->user()->id;
            $user =  User::create($userData);
            $user->assignRole(strtolower($user->user_type));

            UserCommissions::create([
                'unique_id' => getUserCommissionId(),
                'user_id' => $user->id
            ]);

            // for profile picture data maybe available
            if ($request->file('profile_photo')) {
                $fileName = $request->profile_photo->getClientOriginalName();
                $folder = 'public/uploads/' . $user->id;
                $filePath = $request->file('profile_photo')->storeAs($folder, time() . $fileName);
                $user->profile_photo = $filePath;
                $user->save();
            }
            // for doctor_personal_infos table
            $doctorData['user_id'] = $user->id;
            $doctorData['doctor_unique_id'] = getDoctorId();
            $doctorData['gender'] = $request->gender;
            $doctorData['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
            $doctorData['age'] = $request->age;
            $doctorData['qualification'] = $request->qualification;
            $doctorData['years_of_experience'] = $request->years_of_experience;
            $doctorData['alt_country_code'] = $request->alt_country_code;
            $doctorData['alt_mobile_number'] = $request->alt_mobile_number;
            $doctorData['clinic_name'] = $request->clinic_name;

            // aditional information
            $doctorData['career_profile'] = $request->career_profile;
            $doctorData['education_training'] = $request->education_training;
            $doctorData['clinical_focus'] = $request->clinical_focus;
            $doctorData['awards_achievements'] = $request->awards_achievements;
            $doctorData['memberships'] = $request->memberships;
            $doctorData['experience'] = $request->experience;
            $doctorData['service'] = $request->service;
            $doctorData['appointment_type_online'] = $request->appointment_type_online;
            $doctorData['appointment_type_offline'] = $request->appointment_type_offline;
            $doctorData['consulting_online_fee'] = $request->consulting_online_fee;
            $doctorData['consulting_offline_fee'] = $request->consulting_offline_fee;
            $doctorData['emergency_fee'] = $request->emergency_fee;
            $doctorData['emergency_appointment'] = $request->emergency_appointment;
            $doctorData['no_of_followup'] = $request->no_of_followup;
            $doctorData['followups_after'] = $request->followups_after;
            $doctorData['cancel_time_period'] = $request->cancel_time_period;
            $doctorData['reschedule_time_period'] = $request->reschedule_time_period;
            $doctorData['registration_number'] = $request->registration_number;

            $doctor = DoctorPersonalInfo::create($doctorData);
            $doctor->specialization()->sync($request->specialization);

            if ($request->filled('bank_account_number')) {

                $bankData['bank_account_number'] = $request->bank_account_number;
                $bankData['bank_account_holder'] = $request->bank_account_holder;
                $bankData['bank_name'] = $request->bank_name;
                $bankData['bank_city'] = $request->bank_city;
                $bankData['bank_ifsc'] = $request->bank_ifsc;
                $bankData['bank_account_type'] = $request->bank_account_type;
                $bankData['created_by'] = auth()->user()->id;
            }
            $bankData['user_id'] = $user->id;
            BankAccountDetails::create($bankData);

            //for home address table
            if ($request->filled('city_village') && $request->filled('pincode')) {
                $addressHome['user_id'] = $user->id;
                $addressHome['address_type'] = 'HOME';
                $addressHome['pincode'] = $request->pincode;
                $addressHome['street_name'] = $request->street_name;
                $addressHome['city_village'] = $request->city_village;
                $addressHome['district'] = $request->district;
                $addressHome['state'] = $request->state;
                $addressHome['country'] = $request->country;
                $addressHome['created_by'] = auth()->user()->id;
                Address::create($addressHome);
            }

            // get clinic address and save
            foreach ($request->address as $key => $value) {

                $addressClinic['user_id'] = $user->id;
                $addressClinic['address_type'] = 'CLINIC';
                $addressClinic['clinic_name'] = $value['clinic_name'];
                $addressClinic['pincode'] = $value['pincode'];
                $addressClinic['street_name'] = $value['street_name'];
                $addressClinic['city_village'] = $value['city_village'];
                $addressClinic['district'] = $value['district'];
                $addressClinic['state'] = $value['state'];
                $addressClinic['country'] = $value['country'];
                $addressClinic['latitude'] = $value['latitude'];
                $addressClinic['longitude'] = $value['longitude'];
                $addressClinic['created_by'] = auth()->user()->id;

                $address = Address::create($addressClinic);

                $pharmacy_list = $laboratory_list = NULL;
                if ($request->filled('pharmacy_list')) {
                    $pharmacy_list = $value['pharmacy_list'];
                }
                if ($request->filled('laboratory_list')) {
                    $laboratory_list = $value['laboratory_list'];
                }

                DoctorClinicDetails::create([
                    'address_id' => $address->id,
                    'pharmacy_list' => $pharmacy_list,
                    'laboratory_list' => $laboratory_list
                ]);
            }
            //EMAIL CODE
            $send_user_name = $userData['email'];
            $send_password = $password;

            $message = config('emailtext.doctor_profile_approval_mail') . config('emailtext.login_credentials');
            $message = str_replace('$$$USERNAME$$$', $send_user_name, $message);
            $message = str_replace('$$$PASSWORD$$$', $send_password, $message);

            SendEmailJob::dispatch(['subject' => config('emailtext.doctor_profile_approval_subject'), 'user_name' => 'Dr. ' . $user->first_name . ' ' . $user->last_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            //EMAIL CODE
            //TODO uncomment in production
            $sms = "Welcome to EMedicare, Indian's health passport. Login with Username: " . $send_user_name . " and Password: " . $send_password . ".";

            $this->send($user->country_code . $user->mobile_number, $sms);

            \DB::commit();
            return new SuccessMessage('Doctor added successfully.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            \Log::debug('AdministratorController.php addDoctor', ['EXCEPTION' => $exception->getMessage()]);
            return new ErrorMessage('Something went wrong.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Administrator add Pharmacy
     *
     * Authorization: "Bearer {access_token}"
     *
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
     * @bodyParam dl_file file required mime:jpg,jpeg,png size max 2mb
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam home_delivery boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if home_delivery is filled
     * @bodyParam currency_code stirng required
     * @bodyParam latitude double required
     * @bodyParam longitude double required
     * @bodyParam pharmacist_name string required
     * @bodyParam course string required
     * @bodyParam pharmacist_reg_number string required
     * @bodyParam issuing_authority string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam reg_certificate file required mime:jpg,jpeg,png size max 2mb
     * @bodyParam reg_date string required
     * @bodyParam reg_valid_upto file required
     * @bodyParam bank_account_number string nullable
     * @bodyParam bank_account_holder string nullable required with bank_account_number
     * @bodyParam bank_name string nullable required with bank_account_number
     * @bodyParam bank_city string nullable required with bank_account_number
     * @bodyParam bank_ifsc string nullable required with bank_account_number
     * @bodyParam bank_account_type string nullable required with bank_account_number
     *
     *
     * @response 422 {
     *    "message": "Something went wrong."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "pharmacy_name": [
     *            "The pharmacy name field is required."
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
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
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
     *        "reg_date": [
     *            "Registration date field is required."
     *        ],
     *        "reg_valid_upto": [
     *            "Registration valid up to is required."
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
     *
     *
     * @response 200 {
     *    "message": "Pharmacy added successfully."
     *}
     */
    public function addPharmacy(AdministratorRequest $request)
    {
        \DB::beginTransaction();
        try {

            $userData = $pharmacyData = $bankData = $address = array();

            $userData['last_name'] = $request->pharmacist_name;
            $userData['email'] = $request->email;
            $userData['country_code'] = $request->country_code;
            $userData['mobile_number'] = $request->mobile_number;
            $password = Str::random(8);
            $userData['password'] = Hash::make($password);
            $userData['username'] = uniqid('pha');
            $userData['user_type'] = 'PHARMACIST';
            $userData['is_active'] = '1';

            if (auth()->user()->user_type == 'HEALTHASSOCIATE') {
                $userData['is_active'] = '0';
                $userData['email_verified_at'] = now();
                $userData['mobile_number_verified_at'] = now();
            } else {
                $userData['approved_date'] = now();
                $userData['approved'] = auth()->user()->id;
            }

            $userData['role'] = [5];
            $userData['created_by'] = auth()->user()->id;
            $userData['currency_code'] = $request->currency_code;
            $user = User::create($userData);
            $user->assignRole(strtolower($user->user_type));

            //address table
            $address['street_name'] = $request->street_name;
            $address['city_village'] = $request->city_village;
            $address['district'] = $request->district;
            $address['state'] = $request->state;
            $address['country'] = $request->country;
            $address['pincode'] = $request->pincode;
            $address['latitude'] = $request->latitude;
            $address['longitude'] = $request->longitude;
            $address['user_id'] = $user->id;
            $address['created_by'] = auth()->user()->id;
            $address['address_type'] = 'PHARMACY';
            Address::create($address);
            if ($request->filled('bank_account_number')) {
                $bankData['bank_account_number'] = $request->bank_account_number;
                $bankData['bank_account_holder'] = $request->bank_account_holder;
                $bankData['bank_name'] = $request->bank_name;
                $bankData['bank_city'] = $request->bank_city;
                $bankData['bank_ifsc'] = $request->bank_ifsc;
                $bankData['bank_account_type'] = $request->bank_account_type;
            }
            $bankData['user_id'] = $user->id;
            BankAccountDetails::create($bankData);

            $pharmacyData['user_id'] = $user->id;
            $pharmacyData['pharmacy_unique_id'] = getPharmacyId();
            $pharmacyData['pharmacist_name'] = $request->pharmacist_name;
            $pharmacyData['pharmacy_name'] = $request->pharmacy_name;
            $pharmacyData['alt_mobile_number'] = $request->alt_mobile_number;
            $pharmacyData['alt_country_code'] = $request->alt_country_code;
            $pharmacyData['course'] = $request->course;
            $pharmacyData['dl_date_of_issue'] = $request->dl_date_of_issue;

            $pharmacyData['dl_issuing_authority'] = $request->dl_issuing_authority;
            $pharmacyData['dl_number'] = $request->dl_number;
            $pharmacyData['dl_valid_upto'] = $request->dl_valid_upto;
            $pharmacyData['issuing_authority'] = $request->issuing_authority;
            $pharmacyData['pharmacist_reg_number'] = $request->pharmacist_reg_number;
            $pharmacyData['reg_date'] = $request->reg_date;
            $pharmacyData['reg_valid_upto'] = $request->reg_valid_upto;
            $pharmacyData['home_delivery'] = $request->home_delivery;
            $pharmacyData['order_amount'] = $request->order_amount;
            $pharmacyData['gstin'] = $request->gstin;

            // for dl_file data maybe available
            if ($request->file('dl_file')) {
                $fileName = $request->dl_file->getClientOriginalName();
                $folder = 'public/uploads/' . $user->id;
                $filePath = $request->file('dl_file')->storeAs($folder, time() . $fileName);
                $pharmacyData['dl_file_path'] = $filePath;
            }
            if ($request->file('reg_certificate')) {
                $fileName = $request->reg_certificate->getClientOriginalName();
                $folder = 'public/uploads/' . $user->id;
                $filePath = $request->file('reg_certificate')->storeAs($folder, time() . $fileName);
                $pharmacyData['reg_certificate_path'] = $filePath;
            }
            Pharmacy::create($pharmacyData);

            //EMAIL CODE
            $send_user_name = $userData['email'];
            $send_password = $password;

            $message = config('emailtext.pharmacy_account_activation_mail') . config('emailtext.login_credentials');
            $message = str_replace('$$$USERNAME$$$', $send_user_name, $message);
            $message = str_replace('$$$PASSWORD$$$', $send_password, $message);

            SendEmailJob::dispatch(['subject' => config('emailtext.pharmacy_account_activation_subject'), 'user_name' => $user->pharmacy->pharmacy_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            //EMAIL CODE

            //TODO uncomment in production
            $sms = "Welcome to EMedicare, Indian's health passport. Login with Username: " .  $send_user_name . " and Password: " . $send_password . ".";
            $this->send($user->country_code . $user->mobile_number, $sms);
            \DB::commit();
            return new SuccessMessage('Pharmacy added successfully.');
        } catch (\Exception $exception) {

            \DB::rollBack();
            \Log::debug('AdministratorController.php addPharmacy', ['EXCEPTION' => $exception->getMessage()]);
            return new ErrorMessage('Something went wrong.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Administrator add Laboratory
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam laboratory_name string required
     * @bodyParam country_code string required
     * @bodyParam mobile_number string required
     * @bodyParam email string required
     * @bodyParam alt_mobile_number string nullable
     * @bodyParam alt_country_code string required when alt_mobile_number is present
     * @bodyParam gstin string required
     * @bodyParam lab_reg_number string required
     * @bodyParam lab_issuing_authority string required
     * @bodyParam lab_date_of_issue date required format:Y-m-d
     * @bodyParam lab_valid_upto date required format:Y-m-d
     * @bodyParam lab_file image required required mime:jpg,jpeg,png size max 2mb
     *
     * @bodyParam row array nullable
     * @bodyParam row.*.id integer required test list ids
     * @bodyParam row.*.sample_collect boolean required 0 or 1
     *
     * @bodyParam pincode integer required length 6
     * @bodyParam street_name string required Street Name/ House No./ Area
     * @bodyParam city_village string required City/Village
     * @bodyParam district string required
     * @bodyParam state string required
     * @bodyParam country string required
     * @bodyParam sample_collection boolean required 0 or 1
     * @bodyParam order_amount decimal nullable required if home_delivery is filled
     * @bodyParam currency_code stirng required
     * @bodyParam latitude double required
     * @bodyParam longitude double required
     *
     * @bodyParam bank_account_number string nullable
     * @bodyParam bank_account_holder string nullable required with bank_account_number
     * @bodyParam bank_name string nullable required with bank_account_number
     * @bodyParam bank_city string nullable required with bank_account_number
     * @bodyParam bank_ifsc string nullable required with bank_account_number
     * @bodyParam bank_account_type string nullable required with bank_account_number
     *
     *
     * @response 422 {
     *    "message": "Something went wrong."
     *}
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
     *        "email": [
     *            "The email field is required."
     *        ],
     *        "gstin": [
     *            "The gstin field is required."
     *        ],
     *        "lab_reg_number": [
     *            "The lab reg number field is required."
     *        ],
     *        "lab_issuing_authority": [
     *            "The lab issuing authority field is required."
     *        ],
     *        "lab_date_of_issue": [
     *            "The lab date of issue field is required."
     *        ],
     *        "lab_valid_upto": [
     *            "The lab valid upto field is required."
     *        ],
     *        "lab_file": [
     *            "The lab file field is required."
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
     *            "The sample collection field is required."
     *        ],
     *        "latitude": [
     *            "The latitude field is required."
     *        ],
     *        "longitude": [
     *            "The longitude field is required."
     *        ],
     *        "data_id": [
     *            "The data id field is required."
     *        ],
     *        "row": [
     *            "The row field is required."
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
     *
     * @response 200 {
     *    "message": "Laboratory added successfully."
     *}
     *
     */
    public function addLaboratory(AdministratorRequest $request)
    {
        \DB::beginTransaction();
        try {
            $userData = $labData = $bankData = $address = array();

            $userData['last_name'] = $request->laboratory_name;
            $userData['email'] = $request->email;
            $userData['country_code'] = $request->country_code;
            $userData['mobile_number'] = $request->mobile_number;
            $password = Str::random(8);
            $userData['password'] = Hash::make($password);
            $userData['username'] = uniqid('lab');
            $userData['user_type'] = 'LABORATORY';

            $userData['is_active'] = '1';
            if (auth()->user()->user_type == 'HEALTHASSOCIATE') {
                $userData['is_active'] = '0';
                $userData['email_verified_at'] = now();
                $userData['mobile_number_verified_at'] = now();
            } else {
                $userData['approved_date'] = now();
                $userData['approved'] = auth()->user()->id;
            }

            $userData['role'] = [6];
            $userData['created_by'] = auth()->user()->id;
            $userData['currency_code'] = $request->currency_code;
            $user = User::create($userData);
            $user->assignRole(strtolower($user->user_type));

            //address table
            $address['street_name'] = $request->street_name;
            $address['city_village'] = $request->city_village;
            $address['district'] = $request->district;
            $address['state'] = $request->state;
            $address['country'] = $request->country;
            $address['pincode'] = $request->pincode;
            $address['latitude'] = $request->latitude;
            $address['longitude'] = $request->longitude;
            $address['user_id'] = $user->id;
            $address['created_by'] = auth()->user()->id;
            $address['address_type'] = 'LABORATORY';
            Address::create($address);
            if ($request->filled('bank_account_number')) {
                $bankData['bank_account_number'] = $request->bank_account_number;
                $bankData['bank_account_holder'] = $request->bank_account_holder;
                $bankData['bank_name'] = $request->bank_name;
                $bankData['bank_city'] = $request->bank_city;
                $bankData['bank_ifsc'] = $request->bank_ifsc;
                $bankData['bank_account_type'] = $request->bank_account_type;
            }
            $bankData['user_id'] = $user->id;
            BankAccountDetails::create($bankData);

            //LaboratoryInfo table
            $labData['user_id'] = $user->id;
            $labData['laboratory_unique_id'] = getLaboratoryId();
            $labData['laboratory_name'] = $request->laboratory_name;
            $labData['alt_mobile_number'] = $request->alt_mobile_number;
            $labData['alt_country_code'] = $request->alt_country_code;
            $labData['gstin'] = $request->gstin;
            $labData['lab_reg_number'] = $request->lab_reg_number;
            $labData['lab_issuing_authority'] = $request->lab_issuing_authority;
            $labData['lab_date_of_issue'] = $request->lab_date_of_issue;
            $labData['lab_valid_upto'] = $request->lab_valid_upto;
            $labData['sample_collection'] = $request->sample_collection;
            $labData['order_amount'] = $request->order_amount;

            if ($request->filled('row')) {
                $labData['lab_tests'] = $request->row;
            }
            if ($request->file('lab_file')) {
                $fileName = $request->lab_file->getClientOriginalName();
                $folder = 'public/uploads/' . $user->id;
                $filePath = $request->file('lab_file')->storeAs($folder, time() . $fileName);
                $labData['lab_file_path'] = $filePath;
            }
            LaboratoryInfo::create($labData);

            //EMAIL CODE
            $send_user_name = $userData['email'];
            $send_password = $password;

            $message = config('emailtext.lab_account_activation_mail') . config('emailtext.login_credentials');
            $message = str_replace('$$$USERNAME$$$', $send_user_name, $message);
            $message = str_replace('$$$PASSWORD$$$', $send_password, $message);

            SendEmailJob::dispatch(['subject' => config('emailtext.lab_account_activation_subject'), 'user_name' => $user->laboratory->laboratory_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            //EMAIL CODE

            //TODO uncomment in production
            $sms = "Welcome to EMedicare, Indian's health passport. Login with Username: " . $send_user_name . " and Password: " . $send_password . ".";
            $this->send($user->country_code . $user->mobile_number, $sms);
            \DB::commit();
            return new SuccessMessage('Laboratory added successfully.');
        } catch (\Exception $exception) {

            \DB::rollBack();
            \Log::debug('AdministratorController.php addLaboratory', ['EXCEPTION' => $exception->getMessage()]);
            return new ErrorMessage('Something went wrong.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin update PNS
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam appointment_id number required
     * @bodyParam is_valid_pns boolean required send 0 or 1
     * @bodyParam is_refunded boolean present send 0 or 1
     * @bodyParam refund_amount amount present
     * @bodyParam admin_pns_comment string present
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ],
     *        "is_valid_pns": [
     *            "The is valid pns field is required."
     *        ],
     *        "is_refunded": [
     *            "The is refunded field must be present."
     *        ],
     *        "refund_amount": [
     *            "The refund amount field must be present."
     *        ],
     *        "admin_pns_comment": [
     *            "The admin pns comment field must be present."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Appointment updated successfully."
     *}
     * @response 403 {
     *    "message": "PNS has been already updated."
     *}
     */

    public function updatePNS(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id,deleted_at,NULL,comment,PNS',
            'is_valid_pns' => 'required|in:0,1',
            'is_refunded' => 'present|required_if:is_valid_pns,1|in:0,1|nullable',
            'refund_amount' => 'present|required_if:is_refunded,1|nullable',
            'admin_pns_comment' => 'present|nullable',
        ]);

        $appointment = Appointments::with('doctor')->find($data['appointment_id']);

        if (!is_null($appointment->is_valid_pns)) {
            return new ErrorMessage("PNS has been already updated.", 403);
        }

        $appointment->is_valid_pns = $data['is_valid_pns'];
        $appointment->is_refunded = $data['is_refunded'];
        $appointment->refund_amount = $data['refund_amount'];
        $appointment->admin_pns_comment = $data['admin_pns_comment'];
        $appointment->save();

        $subject = 'EMedicare: Refund for Patient didn’t show up for Appointment Id ' . $appointment->appointment_unique_id;
        $new_date = Carbon::parse($appointment->date)->format('d M Y');
        if ($appointment->consultation_type != 'EMERGENCY') {
            $new_time = Carbon::parse($appointment->time)->format('h:i A');
        } else {
            $new_time = 'NA';
        }

        // send mail
        $message = "You didn’t show up for Appointment " . $appointment->appointment_unique_id . " with Dr. " . $appointment->doctor->first_name . " " .  $appointment->doctor->last_name . " booked for " . $new_date . " @ " . $new_time . " Doctor has marked your appointment as Patient No Show (PNS). After  considering your reply and discussion with doctor ";

        if ($request->filled('is_refunded') && $request->is_refunded == 1) {
            $message .= 'we are processing your refund of ₹ ' . $request->refund_amount . '.';
        } else if ($request->is_valid_pns == 0 || $request->is_refunded == 0) {
            $message .= 'we are unable to process any refund as per our “Cancellation, Refund & Rescheduling” policy.In case of any doubt you can read our “Terms & Conditions” page and “Cancellation, Refund & Rescheduling” policy on our home page. You have already accepted these terms while booking the appointment.';
        }

        SendEmailJob::dispatch(['subject' => $subject, 'user_name' => $appointment->patient_details->first_name . ' ' . $appointment->patient_details->last_name, 'email' => $appointment->patient_details->email, 'mail_type' => 'otpverification', 'message' => $message]);
        return new SuccessMessage('Appointment updated successfully.');
    }
}
