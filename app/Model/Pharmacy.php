<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Pharmacy extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['dl_file', 'reg_certificate'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'pharmacy_unique_id',
        'alt_mobile_number',
        'alt_country_code',
        'course',
        'dl_date_of_issue',
        'dl_file_path',
        'dl_issuing_authority',
        'dl_number',
        'dl_valid_upto',
        'gstin',
        'home_delivery',
        'issuing_authority',
        'order_amount',
        'pharmacist_reg_number',
        'pharmacy_name',
        'pharmacist_name',
        'reg_certificate_path',
        'reg_date',
        'reg_valid_upto',
        'payout_period',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'dl_file_path', 'reg_certificate_path', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function getDlFileAttribute()
    {
        if ($this->dl_file_path != NULL) {

            $photo =  $this->dl_file_path;

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
    public function getRegCertificateAttribute()
    {
        if ($this->reg_certificate_path != NULL) {

            $photo =  $this->reg_certificate_path;

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
