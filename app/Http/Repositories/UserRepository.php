<?php

namespace App\Http\Repositories;

use App\Model\BankAccountDetails;
use App\Model\DoctorPersonalInfo;
use App\Model\PatientPersonalInfo;
use App\Model\UserCommissions;
use App\User;
use Carbon\Carbon;

class UserRepository
{
    public function create($data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->assignRole(strtolower($user->user_type));
        // to check user is added by admin
        $user->created_by = $user->id;
        if ($data['user_type'] == 'PATIENT') {
            $patient['user_id'] = $user->id;
            $patient['patient_unique_id'] = getPatientId();
            //making patient active after registration
            $user->is_active = '1';
            PatientPersonalInfo::create($patient);
        } else if ($data['user_type'] == 'DOCTOR') {
            //making doctor to update details in dashboard
            $user->is_active = '3';
            $doctor['user_id'] = $user->id;
            $doctor['doctor_unique_id'] = getDoctorId();
            DoctorPersonalInfo::create($doctor);
            BankAccountDetails::create(['user_id' => $user->id]);
            UserCommissions::create(['unique_id' => getUserCommissionId(), 'user_id' => $user->id]);
        }
        $user->created_by = $user->id;
        $user->save();
        return $user;
    }

    public function update($id, $data)
    {
        User::findOrFail($id)->update($data);
    }
}
