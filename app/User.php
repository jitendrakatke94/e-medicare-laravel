<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Model\OTPVerifications;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, SoftDeletes;
    public static $page = 10;
    protected $appends = ['profile_photo_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'username',
        'country_code',
        'mobile_number',
        'password',
        'user_type',
        'login_type',
        'is_active',
        'first_login',
        'profile_photo',
        'role',
        'currency_code',
        'email_verified_at',
        'mobile_number_verified_at',
        'timezone',
        'comment',
        'created_by',
        'updated_by',
        'deactivated_by',
        'approved',
        'approved_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'timezone', 'first_login', 'password', 'remember_token', 'email_verified_at', 'mobile_number_verified_at', 'login_type', 'approved', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_number_verified_at' => 'datetime',
        'role' => 'array'
    ];

    public function hasVerifiedMobileNumber()
    {
        return !is_null($this->mobile_number_verified_at);
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function markMobileNumberAsVerified()
    {
        return $this->forceFill([
            'mobile_number_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function updatePassword($password)
    {
        return $this->forceFill([
            'password' => bcrypt($password),
        ])->save();
    }

    public function fillVerificationCode($user_id, $otp, $key, $type)
    {
        OTPVerifications::updateOrCreate(
            [
                'user_id' => $user_id,
                'type' => $type
            ],
            [
                'user_id' => $user_id,
                'type' => $type,
                'otp' => $otp,
                'key' => $key,
            ]
        );
        return;
    }
    public function address()
    {
        return $this->hasMany('App\Model\Address');
    }

    public function pharmacy()
    {
        return $this->hasOne('App\Model\Pharmacy', 'user_id', 'id');
    }
    public function laboratory()
    {
        return $this->hasOne('App\Model\LaboratoryInfo', 'user_id', 'id');
    }

    public function bankAccountDetails()
    {
        return $this->hasMany('App\Model\BankAccountDetails');
    }

    public function doctor()
    {
        return $this->hasOne('App\Model\DoctorPersonalInfo');
    }
    public function patient()
    {
        return $this->hasOne('App\Model\PatientPersonalInfo');
    }

    public function user_commission()
    {
        return $this->hasOne('App\Model\UserCommissions');
    }

    public function family()
    {
        return $this->hasMany('App\Model\PatientFamilyMembers');
    }

    public function employee()
    {
        return $this->hasOne('App\Model\Employee', 'user_id', 'id');
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo != NULL) {

            $photo =  $this->profile_photo;

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
