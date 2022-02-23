<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    public static $page = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'address_type',
        'street_name',
        'city_village',
        'district',
        'state',
        'country',
        'pincode',
        'contact_number',
        'land_mark',
        'latitude',
        'longitude',
        'clinic_name',
        'created_by',
        'updated_by',
        'deactivated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'address_type', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function clinicInfo()
    {
        return $this->hasOne('App\Model\DoctorClinicDetails');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Model\DoctorPersonalInfo', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function pharmacy()
    {
        return $this->hasOne('App\Model\Pharmacy', 'user_id', 'user_id');
    }

    public function laboratory()
    {
        return $this->hasOne('App\Model\LaboratoryInfo', 'user_id', 'user_id');
    }

    public function timeslot()
    {
        return $this->hasManyThrough(
            'App\Model\DoctorTimeSlots',
            'App\Model\DoctorClinicDetails',
            'address_id', // Foreign key on DoctorClinicDetails table...
            'doctor_clinic_id', // Foreign key on DoctorTimeSlots table...
            'id', // Local key on DoctorTimeSlots table...
            'id' // Local key on DoctorClinicDetails table...
        );
    }
}
