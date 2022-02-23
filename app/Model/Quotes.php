<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotes extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['medicine', 'test', 'quote_from'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id',
        'quote_request_id',
        'prescription_id',
        'pharma_lab_id',
        'quote_details',
        'status',
        'file_path',
        'type',
        'is_pdf_generated',
        'valid_till'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'status', 'quote_request_id', 'quote_details', 'file_path', 'prescription_id', 'is_pdf_generated', 'pharma_lab_id', 'deleted_at', 'updated_at'
    ];

    protected $casts = [
        'quote_details' => 'array',
    ];
    public function getCreatedAtAttribute($value)
    {
        return convertToUser($value,  'Y-m-d h:i:s a');
    }
    public function prescription()
    {
        return $this->hasOne('App\Model\Prescriptions', 'id', 'prescription_id');
    }
    public function quote_request()
    {
        return $this->hasOne('App\Model\QuoteRequest', 'id', 'quote_request_id');
    }

    public function getQuoteFromAttribute()
    {
        $result['id'] = NULL;
        $result['name'] = NULL;
        $result['address'] = NULL;
        if ($this->type == 'MED') {
            $result['id'] = $this->pharmacy->user_id;
            $result['name'] = $this->pharmacy->pharmacy_name;
            $result['address'] = $this->pharmacy->address;
            $result['home_delivery'] = $this->pharmacy->home_delivery;
            $result['order_amount'] = $this->pharmacy->order_amount;
        } elseif ($this->type == 'LAB') {
            $result['id'] = $this->laboratory->user_id;
            $result['name'] = $this->laboratory->laboratory_name;
            $result['sample_collection'] = $this->laboratory->sample_collection;
            $result['order_amount'] = $this->laboratory->order_amount;
            $result['address'] = $this->laboratory->address;
        }
        return $result;
    }
    public function pharmacy()
    {
        return $this->hasOne('App\Model\Pharmacy', 'id', 'pharma_lab_id');
    }
    public function laboratory()
    {
        return $this->hasOne('App\Model\LaboratoryInfo', 'id', 'pharma_lab_id');
    }
    public function order()
    {
        return $this->hasOne('App\Model\Orders', 'quote_id', 'id')->orderBy('created_at', 'desc');
    }
    public function getMedicineAttribute()
    {

        $medicine_list = $data =  array();
        if (!empty($this->quote_details['medicine_list'])) {
            $medicine_list['total'] = $this->quote_details['total'];
            $medicine_list['discount'] = isset($this->quote_details['discount']) ? $this->quote_details['discount'] : NULL;
            $medicine_list['delivery_charge'] =
                isset($this->quote_details['delivery_charge']) ? $this->quote_details['delivery_charge'] : NULL;
            foreach ($this->quote_details['medicine_list'] as $key => $value) {
                $value['medicine'] = Medicine::withTrashed()->find($value['medicine_id']);

                $data[] = $value;
            }
            $medicine_list['medicine_list'] = $data;
        }
        return $medicine_list;
    }

    public function getTestAttribute()
    {
        $test_list = $data =  array();
        if (!empty($this->quote_details['test_list'])) {
            $test_list['discount'] = isset($this->quote_details['discount']) ? $this->quote_details['discount'] : NULL;
            $test_list['delivery_charge'] =
                isset($this->quote_details['delivery_charge']) ? $this->quote_details['delivery_charge'] : NULL;
            $test_list['total'] = $this->quote_details['total'];
            foreach ($this->quote_details['test_list'] as $key => $value) {
                $value['test'] = LabTest::withTrashed()->find($value['test_id']);

                $data[] = $value;
            }
            $test_list['test_list'] = $data;
        }
        return $test_list;
    }
}
