<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteRequest extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['medicine_list', 'test_list', 'prescription'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prescription_id',
        'pharma_lab_id',
        'unique_id',
        'quote_details',
        'quote_reply',
        'status', // 0 sent, 1 generated, 2 not replied or rejected
        'pharma_lab_status',
        'bill_path',
        'quote_type',
        'submission_date',
        'file_path',
        'type',
        'report_path',
        'bill_number',
        'bill_amount',
        'bill_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'bill_path', 'report_path', 'quote_details', 'pharma_lab_id', 'deleted_at', 'updated_at'
    ];

    protected $casts = [
        'quote_details' => 'array',
        'quote_reply' => 'array',
        'created_at' => 'datetime:Y-m-d h:i:s a'
    ];

    public function getBillAmountAttribute($value)
    {
        return round($value, 2);
    }
    public function setBillAmountAttribute($value)
    {
        $this->attributes['bill_amount'] = round($value, 2);
    }

    public function getCreatedAtAttribute($value)
    {
        return convertToUser($value,  'Y-m-d h:i:s a');
    }
    public function getQuoteTypeAttribute($value)
    {
        if (!is_null($value)) {
            if ($value == 0) {
                return 'Direct purchase.';
            } else if ($value == 1) {
                return 'Added by doctor.';
            } else if ($value == 2) {
                return 'Added from prescription.';
            }
        }
        return NULL;
    }

    public function getPrescriptionAttribute()
    {
        $result['pdf_url'] = NULL;
        $result['prescription_unique_id'] = NULL;

        if (!is_null($this->appointment)) {
            $prescription = Prescriptions::where('appointment_id', $this->appointment->id)->first();
            if ($prescription) {
                $result['pdf_url'] = $prescription->pdf_url;
                $result['prescription_unique_id'] = $prescription->unique_id;
            }
        }
        return $result;
    }

    public function getMedicineListAttribute()
    {
        $medicine_list = array();
        if (!empty($this->quote_details)) {
            foreach ($this->quote_details as $key => $id) {
                $record = PrescriptionMedList::with('medicine')->where('prescription_id', $this->prescription_id)->where('medicine_id', $id)->first();
                $medicine_list[] = $record;
            }
        }
        return $medicine_list;
    }

    public function getTestListAttribute()
    {
        $test_list = array();
        if (!empty($this->quote_details)) {
            foreach ($this->quote_details as $key => $id) {
                $test_list[] = PrescriptionTestList::where('prescription_id', $this->prescription_id)->where('lab_test_id', $id)->first();
            }
        }
        return $test_list;
    }
    public function prescription()
    {
        return $this->hasOne('App\Model\Prescriptions', 'id', 'prescription_id');
    }
    public function pharmacy()
    {
        return $this->hasOne('App\Model\Pharmacy', 'id', 'pharma_lab_id');
    }
    public function laboratory()
    {
        return $this->hasOne('App\Model\LaboratoryInfo', 'id', 'pharma_lab_id');
    }
}
