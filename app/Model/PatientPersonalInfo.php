<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientPersonalInfo extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['patient_profile_photo'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'patient_unique_id',
        'title',
        'gender',
        'date_of_birth',
        'age',
        'blood_group',
        'height',
        'weight',
        'marital_status',
        'occupation',
        'alt_country_code',
        'alt_mobile_number',
        'current_medication',
        'bpl_file_number',
        'bpl_file_name',
        'bpl_file_path',
        'national_health_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'bpl_file_path', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function getMasterPatientId()
    {
        return $this->patient_unique_id;
    }

    public function family()
    {
        return $this->hasMany('App\Model\PatientFamilyMembers', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function address()
    {
        return $this->hasMany('App\Model\Address', 'user_id', 'user_id');
    }

    public function getPatientProfilePhotoAttribute()
    {
        if (Auth::check()) {
            $user = User::find(auth()->user()->id);
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
}
