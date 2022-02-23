<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Reviews extends Model
{
    use SoftDeletes;

    public static $page = 10;
    protected $appends = ['created_time', 'patient_profile_photo'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'to_id',
        'type',
        'rating',
        'title',
        'review'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'type', 'user_id', 'to_id', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function getCreatedTimeAttribute()
    {
        // TODO optimize
        if (!is_null($this->created_at)) {
            return "Reviewed " . $this->created_at->diffForHumans();
        }
        return NULL;
    }
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'to_id');
    }

    public function patient()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function patient_info()
    {
        return $this->hasOne('App\Model\PatientPersonalInfo', 'user_id', 'user_id');
    }

    public function getPatientProfilePhotoAttribute()
    {
        if (!$this->patient()->pluck('profile_photo')->isEmpty()) {
            $photo =  $this->patient()->pluck('profile_photo')[0];
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
        return NULL;
    }

    public static function averageRating($id)
    {
        $avgStar = Reviews::where('to_id', $id)->avg('rating');
        return round($avgStar, 2);
    }
}
