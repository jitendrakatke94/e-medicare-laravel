<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Appointments extends Model
{

    use SoftDeletes;

    public static $page = 10;
    protected $appends = ['booking_date', 'current_patient_info'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'address_id',
        'appointment_unique_id',
        'doctor_time_slots_id',
        'date',
        'time',
        'start_time',
        'end_time',
        'registered_user',
        'consultation_type',
        'shift',
        'payment_status',
        'total',
        'commission',
        'tax',
        'is_cancelled',
        'is_completed',
        'followup_id',
        'patient_info',
        'followup_date',
        'cancel_time',
        'reschedule_time',
        'comment',
        'cancelled_by',
        'reschedule_by',
        'pns_comment',
        'is_refunded',
        'refund_amount',
        'is_valid_pns',
        'admin_pns_comment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'commission', 'patient_info', 'doctor_time_slots_id', 'address_id', 'registered_user', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'time' => 'datetime:h:i A',
        'patient_info' => 'array'
    ];
    public function getCancelledByAttribute($value)
    {
        if (!is_null($value)) {
            $user = User::withTrashed()->find($value);
            if ($user) {
                if ($user->user_type == 'DOCTOR') {
                    return 'Dr. ' . $user->first_name . ' ' . $user->last_name;
                }
                return 'Mr. ' . $user->first_name . ' ' . $user->last_name;
            }
            return NULL;
        }
        return NULL;
    }
    public function getRescheduleByAttribute($value)
    {
        if (!is_null($value)) {
            $user = User::withTrashed()->find($value);
            if ($user) {
                if ($user->user_type == 'DOCTOR') {
                    return 'Dr. ' . $user->first_name . ' ' . $user->last_name;
                }
                return 'Mr. ' . $user->first_name . ' ' . $user->last_name;
            }
            return NULL;
        }
        return NULL;
    }

    public function getRefundAmountAttribute($value)
    {
        return round($value, 2);
    }
    public function setRefundAmountAttribute($value)
    {
        $this->attributes['refund_amount'] = round($value, 2);
    }

    public function getTotalAttribute($value)
    {
        return round($value, 2);
    }
    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = round($value, 2);
    }
    public function getCommissionAttribute($value)
    {
        return round($value, 2);
    }
    public function setCommisionAttribute($value)
    {
        $this->attributes['commission'] = round($value, 2);
    }
    public function getTaxAttribute($value)
    {
        return round($value, 2);
    }
    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = round($value, 2);
    }
    public function getBookingDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }
    public function setTimeAttribute($input)
    {
        $this->attributes['time'] =
            convertToUTC($input,  'H:i:s');
    }
    public function setStartTimeAttribute($input)
    {
        $this->attributes['start_time'] =
            convertToUTC($input,  'H:i:s');
    }
    public function setEndTimeAttribute($input)
    {
        $this->attributes['end_time'] =
            convertToUTC($input,  'H:i:s');
    }

    public function getTimeAttribute($value)
    {
        return convertToUser($value,  'H:i:s');
    }
    public function getStartTimeAttribute($value)
    {
        return convertToUser($value,  'H:i:s');
    }
    public function getEndTimeAttribute($value)
    {
        return convertToUser($value,  'H:i:s');
    }
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'doctor_id')->withTrashed();
    }
    public function patient_details()
    {
        return $this->hasOne('App\User', 'id', 'patient_id')->withTrashed();
    }
    public function doctorinfo()
    {
        return $this->hasOne('App\Model\DoctorPersonalInfo', 'user_id', 'doctor_id')->withTrashed();
    }
    public function patient_more_info()
    {
        return $this->hasOne('App\Model\PatientPersonalInfo', 'user_id', 'patient_id')->withTrashed();
    }

    public function timeslot()
    {
        return $this->hasOne('App\Model\DoctorTimeSlots', 'id', 'doctor_time_slots_id');
    }
    public function timeslotWithTrashed()
    {
        return $this->hasOne('App\Model\DoctorTimeSlots', 'id', 'doctor_time_slots_id')->withTrashed();
    }
    public function prescription()
    {
        return $this->hasOne('App\Model\Prescriptions', 'appointment_id', 'id');
    }
    public function followup()
    {
        return $this->hasMany('App\Model\Followups', 'appointment_id', 'id');
    }
    public function followup_one()
    {
        return $this->hasOne('App\Model\Followups', 'appointment_id', 'id')->latest();
    }
    public function clinic_address()
    {
        return $this->hasOne('App\Model\Address', 'id', 'address_id')->withTrashed();
    }

    public function payments()
    {
        return $this->hasOne('App\Model\Payments', 'type_id', 'id')->where('type', 'APPOINTMENT')->whereNotNull('razorpay_payment_id');
    }

    public function getCurrentPatientInfoAttribute()
    {
        $result = array();
        $result['user'] = array(
            'first_name' => $this->patient_details['first_name'],
            'middle_name' => $this->patient_details['middle_name'],
            'last_name' => $this->patient_details['last_name'],
            'email' => $this->patient_details['email'],
            'country_code' => $this->patient_details['country_code'],
            'mobile_number' => $this->patient_details['mobile_number'],
            'profile_photo_url' => $this->patient_details['profile_photo_url'],
        );

        if (!is_null($this->patient_info)) {
            $result['case'] = $this->patient_info['case'];
            if ($this->patient_info['case'] == 1) {
                $result['info'] = array(
                    'first_name' => $this->patient_details['first_name'],
                    'middle_name' => $this->patient_details['middle_name'],
                    'last_name' => $this->patient_details['last_name'],
                    'email' => $this->patient_details['email'],
                    'country_code' => $this->patient_details['country_code'],
                    'mobile_number' => $this->patient_details['mobile_number'],
                    'height' => $this->patient_more_info['height'],
                    'weight' => $this->patient_more_info['weight'],
                    'gender' => $this->patient_more_info['gender'],
                    'age' => $this->patient_more_info['age'],
                );
            } else if ($this->patient_info['case'] == 2) {
                $family = PatientFamilyMembers::withTrashed()->find($this->patient_info['id']);

                if ($family) {
                    $result['info'] = array(
                        'first_name' => $family->first_name,
                        'middle_name' => $family->middle_name,
                        'last_name' => $family->last_name,
                        'email' => $this->patient_info['email'],
                        'country_code' => $this->patient_info['patient_mobile_code'],
                        'mobile_number' => $this->patient_info['patient_mobile'],
                        'height' => $family->height,
                        'weight' => $family->weight,
                        'gender' => $family->gender,
                        'age' => $family->age,
                        'id' => $family->id,
                    );
                }
            } else {
                $result['info'] = array(
                    'first_name' => $this->patient_info['first_name'],
                    'middle_name' => $this->patient_info['middle_name'],
                    'last_name' => $this->patient_info['last_name'],
                    'email' => $this->patient_info['email'],
                    'country_code' => $this->patient_info['patient_mobile_code'],
                    'mobile_number' => $this->patient_info['patient_mobile'],
                    'height' => NULL,
                    'weight' => NULL,
                    'gender' => NULL,
                    'age' => NULL,
                );
            }

            $address_find = Address::where('user_id', $this->patient_id)->where('address_type', 'HOME')->first();
            if (empty($address_find)) {
                $address_find = Address::withTrashed()->where('user_id', $this->patient_id)->where('address_type', 'HOME')->first();
            }

            $result['address'] = $address_find;
        }
        return $result;
    }
}
