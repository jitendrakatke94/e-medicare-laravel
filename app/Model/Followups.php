<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Followups extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['enable_followup'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appointment_id',
        'followup_date',
        'doctor_id',
        'patient_id',
        'clinic_id',
        'last_vist_date',
        'is_cancelled',
        'is_completed',
        'parent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'parent_id', 'appointment_id', 'clinic_id', 'patient_id', 'deleted_at', 'created_at', 'updated_at'
    ];
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'doctor_id');
    }
    public function appointment()
    {
        return $this->hasOne('App\Model\Appointments', 'id', 'appointment_id');
    }

    public function getEnableFollowupAttribute()
    {
        if (Carbon::now()->lte(Carbon::parse($this->followup_date))) {
            return true;
        }
        return false;
    }
    public function clinic_address()
    {
        return $this->hasOne('App\Model\Address', 'id', 'clinic_id');
    }
    public function parent()
    {
        return $this->hasMany('App\Model\Followups', 'parent_id', 'appointment_id')->withTrashed();
    }
}
