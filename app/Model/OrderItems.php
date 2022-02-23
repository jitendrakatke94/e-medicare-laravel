<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    public static $page = 10;
    protected $appends = ['item_details'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'item_id',
        'type',
        'price',
        'quantity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'order_id', 'type', 'created_at', 'updated_at'
    ];

    public function getPriceAttribute($value)
    {
        return round($value, 2);
    }
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = round($value, 2);
    }

    public function getItemDetailsAttribute()
    {
        $record = NULL;
        if ($this->type == 'MED') {
            $record = Medicine::withTrashed()->find($this->item_id);
        } else {
            $record = LabTest::withTrashed()->find($this->item_id);
        }
        return $record;
    }
}
