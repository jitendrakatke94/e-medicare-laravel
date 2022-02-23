<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class LabTest extends Model
{
    use SoftDeletes;

    public static $page = 10;
    protected $appends = ['image'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'unique_id',
        'price',
        'currency_code',
        'code',
        'image_path',
        'created_by',
        'updated_by',
        'deactivated_by',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'type', 'image_path', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function getImageAttribute()
    {
        if ($this->image_path != NULL) {

            $photo =  $this->image_path;
            if (!empty($photo)) {
                $path = storage_path() . "/app/" . $photo;
                if (file_exists($path)) {
                    $path = Storage::url($photo);
                    return asset($path);
                }
                return NULL;
            }
            return NULL;
        }
    }
}
