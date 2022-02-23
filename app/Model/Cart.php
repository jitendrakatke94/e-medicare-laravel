<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    public static $page = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tax',
        'subtotal',
        'discount',
        'coupon_id',
        'delivery_charge',
        'total',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'coupon_id', 'deleted_at', 'updated_at', 'created_at'
    ];

    public function cart_items()
    {
        return $this->hasMany('App\Model\CartItems', 'cart_id', 'id');
    }
}
