<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class LaboratoryInfo extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['lab_file'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'laboratory_unique_id',
        'laboratory_name',
        'alt_mobile_number',
        'alt_country_code ',
        'gstin',
        'lab_reg_number',
        'lab_issuing_authority',
        'lab_date_of_issue',
        'lab_valid_upto',
        'lab_file_path',
        'sample_collection',
        'order_amount',
        'lab_tests',
        'payout_period'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'lab_file_path', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];
    protected $casts = [
        'lab_tests' => 'array',
    ];

    public function getLabFileAttribute()
    {
        if ($this->lab_file_path != NULL) {

            $photo =  $this->lab_file_path;

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
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function address()
    {
        return $this->hasMany('App\Model\Address', 'user_id', 'user_id');
    }
    public function bankAccountDetails()
    {
        return $this->hasMany('App\Model\BankAccountDetails', 'user_id', 'user_id');
    }
}
