<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    public static $page = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id',
        'item_id',
        'type',
        'price',
        'quantity',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function medicine()
    {
        return $this->hasOne('App\Model\Medicine', 'id', 'item_id');
    }
    public function test()
    {
        return $this->hasOne('App\Model\LabTest', 'id', 'item_id');
    }
}
