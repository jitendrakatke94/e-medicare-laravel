<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PatientFamilyHistory extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['date', 'doctor_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_id',
        'unique_id',
        'details',
        'child_info'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'patient_id', 'doctor_id', 'appointment_id', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getDoctorNameAttribute()
    {
        $user = User::find($this->doctor_id);
        return $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
    }
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'doctor_id');
    }
}
