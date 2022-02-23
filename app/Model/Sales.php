<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes;
    public static $page = 10;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payout_id',
        'payment_id',
        'service',
        'type',
        'type_id',
        'user_id',
        'total',
        'paid', //not used
        'payment_complete',
        'tax_amount',
        'earnings',
        'payable_to_vendor',
        'pdf_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'type', 'user_id', 'type_id', 'paid', 'deleted_at', 'updated_at'
    ];

    public function getTaxAmountAttribute($value)
    {
        return round($value, 2);
    }
    public function setTaxAmountAttribute($value)
    {
        $this->attributes['tax_amount'] = round($value, 2);
    }
    public function getTotalAttribute($value)
    {
        return round($value, 2);
    }
    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = round($value, 2);
    }
    public function getEarningsAttribute($value)
    {
        return round($value, 2);
    }
    public function setEarningsAttribute($value)
    {
        $this->attributes['earnings'] = round($value, 2);
    }

    public function getPayableToVendorAttribute($value)
    {
        return round($value, 2);
    }
    public function setPayableToVendorAttribute($value)
    {
        $this->attributes['payable_to_vendor'] = round($value, 2);
    }

    public function getCreatedAtAttribute($value)
    {
        return convertToUser($value,  'Y-m-d h:i:s a');
    }

    public function patient()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function pharmacy()
    {
        return $this->hasOne('App\Model\Pharmacy', 'user_id', 'type_id');
    }
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'type_id');
    }
    public function labortory()
    {
        return $this->hasOne('App\Model\LaboratoryInfo', 'user_id', 'type_id');
    }
    public function payment()
    {
        return $this->hasOne('App\Model\Payments', 'id', 'payment_id');
    }
}
