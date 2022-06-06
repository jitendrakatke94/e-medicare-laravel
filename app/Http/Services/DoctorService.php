<?php

namespace App\Http\Services;

use App\Http\Requests\DoctorRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Address;
use App\Model\AdminSettings;
use App\Model\DoctorClinicDetails;
use App\Model\DoctorPersonalInfo;
use App\Model\Specializations;
use App\User;
use Carbon\Carbon;
use Str;

class DoctorService
{
    public static function getProfile($id)
    {
        try {
            $user = User::where('user_type', 'DOCTOR')->with('doctor')->findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Doctor not found.', 404);
        }
        $data = $info = array(
            'first_name' => NULL,
            'middle_name' => NULL,
            'last_name' => NULL,
            'email' => NULL,
            'country_code' => NULL,
            'mobile_number' => NULL,
            'username' => NULL,
            'gender' => NULL,
            'date_of_birth' => NULL,
            'age' => NULL,
            'qualification' => NULL,
            'specialization' => [],
            'years_of_experience' => NULL,
            'alt_country_code' => NULL,
            'alt_mobile_number' => NULL,
            'clinic_name' => NULL,
            'pincode' => NULL,
            'street_name' => NULL,
            'city_village' => NULL,
            'district' => NULL,
            'state' => NULL,
            'country' => NULL,
            'specialization_list' => [],
        );
        $doctor = DoctorPersonalInfo::with('specialization')->where('user_id', $id)->first();

        if ($doctor) {
            $doctor = $doctor->toArray();
            foreach ($doctor['specialization'] as $key => $value) {
                unset($doctor['specialization'][$key]['pivot']);
            }
            $data = array_merge($data, $doctor);
        }
        $address = Address::select([
            'pincode',
            'street_name',
            'city_village',
            'district',
            'country',
            'state',
        ])->where('user_id', $id)->where('address_type', 'HOME')->first();
        if ($address) {
            $data = array_merge($data, $address->toArray());
        }
        $user = User::find($id);
        $data['first_name'] = $user->first_name;
        $data['middle_name'] = $user->middle_name;
        $data['last_name'] = $user->last_name;
        $data['email'] =  $user->email;
        $data['country_code'] = $user->country_code;
        $data['mobile_number'] = $user->mobile_number;
        $data['username'] = $user->username;

        $list = Specializations::all();
        if ($list) {
            $data['specialization_list'] = $list;
        }
        //to get required keys
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $info)) {
                unset($data[$key]);
            }
        }
        return response()->json($data, 200);
    }

    public static function editProfile(DoctorRequest $request, $user_id)
    {
        $userData = $doctorData = $address = array();
        // for users table
        $userData['first_name'] = $request->first_name;
        $userData['middle_name'] = $request->middle_name;
        $userData['last_name'] = $request->last_name;
        $userData['email'] = $request->email;
        $userData['country_code'] = $request->country_code;
        $userData['mobile_number'] = $request->mobile_number;

        User::find($user_id)->update($userData);
        // for doctor_personal_infos table
        $doctorData['gender'] = $request->gender;
        $doctorData['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $doctorData['age'] = $request->age;
        $doctorData['qualification'] = $request->qualification;
        $doctorData['years_of_experience'] = $request->years_of_experience;
        $doctorData['alt_country_code'] = $request->alt_country_code;
        $doctorData['alt_mobile_number'] = $request->alt_mobile_number;

        if ($request->filled('clinic_name')) {
            $doctorData['clinic_name'] = $request->clinic_name;
        }

        $doctor = DoctorPersonalInfo::where('user_id', $user_id)->first();
        $doctor->update($doctorData);
        $doctor->specialization()->sync($request->specialization);
        //for addresses table
        $address['user_id'] = $user_id;
        $address['address_type'] = 'HOME';
        $address['pincode'] = $request->pincode;
        $address['street_name'] = $request->street_name;
        $address['city_village'] = $request->city_village;
        $address['district'] = $request->district;
        $address['state'] = $request->state;
        $address['country'] = $request->country;
        $address['created_by'] = auth()->user()->id;
        Address::updateOrCreate(
            [
                'user_id' => $address['user_id'], 'address_type' => $address['address_type']
            ],
            $address
        );
        return new SuccessMessage('Details saved successfully.');
    }

    public static function editAdditionalInformation(DoctorRequest $request, $id)
    {
        try {
            $doctor = DoctorPersonalInfo::where('user_id', $id)->firstOrFail();
        } catch (\Exception $e) {
            return new ErrorMessage('Doctor additional information not found.', 404);
        }
        $data = $request->validated();

        $option = AdminSettings::where('option', 'cancel_time_period')->first();
        if ($data['cancel_time_period'] > $option->value) {

            return new ErrorMessage('Cancel Time Period is greater than Master Cancel Time Period.', 403);
        }
        $option = AdminSettings::where('option', 'reschedule_time_period')->first();

        if ($data['reschedule_time_period'] > $option->value) {

            return new ErrorMessage('Reschedule Time Period is greater than Master Reschedule Time Period.', 403);
        }

        User::where('id', $id)->update(['currency_code' => $data['currency_code']]);
        unset($data['currency_code']);
        //upload profile_photo is found
        if ($request->file('profile_photo')) {
            $fileExtension = $request->profile_photo->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/storage/uploads/' . $id;
            $filePath = $request->file('profile_photo')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            User::where('id', $id)->update(['profile_photo' => $filePath]);
        }
        $doctor->update($data);
        return new SuccessMessage('Details updated successfully.');
    }
    public static function getAdditionalInformation($user_id)
    {
        $info = array(
            'career_profile' => NULL,
            'education_training' => NULL,
            'clinical_focus' => NULL,
            'awards_achievements' => NULL,
            'memberships' => NULL,
            'experience' => NULL,
            'doctor_profile_photo' => NULL,
            'service' => NULL,
            'appointment_type_online' => NULL,
            'appointment_type_offline' => NULL,
            'currency_code' => NULL,
            'consulting_online_fee' => NULL,
            'consulting_offline_fee' => NULL,
            'emergency_fee' => NULL,
            'emergency_appointment' => NULL,
            'no_of_followup' => NULL,
            'followups_after' => NULL,
            'cancel_time_period' => NULL,
            'reschedule_time_period' => NULL,
            'payout_period' => NULL,
            'time_intravel' => NULL,
            'registration_number' => NULL,
        );
        $data = DoctorPersonalInfo::where('user_id', $user_id)->first();

        if ($data) {
            $data = $data->toArray();
            $info['career_profile'] = $data['career_profile'];
            $info['education_training'] = $data['education_training'];
            $info['clinical_focus'] = $data['clinical_focus'];
            $info['awards_achievements'] = $data['awards_achievements'];
            $info['memberships'] = $data['memberships'];
            $info['experience'] = $data['experience'];
            $info['doctor_profile_photo'] = $data['doctor_profile_photo'];
            $info['service'] = $data['service'];
            $info['appointment_type_online'] = $data['appointment_type_online'];
            $info['appointment_type_offline'] = $data['appointment_type_offline'];
            $info['consulting_online_fee'] = $data['consulting_online_fee'];
            $info['consulting_offline_fee'] = $data['consulting_offline_fee'];
            $info['emergency_fee'] = $data['emergency_fee'];
            $info['emergency_appointment'] = $data['emergency_appointment'];

            $info['no_of_followup'] = $data['no_of_followup'];
            $info['followups_after'] = $data['followups_after'];
            $info['cancel_time_period'] = $data['cancel_time_period'];
            $info['reschedule_time_period'] = $data['reschedule_time_period'];
            $info['payout_period'] = $data['payout_period'];
            $info['registration_number'] = $data['registration_number'];
            $info['time_intravel'] = $data['time_intravel'];
        }
        $user = User::find($user_id);
        $info['currency_code'] = $user->currency_code;

        return response()->json($info, 200);
    }

    public static function editAddress(DoctorRequest $request, $id)
    {
        $data = $request->validated();
        $data['clinic_name'] = $data['clinic_name'];
        $data['updated_by'] = auth()->user()->id;

        $pharmacy_list = $laboratory_list = NULL;
        if ($request->filled('pharmacy_list')) {
            $pharmacy_list = $data['pharmacy_list'];
        }
        if ($request->filled('laboratory_list')) {
            $laboratory_list = $data['laboratory_list'];
        }

        try {

            unset($data['pharmacy_list']);
            unset($data['laboratory_list']);

            Address::findOrFail($id)->update($data);

            DoctorClinicDetails::updateOrCreate(
                ['address_id' => $id],
                [
                    'address_id' => $id,
                    'pharmacy_list' => $pharmacy_list,
                    'laboratory_list' => $laboratory_list
                ]
            );
        } catch (\Exception $exception) {

            return new ErrorMessage('Address not found', 404);
        }
        return new SuccessMessage('Address updated successfully');
    }
}
