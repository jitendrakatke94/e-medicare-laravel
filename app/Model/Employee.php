<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
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
        'unique_id',
        'father_first_name',
        'father_middle_name',
        'father_last_name',
        'gender',
        'date_of_birth',
        'age',
        'date_of_joining',
        'resume',
        'created_by',
        'updated_by',
        'deactivated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function address()
    {
        return $this->hasMany('App\Model\Address', 'user_id', 'user_id');
    }

    public function getResumeAttribute($resume)
    {
        if ($resume != NULL) {

            if (!empty($resume)) {
                $path = storage_path() . "/app/" . $resume;
                if (file_exists($path)) {
                    $path = Storage::url($resume);
                    return asset($path);
                }
                return NULL;
            }
            return NULL;
        }
        return NULL;
    }
}
