<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class DoctorTimeSlots extends Model
{
    public static $page = 10;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected static function booted()
    {
        static::addGlobalScope('SkipWorkingHoursByDefault', function (Builder $builder) {
            $builder->where('parent_id',"<>",null);
        });
    }

    protected $fillable = [
        'user_id',
        'day',
        'slot_start',
        'slot_end',
        'type',
        'doctor_clinic_id',
        'shift'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function setSlotStartAttribute($input)
    {
        $this->attributes['slot_start'] =
            convertToUTC($input,  'H:i:s');
    }

    public function getSlotStartAttribute($value)
    {
        return convertToUser($value,  'H:i:s');
    }
    public function setSlotEndAttribute($input)
    {
        $this->attributes['slot_end'] =
            convertToUTC($input,  'H:i:s');
    }

    public function getSlotEndAttribute($value)
    {
        return convertToUser($value,  'H:i:s');
    }

    public function timeSlots(){
        return $this->hasMany("App\Model\DoctorTimeSlots","parent_id","id")->orderBy("slot_start","asc");
    }

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
