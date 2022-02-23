<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Specializations extends Model
{
    use SoftDeletes;
    public static $page = 10;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function getImageAttribute($value)
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
}
