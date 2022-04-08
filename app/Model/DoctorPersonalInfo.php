<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DoctorPersonalInfo extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['doctor_profile_photo', 'average_rating', 'added_by'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'doctor_unique_id',
        'title',
        'gender',
        'date_of_birth',
        'age',
        'qualification',
        'specialization',
        'years_of_experience',
        'alt_country_code',
        'alt_mobile_number',
        'clinic_name',
        'career_profile',
        'education_training',
        'experience',
        'clinical_focus',
        'awards_achievements',
        'memberships',
        'appointment_type_online',
        'appointment_type_offline',
        'consulting_online_fee',
        'consulting_offline_fee',
        'available_from_time',
        'available_to_time',
        'service',
        'emergency_fee',
        'emergency_appointment',
        'no_of_followup',
        'followups_after',
        'cancel_time_period',
        'reschedule_time_period',
        'payout_period',
        'registration_number',
        'time_intravel',
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
        'added_by', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function address()
    {
        return $this->hasMany('App\Model\Address', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function getAddedByAttribute()
    {
        $user = User::find($this->user->created_by);
        $name = array('first_name' => NULL, 'middle_name' => NULL, 'last_name' => NULL);
        if ($user) {
            $name['first_name'] = $user->first_name;
            $name['middle_name'] = $user->middle_name;
            $name['last_name'] = $user->last_name;
        }
        return $name;
    }

    public function specialization()
    {
        return $this->belongsToMany('App\Model\Specializations');
    }

    public function addressFirst()
    {
        return $this->address()->where('address_type', 'CLINIC')->limit(1);
    }
    public function timeslot()
    {
        return $this->hasMany('App\Model\DoctorTimeSlots', 'user_id', 'user_id');
    }
    public function addresswithtime()
    {
        return $this->hasMany('App\Model\Address', 'id', 'address_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Model\Reviews', 'to_id', 'user_id');
    }

    public function bankAccountDetails()
    {
        return $this->hasMany('App\Model\BankAccountDetails', 'user_id', 'user_id');
    }

    public function getDoctorProfilePhotoAttribute()
    {
        if (Auth::check()) {
            $user = User::find(auth()->user()->id);
            if ($this->user_id != $user->id) {
                $user = User::find($this->user_id);
            }
        } else {
            $user = User::find($this->user_id);
        }

        if (!$user) {
            return NULL;
        }
        if ($user->profile_photo != NULL) {

            $photo =  $user->profile_photo;

            if (!empty($photo)) {
                $path = storage_path() . "/app/" . $photo;
                if (file_exists($path)) {
                    $path = Storage::url($photo);
                    return asset($path);
                }
                return NULL;
            }
            return NULL;
        }
        return NULL;
    }
    public function getAverageRatingAttribute()
    {
        return Reviews::where('to_id', $this->user_id)->avg('rating');
    }

    public function appointments()
    {
        return $this->hasMany('App\Model\Appointments', 'doctor_id', 'user_id')->withTrashed();
    }

    public function favouriteDoctors() {
        return $this->hasOne('App\Model\FavouriteDoctors', 'doctor_id', 'id');
    }
}
