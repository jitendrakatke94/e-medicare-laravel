<?php

namespace App\Http\Services;

use App\Http\Repositories\PatientRepository;
use App\Http\Requests\PatientRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\EmergencyContactdetails;
use App\Model\PatientFamilyMembers;
use App\Model\PatientPersonalInfo;
use App\User;
use Carbon\Carbon;
use Str;

class PatientService
{
    public static function editFamilyMember($data, $id, $user_id)
    {
        try {
            $relation = array('FATHER', 'MOTHER', 'HUSBAND', 'WIFE');
            if (in_array($data['relationship'], $relation)) {

                $record =  PatientFamilyMembers::where('id', '!=', $id)->where('user_id', $user_id)->where('relationship', $data['relationship'])->first();
                if ($record) {
                    throw new \Exception("Relationship " . strtolower($data['relationship']) . " already found.", 1);
                }
            }
        } catch (\Exception $exception) {
            return new ErrorMessage($exception->getMessage(), 404);
        }
        // check unique for name, relationship.
        $record = PatientFamilyMembers::where('id', '!=', $id)->where('user_id', $user_id)->where('relationship', $data['relationship'])->where('first_name', $data['first_name'])->where('middle_name', $data['middle_name'])->where('last_name', $data['last_name'])->first();

        if ($record) {
            return new ErrorMessage('Duplicate entry found.', 422);
        }
        try {
            $data['updated_by'] = auth()->user()->id;
            PatientFamilyMembers::findOrFail($id)->update($data);
        } catch (\Exception $exception) {

            return new ErrorMessage('Family member not found.', 404);
        }
        return new SuccessMessage('Family member updated successfully.');
    }

    public static function getEmergencyContact($user_id)
    {
        try {

            $primary_address = EmergencyContactdetails::where('user_id', $user_id)->where('contact_type', 1)->firstOrFail()->toArray();

            $address = array();
            $address['first_name_primary'] = $primary_address['first_name'];
            $address['middle_name_primary'] = $primary_address['middle_name'];
            $address['last_name_primary'] = $primary_address['last_name'];
            $address['country_code_primary'] = $primary_address['country_code'];
            $address['mobile_number_primary'] = $primary_address['mobile_number'];
            $address['relationship_primary'] = $primary_address['relationship'];

            $address['first_name_secondary'] = NULL;
            $address['middle_name_secondary'] = NULL;
            $address['last_name_secondary'] = NULL;
            $address['mobile_number_secondary'] = NULL;
            $address['relationship_secondary'] = NULL;
            $address['current_medication'] = NULL;
            $address['bpl_file_number'] = NULL;
            $address['bpl_file'] = NULL;

            $secondary_address = EmergencyContactdetails::where('user_id', $user_id)->where('contact_type', 0)->first();
            if ($secondary_address) {
                $address['first_name_secondary'] = $secondary_address['first_name'];
                $address['middle_name_secondary'] = $secondary_address['middle_name'];
                $address['last_name_secondary'] = $secondary_address['last_name'];
                $address['country_code_secondary'] = $secondary_address['country_code'];
                $address['mobile_number_secondary'] = $secondary_address['mobile_number'];
                $address['relationship_secondary'] = $secondary_address['relationship'];
            }
            $patient = PatientPersonalInfo::where('user_id', $user_id)->first();
            if ($patient) {
                $patient->toArray();
                $address['current_medication'] = $patient['current_medication'];
                $address['bpl_file_number'] = $patient['bpl_file_number'];
                $address['bpl_file'] = $patient['bpl_file_name'];
            }
            return response()->json($address, 200);
        } catch (\Exception $exception) {

            return new ErrorMessage('No records found.', 404);
        }
    }

