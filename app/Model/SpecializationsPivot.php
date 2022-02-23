<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpecializationsPivot extends Model
{

    protected $table = 'doctor_personal_info_specializations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_personal_info_id',
        'specializations_id',
    ];
}
