<?php

namespace App\Model;

use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientFamilyMembers extends Model
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
        'patient_family_id',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'age',
        'height',
        'weight',
        'marital_status',
        'occupation',
        'relationship',
        'current_medication',
        'country_code',
        'contact_number',
        'national_health_id',
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
        'user_id', 'created_by', 'updated_by', 'deactivated_by', 'deleted_at', 'created_at', 'updated_at'
    ];
}
