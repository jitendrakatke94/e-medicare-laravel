<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use SoftDeletes;
    public static $page = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id',
        'user_id',
        'recepient_id',
        'type_id',
        'type',
        'total_amount',
        'payment_status',
        'razorpay_payment_id',
        'razorpay_order_id',
        'razorpay_refund_id',
        'razorpay_signature',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'recepient_id', 'type_id', 'type', 'billing_address_id', 'deleted_at', 'updated_at', 'razorpay_payment_id', 'razorpay_order_id', 'razorpay_refund_id', 'razorpay_signature'
    ];
    public function getTaxAmountAttribute($value)
    {
        return round($value, 2);
    }
    public function setTaxAmountAttribute($value)
    {
        $this->attributes['tax'] = round($value, 2);
    }
    public function getCreatedAtAttribute($value)
    {
        return convertToUser($value,  'Y-m-d h:i:s a');
    }

    public function appointments()
    {
        return $this->hasOne('App\Model\Appointments', 'id', 'type_id')->orderBy('created_at', 'desc');
    }
    public function orders()
    {
        return $this->hasOne('App\Model\Orders', 'id', 'type_id')->orderBy('created_at', 'desc');
    }
    public function sales()
    {
        return $this->hasOne('App\Model\Sales', 'payment_id', 'id');
    }
}