    public static function addEmergencyContact(PatientRequest $request, $user_id)
    {
        $data = $request->validated();
        $info = array();
        $info['current_medication'] = $data['current_medication'];
        $info['bpl_file_number'] = $data['bpl_file_number'];
        $patient = PatientPersonalInfo::where('user_id', $user_id)->first();
        if ($request->file('bpl_file')) {
            //upload file is bpl file number is found
            $fileName = $request->bpl_file->getClientOriginalName();
            $folder = 'public/uploads/' . $user_id;
            $filePath = $request->file('bpl_file')->storeAs($folder, time() . $fileName);
            $info['bpl_file_name'] = $fileName;
            $info['bpl_file_path'] = $filePath;
        }
        $patient->update($info);
        //save emergency contact details
        //assign primary contact
        $primary_address = $secondary_address = array();
        $primary_address['first_name'] = $data['first_name_primary'];
        $primary_address['middle_name'] = $data['middle_name_primary'];
        $primary_address['last_name'] = $data['last_name_primary'];
        $primary_address['country_code'] = $data['country_code_primary'];
        $primary_address['mobile_number'] = $data['mobile_number_primary'];
        $primary_address['relationship'] = $data['relationship_primary'];
        //assign secondary contact
        $primary_address['contact_type'] = 1;
        $secondary_address['first_name'] = $data['first_name_secondary'];
        $secondary_address['middle_name'] = $data['middle_name_secondary'];
        $secondary_address['last_name'] = $data['last_name_secondary'];
        $secondary_address['country_code'] = $data['country_code_secondary'];
        $secondary_address['mobile_number'] = $data['mobile_number_secondary'];
        $secondary_address['relationship'] = $data['relationship_secondary'];
        $patientRepository = new PatientRepository();
        $patientRepository->saveEmergencyContact($primary_address, $secondary_address, $user_id);
        return new SuccessMessage('Details saved successfully.');
    }
    public static function getFile($user_id)
    {
        try {
            $patient = PatientPersonalInfo::where('user_id', $user_id)->firstOrFail();

            $file_path = storage_path() . "/app/" . $patient->bpl_file_path;

            if (file_exists($file_path)) {

                $content_type = mime_content_type($file_path);
                $headers = array(
                    'Content-Type: ' . $content_type,
                );
                return \Response::download($file_path, $patient->bpl_file_name, $headers);
            }
            return new ErrorMessage('File not found.', 404);
        } catch (\Exception $exception) {
            return new ErrorMessage('File not found.', 404);
        }
    }

    public static function getProfile($id)
    {
        try {
            $user = User::where('user_type', 'PATIENT')->with('patient')->findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Details not found.', 404);
        }
        $patient['first_name'] = $user->first_name;
        $patient['middle_name'] = $user->middle_name;
        $patient['last_name'] = $user->last_name;
        $patient['email'] = $user->email;
        $patient['country_code'] = $user->country_code;
        $patient['mobile_number'] = $user->mobile_number;
        $patient['username'] = $user->username;
        $patient['title'] = $user->patient->title;
        $patient['gender'] = $user->patient->gender;
        $patient['date_of_birth'] = $user->patient->date_of_birth;
        $patient['age'] = $user->patient->age;
        $patient['blood_group'] = $user->patient->blood_group;
        $patient['height'] = $user->patient->height;
        $patient['weight'] = $user->patient->weight;
        $patient['marital_status'] = $user->patient->marital_status;
        $patient['occupation'] = $user->patient->occupation;
        $patient['alt_country_code'] = $user->patient->alt_country_code;
        $patient['alt_mobile_number'] = $user->patient->alt_mobile_number;
        $patient['national_health_id'] = $user->patient->national_health_id;
        $patient['patient_profile_photo'] = $user->profile_photo_url;

        return response()->json($patient, 200);
    }

    public static function editProfile(PatientRequest $request, $user_id)
    {
        $userData = array();
        $patientData = array();

        $userData['first_name'] = $request->first_name;
        $userData['middle_name'] = $request->middle_name;
        $userData['last_name'] = $request->last_name;
        $userData['email'] = $request->email;
        $userData['country_code'] = $request->country_code;
        $userData['mobile_number'] = $request->mobile_number;

        if ($request->file('profile_photo')) {
            $fileExtension = $request->profile_photo->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/' . $user_id;
            $filePath = $request->file('profile_photo')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
            $userData['profile_photo'] = $filePath;
        }

        User::find($user_id)->update($userData);

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

        $patientData['national_health_id'] = NULL;
        if ($request->filled('national_health_id')) {
            $patientData['national_health_id'] = $request->national_health_id;
        }

        PatientPersonalInfo::where('user_id', $user_id)->update($patientData);
        return new SuccessMessage("Details saved successfully.");
    }
}
