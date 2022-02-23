<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCommissions extends Model
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
        'online',
        'in_clinic',
        'emergency'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function doctorinfo()
    {
        return $this->hasOne('App\Model\DoctorPersonalInfo', 'user_id', 'user_id');
    }
}
