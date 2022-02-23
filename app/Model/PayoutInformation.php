<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayoutInformation extends Model
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
        'amount',
        'reference',
        'comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return convertToUser($value,  'Y-m-d h:i:s a');
    }

    public function getAmountAttribute($value)
    {
        return round($value, 2);
    }
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = round($value, 2);
    }
}
