<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Jobs\SendEmailJob;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;
use App\Traits\sendMobileOTPTrait;
use Illuminate\Support\Facades\Storage;

class ActionsController extends Controller
{
    use sendMobileOTPTrait;
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin Confirm Doctor,Pharmacy,Laboratory,Health Associate Registration
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of user
     *
     * @bodyParam user_id integer required id of user
     * @bodyParam action string required any one of APPROVE , REJECT
     * @bodyParam user_type string required any one of PHARMACIST,LABORATORY,DOCTOR,HEALTHASSOCIATE
     * @bodyParam comment string nullable
     *
     * @response 200 {
     *    "message": "Confirmation mail sent successfully"
     *}
     * @response 404 {
     *    "message": "Pharmacy not found"
     *}
     * @response 403 {
     *    "message": "Confirmation mail already been sent"
     *}
     * @response 403 {
     *    "message": "Email is not verified."
     *}
     * @response 403 {
     *    "message": "Mobile number is not verified."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "action": [
     *            "The selected action is invalid."
     *        ],
     *        "user_id": [
     *            "The selected user id is invalid."
     *        ],
     *        "user_type": [
     *            "The user type field is required."
     *        ]
     *    }
     *}
     */

    public function approveOrReject(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|in:APPROVE,REJECT',
            'user_id' => 'required|integer|exists:users,id,deleted_at,NULL',
            'user_type' => 'required|in:PHARMACIST,LABORATORY,DOCTOR,PATIENT,HEALTHASSOCIATE',
            'comment' => 'present|nullable|string',

        ]);
        $data = array(
            'login_credentials' => config('emailtext.login_credentials'),
            'sent' => 'Confirmation mail,SMS already been sent.',
            'rejectSent' => 'Rejection mail,SMS already been sent.',
            'send' => 'Confirmation mail,SMS sent successfully.',
            'rejectSend' => 'Rejection mail,SMS sent successfully.',
            'PHARMACIST' => array(
                'notfound' => 'Pharmacy not found.',
                'messageEmail' => "Welcome to emedicare, Indian's health passport. Your account registration with emedicare is activated.",
                'messageReject' => 'Your account registration with emedicare is rejected.',
                'email_activate' => array(
                    'subject' => config('emailtext.pharmacy_account_activation_subject'),
                    'message' => config('emailtext.pharmacy_account_activation_mail') . config('emailtext.login_credentials'),
                ),
                'email_deactivate' => array(
                    'subject' => config('emailtext.pharmacy_delete_by_admin_subject'),
                    'message' => config('emailtext.pharmacy_delete_by_admin_mail'),
                    'comment_subject' => config('emailtext.pharmacy_account_rejection_subject'),
                    'comment_message' => config('emailtext.pharmacy_account_rejection_mail'),
                ),
            ),
            'LABORATORY' => array(
                'notfound' => 'Laboratory not found.',
                'messageEmail' => "Welcome to emedicare, Indian's health passport. Your account registration with emedicare is activated.",
                'messageReject' => 'Your account registration with emedicare is rejected.',
                'email_activate' => array(
                    'subject' => config('emailtext.lab_account_activation_subject'),
                    'message' => config('emailtext.lab_account_activation_mail') . config('emailtext.login_credentials'),
                ),
                'email_deactivate' => array(
                    'subject' => config('emailtext.laboratory_delete_by_admin_subject'),
                    'message' => config('emailtext.laboratory_delete_by_admin_mail'),
                    'comment_subject' => config('emailtext.laboratory_account_rejection_subject'),
                    'comment_message' => config('emailtext.laboratory_account_rejection_mail'),
                ),
            ),
            'DOCTOR' => array(
                'notfound' => 'Doctor not found.',
                'messageEmail' => "Welcome to emedicare, Indian's health passport. Your account registration with emedicare is activated.",
                'messageReject' => 'Your account registration with emedicare is rejected.',
                'email_activate' => array(
                    'subject' => config('emailtext.doctor_profile_approval_subject'),
                    'message' => config('emailtext.doctor_profile_approval_mail'),
                ),
                'email_deactivate' => array(
                    'subject' => config('emailtext.doctor_delete_by_admin_subject'),
                    'message' => config('emailtext.doctor_delete_by_admin_mail'),
                    'comment_subject' => config('emailtext.doctor_profile_rejection_subject'),
                    'comment_message' => config('emailtext.doctor_profile_rejection_mail'),
                ),
            ),
            'PATIENT' => array(
                'notfound' => 'Patient not found.',
                'messageEmail' => "Welcome to emedicare, Indian's health passport. Your account registration with EMedemedicareicare is activated.",
                'messageReject' => 'Your account registration with emedicare is rejected.',
                'email_activate' => array(
                    'subject' => config('emailtext.patient_profile_activation_subject'),
                    'message' => config('emailtext.patient_profile_activation_mail'),
                ),
                'email_deactivate' => array(
                    'subject' => config('emailtext.profile_deactivation_subject'),
                    'message' => config('emailtext.patient_deactivation_mail'),
                    'comment_subject' => config('emailtext.profile_deactivation_subject'),
                    'comment_message' => config('emailtext.patient_deactivation_mail'),
                ),
            ),
            'HEALTHASSOCIATE' => array(
                'notfound' => 'User not found.',
                'messageEmail' => "Welcome to emedicare, Indian's health passport. Your account registration with emedicare is activated.",
                'messageReject' => 'Your account registration with emedicare is rejected.',
                'email_activate' => array(
                    'subject' => config('emailtext.health_associate_account_activation_subject'),
                    'message' => config('emailtext.health_associate_account_activation_mail') . config('emailtext.login_credentials'),
                ),
                'email_deactivate' => array(
                    'subject' => config('emailtext.health_associate_delete_by_admin_subject'),
                    'message' => config('emailtext.health_associate_delete_by_admin_mail'),
                    'comment_subject' => config('emailtext.health_associate_rejection_subject'),
                    'comment_message' => config('emailtext.health_associate_rejection_mail'),
                ),
            ),
        );
        try {
            $user = User::where('user_type', $validatedData['user_type'])->findOrFail($validatedData['user_id']);
        } catch (\Exception $exception) {
            return new ErrorMessage($data[$validatedData['user_type']]['notfound'], 404);
        }

        if ($user->user_type == 'DOCTOR') {
            $mail_user_name = 'Dr. ' . $user->first_name . ' ' . $user->last_name;
        } elseif ($user->user_type == 'PHARMACIST') {
            $mail_user_name =   $user->pharmacy->pharmacy_name;
        } elseif ($user->user_type == 'LABORATORY') {
            $mail_user_name =  $user->laboratory->laboratory_name;
        } else {
            $mail_user_name =   $user->first_name . ' ' . $user->last_name;
        }

        if ($validatedData['action'] == 'APPROVE') {

            //TODO uncomment in production

            if (!$user->hasVerifiedEmail()) {
                return new ErrorMessage('Email is not verified.', 403);
            }
            if (!$user->hasVerifiedMobileNumber()) {
                return new ErrorMessage('Mobile number is not verified.', 403);
            }

            if ($user->is_active == 1) {
                return new ErrorMessage($data['sent'], 403);
            }

            $message['message'] = $data[$validatedData['user_type']]['messageEmail'];

            if ($user->user_type != 'DOCTOR') {
                $user_name = $user->email;
                $string = Str::random(8);
                $password = $string;
                $user->password = Hash::make($string);

                $sms = "Welcome to EMedicare, Indian's health passport. Login with Username: " . $user_name . " and Password: " . $password . ".";

                //TODO uncomment in production
                $this->send($user->country_code . $user->mobile_number, $sms);

                $message = $data[$validatedData['user_type']]['email_activate']['message'];
                $message = str_replace('$$$USERNAME$$$', $user_name, $message);
                $message = str_replace('$$$PASSWORD$$$', $password, $message);

                SendEmailJob::dispatch(['subject' => $data[$validatedData['user_type']]['email_activate']['subject'], 'user_name' => $mail_user_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            } else {

                $message = $data[$validatedData['user_type']]['email_activate']['message'];

                SendEmailJob::dispatch(['subject' => $data[$validatedData['user_type']]['email_activate']['subject'], 'user_name' => $mail_user_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            }
            //save status
            $user->is_active = '1';
            $user->approved = auth()->user()->id;
            $user->approved_date = now();
            $user->updated_by = auth()->user()->id;

            if ($validatedData['user_type'] != 'HEALTHASSOCIATE') {
                $user->assignRole(strtolower($user->user_type));
            }
            if ($validatedData['user_type'] == 'HEALTHASSOCIATE') {
                $user->employee->update(['date_of_joining' => now()->format('Y-m-d')]);
            }
            $user->save();
            return new SuccessMessage($data['send'], 200);
        } else {
            // action reject uncomment in production
            if ($user->is_active == 2) {
                return new ErrorMessage($data['rejectSent'], 403);
            }

            //TODO uncomment in production
            $this->send($user->country_code . $user->mobile_number, $data[$validatedData['user_type']]['messageReject']);

            //save status
            $user->is_active = '2';
            $user->updated_by = auth()->user()->id;
            // send mail of comment content
            if ($request->filled('comment')) {

                $message = $data[$validatedData['user_type']]['email_deactivate']['comment_message'];

                $message = $message . "Below is the comment added by the Admin <br> '" . $validatedData['comment'] . "'";

                SendEmailJob::dispatch(['subject' => $data[$validatedData['user_type']]['email_deactivate']['comment_subject'], 'user_name' => $mail_user_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
                $user->comment = $request->comment;
            } else {

                $message = $data[$validatedData['user_type']]['email_deactivate']['message'];

                SendEmailJob::dispatch(['subject' => $data[$validatedData['user_type']]['email_deactivate']['subject'], 'user_name' => $mail_user_name, 'email' => $user->email, 'mail_type' => 'otpverification', 'message' => $message]);
            }
            $user->save();
            return new SuccessMessage($data['rejectSend'], 200);
        }
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Activate user
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam user_id integer required id of user
     *
     * @response {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "user_id": [
     *            "The user id field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "User activated successfully."
     *}
     */
    public function activateUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        $user->is_active = '1';
        $user->save();
        return new SuccessMessage('User activated successfully.', 200);
    }
}
