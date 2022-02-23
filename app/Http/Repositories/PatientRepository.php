<?php

namespace App\Http\Repositories;

use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\PatientPersonalInfo;
use App\Model\Address;
use App\Model\EmergencyContactdetails;
use App\Model\PatientFamilyMembers;
use Carbon\Carbon;

class PatientRepository
{

    /**
     *
     * @param [array] $data
     * @return void
     */
    public function updateOrCreate($data)
    {
        PatientPersonalInfo::updateOrCreate(
            ['user_id' => auth()->user()->id],
            $data
        );
    }

    /**
     *
     * @return patient_unique_id
     */
    public function getPatientId()
    {
        try {
            $record = PatientPersonalInfo::orderBy('id', 'desc')->withTrashed()->firstOrFail();

            $record_id = 'P' . sprintf("%07d", ($record->id + 1));
            return $record_id;
        } catch (\Exception $exception) {


            return 'P0000001';
        }
    }

    public function getPatientFamilyId()
    {

        $master_patient = PatientPersonalInfo::where('user_id', auth()->user()->id)->first();
        $master_patient_id = $master_patient->getMasterPatientId();

        $latest_patient = PatientFamilyMembers::where('user_id', auth()->user()->id)->withTrashed()->count();
        if ($latest_patient > 0) {
            //length of zero 1
            $patient_id = 'F' . sprintf("%02d", ($latest_patient + 1));
            return $patient_id . $master_patient_id;
        }
        return  'F01' . $master_patient_id;
    }

    public function saveEmergencyContact($primary_address, $secondary_address, $id)
    {
        EmergencyContactdetails::updateOrCreate(
            ['user_id' => $id, 'contact_type' => 1],
            $primary_address
        );
        EmergencyContactdetails::updateOrCreate(
            ['user_id' => $id, 'contact_type' => 0],
            $secondary_address
        );
    }
}
