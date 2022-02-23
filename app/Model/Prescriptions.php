<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Prescriptions extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['pdf_url', 'status_medicine'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'appointment_id',
        'unique_id',
        'type',
        'info',
        'medicine_list',
        'test_list',
        'file_path',
        'is_quote_generated',
        'purchase_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'type', 'medicine_list', 'test_list', 'file_path', 'is_quote_generated', 'deleted_at', 'updated_at',
    ];

    protected $casts = [
        'info' => 'array',
        'medicine_list' => 'array',
        'test_list' => 'array',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function appointment()
    {
        return $this->hasOne('App\Model\Appointments', 'id', 'appointment_id');
    }
    public function patient()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function medicinelist()
    {
        return $this->hasMany('App\Model\PrescriptionMedList', 'prescription_id', 'id');
    }
    public function testlist()
    {
        return $this->hasMany('App\Model\PrescriptionTestList', 'prescription_id', 'id');
    }

    public function getPurchaseTypeAttribute($value)
    {
        if (!is_null($value)) {
            return 'Ecommerce';
        }
        return 'Appointment';
    }

    public function getPdfUrlAttribute()
    {
        if ($this->file_path != NULL) {

            $photo =  $this->file_path;
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

    public function doctor()
    {
        return $this->hasOneThrough(
            'App\User',
            'App\Model\Appointments',
            'id', // Foreign key on Appointments table...
            'id', // Foreign key on User table...
            'appointment_id', // Local key on prescription table...
            'doctor_id' // Local key on Appointments table...
        );
    }
    public function getStatusMedicineAttribute()
    {
        $flag = array();
        if (!empty($this->medicinelist)) {
            foreach ($this->medicinelist as $key => $medicinelist) {
                $flag[] = $medicinelist->quote_generated;
            }
        }
        if (!empty($this->testlist)) {
            foreach ($this->testlist as $key => $testlist) {
                $flag[] = $testlist->quote_generated;
            }
        }

        if (empty($flag)) {
            return 'NA';
        }
        if (in_array(0, $flag) && in_array(1, $flag)) {
            return 'Partially Requested';
        } else if (in_array(1, $flag, true)) {
            return 'Requested';
        }
        return 'Not Requested';
    }
}
