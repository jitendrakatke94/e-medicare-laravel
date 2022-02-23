<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Medicine extends Model
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
        'category_id',
        'sku',
        'composition',
        'weight',
        'weight_unit',
        'name',
        'manufacturer',
        'medicine_type',
        'drug_type',
        'price_per_strip',
        'qty_per_strip',
        'rate_per_unit',
        'rx_required',
        'short_desc',
        'long_desc',
        'cart_desc',
        'image_name',
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
        'image_path', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->hasOne('App\Model\Category', 'id', 'category_id');
    }

    public function getImageUrlAttribute()
    {
        $result = array();
        if ($this->image_path != NULL) {
            $images = json_decode($this->image_path, true);
            if (empty($images)) {
                return $result;
            }

            foreach ($images as $key => $image) {
                $path = storage_path() . "/app/public/uploads/medicine/" . $image['image_name'];
                if (file_exists($path)) {
                    $path = Storage::url("public/uploads/medicine/" . $image['image_name']);
                    $result[] = asset($path);
                }
            }
        }
        return $result;
    }
}
