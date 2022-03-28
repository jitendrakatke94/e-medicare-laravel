<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offers extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'unique_offer_id',
        'counpon_code',
        'discount_amount',
        'maximum_order_count',
        'created_date',
        'expiry_date'
    ];
}
