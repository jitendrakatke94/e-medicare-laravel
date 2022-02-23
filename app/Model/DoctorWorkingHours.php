<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DoctorWorkingHours extends Model
{
    public static $page = 10;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'doctor_clinic_id',
        'shift',
        'type',
        'day',
        'working_hours'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'user_id', 'doctor_clinic_id', 'updated_at', 'created_at',
    ];

    protected $casts = [
        'working_hours' => 'array',
    ];

    public function address()
    {
        return $this->hasOneThrough(
            'App\Model\Address',
            'App\Model\DoctorClinicDetails',
            'id', // Foreign key on DoctorClinicDetails table...
            'id', // Foreign key on DoctorTimeSlots table...
            'doctor_clinic_id', // Local key on DoctorTimeSlots table...
            'address_id' // Local key on DoctorClinicDetails table...
        );
    }
}
