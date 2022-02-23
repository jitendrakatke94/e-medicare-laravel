<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorOffDays extends Model
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
        'date',
        'day',
        'slot_start',
        'slot_end',
        'time_slot_ids',
        'created_by_system'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'time_slot_ids', 'created_by_system', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function setSlotStartAttribute($input)
    {
        $this->attributes['slot_start'] =
            convertToUTC($input,  'H:i:s');
    }

    public function getSlotStartAttribute($value)
    {
        return convertToUser($value,  'H:i');
    }
    public function setSlotEndAttribute($input)
    {
        $this->attributes['slot_end'] =
            convertToUTC($input,  'H:i:s');
    }

    public function getSlotEndAttribute($value)
    {
        return convertToUser($value,  'H:i');
    }
}
