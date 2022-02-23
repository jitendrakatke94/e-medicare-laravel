<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrescriptionMedList extends Model
{
    public static $page = 10;
    protected $appends = ['medicine_status', 'medicine_name', 'dispense_from', 'show_status'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prescription_id',
        'quote_generated',
        'medicine_id',
        'dosage',
        'instructions',
        'duration',
        'no_of_refill',
        'substitution_allowed',
        'status',
        'quantity',
        'note'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function getMedicineStatusAttribute()
    {
        if ($this->status == 0) {
            return 'Dispensed at clinic.';
        } elseif ($this->status == 2) {
            return 'Dispensed outside.';
        } else {
            return 'Dispensed at associated pharmacy.';
        }
    }


    public function getDispenseFromAttribute()
    {
        if ($this->status == 0) {
            return 'Clinic';
        } elseif ($this->status == 2) {
            return 'Outside pharmacy';
        } else {
            return 'Associated pharmacy';
        }
    }

    public function getMedicineNameAttribute()
    {
        if (!is_null($this->medicine)) {
            return $this->medicine->name;
        }
        return NULL;
    }

    public function medicine()
    {
        return $this->hasOne('App\Model\Medicine', 'id', 'medicine_id')->withTrashed();
    }

    public function getShowStatusAttribute()
    {
        $quote = QuoteRequest::with('pharmacy')->where('prescription_id', $this->prescription_id)->whereJsonContains('quote_details', $this->medicine_id)->where('type', 'MED');
        $show_status = 'NA';
        if ($quote) {
            if ($this->status == 1) { // associate
                $quote = $quote->where('quote_type', '1')->first();
                if ($quote) {
                    $show_status = $quote->pharma_lab_status;
                    if ($quote->pharma_lab_status == 'Dispensed') {
                        $show_status = $quote->pharma_lab_status . ' - ' . $quote->pharmacy->pharmacy_name;
                    }
                }
            } elseif ($this->status == 2) {
                $quote = $quote->where('quote_type', '2')->where('status', '1')->first();
                $show_status = 'NA';
                if ($this->quote_generated == 0) {
                    $show_status = 'Quote not Requested';
                } elseif ($this->quote_generated == 1) {
                    $show_status = 'Quote Requested';
                    if ($quote) {
                        $show_status = 'Quote Received';
                    }
                }
            }
        }
        return $show_status;
    }
}
