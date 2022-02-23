<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTestList extends Model
{
    public static $page = 10;
    protected $appends = ['test_status', 'test_name', 'dispense_from', 'show_status'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prescription_id',
        'lab_test_id',
        'quote_generated',
        'status',
        'instructions',
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

    public function getTestStatusAttribute()
    {
        if ($this->status == 0) {
            return 'Dispensed at clinic.';
        } elseif ($this->status == 2) {
            return 'To be dispensed.';
        } else {
            return 'Dispensed at associated laboratory.';
        }
    }

    public function getDispenseFromAttribute()
    {
        if ($this->status == 0) {
            return 'Clinic';
        } elseif ($this->status == 2) {
            return 'Outside Laboratory';
        } else {
            return 'Associated Laboratory';
        }
    }

    public function getTestNameAttribute()
    {
        if (!is_null($this->test)) {
            return $this->test->name;
        }
        return NULL;
    }

    public function test()
    {
        return $this->hasOne('App\Model\LabTest', 'id', 'lab_test_id')->withTrashed();
    }

    public function getShowStatusAttribute()
    {
        $quote = QuoteRequest::with('laboratory')->where('prescription_id', $this->prescription_id)->whereJsonContains('quote_details', $this->lab_test_id)->where('type', 'LAB');
        $show_status = 'NA';
        if ($quote) {
            if ($this->status == 1) { // associate
                $quote = $quote->where('quote_type', '1')->first();
                if ($quote) {
                    $show_status = $quote->pharma_lab_status;
                    if ($quote->pharma_lab_status == 'Dispensed') {
                        $show_status = $quote->pharma_lab_status . ' - ' . $quote->laboratory->laboratory_name;
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
