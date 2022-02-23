<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use SoftDeletes;
    public static $page = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to_user_id',
        'from_user_id',
        'comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'to_user_id', 'from_user_id', 'deleted_at', 'updated_at', 'created_at'
    ];

    public function to_user()
    {
        return $this->hasOne('App\User', 'id', 'to_user_id');
    }
    public function from_user()
    {
        return $this->hasOne('App\User', 'id', 'from_user_id');
    }
}
