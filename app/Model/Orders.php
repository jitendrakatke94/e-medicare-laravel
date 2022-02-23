<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Orders extends Model
{
    use SoftDeletes;
    public static $page = 10;
    //protected $appends = ['prescription_file'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id',
        'user_id',
        'quote_id',
        'tax',
        'subtotal',
        'discount',
        'delivery_charge',
        'total',
        'commission',
        'billing_address_id',
        'shipping_address_id',
        'pharma_lab_id',
        'type',
        'payment_status',
        'delivery_status',
        'delivery_info',
        'file_path',
        'need_delivery',
        'bill_path',
        'sample_collect',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'file_path', 'commission', 'quote_id', 'type', 'pharma_lab_id', 'billing_address_id', 'deleted_at', 'updated_at'
    ];
    protected $casts = [
        'sample_collect' => 'array'
    ];
    public function getTaxAttribute($value)
    {
        return round($value, 2);
    }
    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = round($value, 2);
    }
    public function getSubTotalAttribute($value)
    {
        return round($value, 2);
    }
    public function setSubTotalAttribute($value)
    {
        $this->attributes['subtotal'] = round($value, 2);
    }
    public function getDiscountAttribute($value)
    {
        return round($value, 2);
    }
    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = round($value, 2);
    }
    public function getDeliveryChargeAttribute($value)
    {
        return round($value, 2);
    }
    public function setDeliveryChargeAttribute($value)
    {
        $this->attributes['delivery_charge'] = round($value, 2);
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

    public function getCreatedAtAttribute($value)
    {
        return convertToUser($value,  'Y-m-d h:i:s a');
    }
    public function billing_address()
    {
        return $this->hasMany('App\Model\Address', 'id', 'shipping_address_id');
    }
    public function payments()
    {
        return $this->hasOne('App\Model\Payments', 'type_id', 'id')->where('type', 'ORDER')->orderBy('created_at', 'desc');
    }
    public function quote()
    {
        return $this->hasOne('App\Model\Quotes', 'id', 'quote_id');
    }
    public function order_items()
    {
        return $this->hasMany('App\Model\OrderItems', 'order_id', 'id');
    }
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function quote_contact()
    {
        return $this->hasOne('App\User', 'id', 'pharma_lab_id');
    }
    public function getPrescriptionFileAttribute()
    {
        $photo =  $this->file_path;
        if (!is_null($photo)) {
            $path = storage_path() . "/app/" . $photo;
            if (file_exists($path)) {
                $path = Storage::url($photo);
                return asset($path);
            }
            return NULL;
        }
        return NULL;
    }
    public function getBillPathAttribute($value)
    {
        if (!is_null($value)) {
            $path = storage_path() . "/app/" . $value;
            if (file_exists($path)) {
                $path = Storage::url($value);
                return asset($path);
            }
            return NULL;
        }
        return NULL;
    }
    public function getDeliveryInfoAttribute($value)
    {
        if ($this->type == 'LAB') {
            $photo =  $value;
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
        return $value;
    }
}
