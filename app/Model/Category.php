<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['image_url'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'image_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'image_path', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function parent()
    {
        return $this->hasMany('App\Model\Category', 'parent_id');
    }
    public function medicine()
    {
        return $this->hasMany('App\Model\Medicine', 'category_id');
    }
    public function getImageUrlAttribute()
    {
        if ($this->image_path != NULL) {
            $path = storage_path() . "/app/" . $this->image_path;
            if (file_exists($path)) {
                $path = Storage::url($this->image_path);
                return asset($path);
            }
            return NULL;
        }
        return NULL;
    }
}
