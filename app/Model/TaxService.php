<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxService extends Model
{
    use SoftDeletes;
    public static $page = 10;
    protected $appends = ['tax_percent'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id',
        'name',
        'taxes',
        'commission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'taxes' => 'array',
    ];

    public function getTaxPercentAttribute()
    {
        $value = 0;
        if (!is_null($this->taxes) && !empty($this->taxes)) {
            foreach ($this->taxes as $key => $id) {

                $record = Tax::withTrashed()->find($id);
                $value = $value + $record->percent;
            }
        }
        return $value;
    }
}
