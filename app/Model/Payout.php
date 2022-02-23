<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{
    use SoftDeletes;
    public static $page = 10;

    protected $appends = ['previous_due', 'time', 'current_due', 'records'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payout_id',
        'type',
        'type_id',
        'cycle',
        'period',
        'total_paid',
        'total_payable',
        'total_sales',
        'balance',
        'earnings',
        'status',
        'doc_url',
        'record_ids'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'record_ids', 'records', 'doc_url', 'type', 'type_id', 'deleted_at', 'updated_at', 'created_at'
    ];

    protected $casts = [
        'record_ids' => 'array',
    ];

    public function getTotalPaidAttribute($value)
    {
        return round($value, 2);
    }
    public function setTotalPaidAttribute($value)
    {
        $this->attributes['total_paid'] = round($value, 2);
    }
    public function getTotalPayableAttribute($value)
    {
        return round($value, 2);
    }
    public function setTotalPayableAttribute($value)
    {
        $this->attributes['total_payable'] = round($value, 2);
    }
    public function getTotalSalesAttribute($value)
    {
        return round($value, 2);
    }
    public function setTotalSalesAttribute($value)
    {
        $this->attributes['total_sales'] = round($value, 2);
    }
    public function getBalanceAttribute($value)
    {
        return round($value, 2);
    }
    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = round($value, 2);
    }
    public function getEarningsAttribute($value)
    {
        return round($value, 2);
    }
    public function setEarningsAttribute($value)
    {
        $this->attributes['earnings'] = round($value, 2);
    }

    public function pharmacy()
    {
        return $this->hasOne('App\Model\Pharmacy', 'user_id', 'type_id');
    }
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'type_id');
    }
    public function labortory()
    {
        return $this->hasOne('App\Model\LaboratoryInfo', 'user_id', 'type_id');
    }
    public function payout_history()
    {
        return $this->hasMany('App\Model\PayoutInformation', 'payout_id', 'id')->orderBy('id', 'desc');
    }
    public function payout_history_latest()
    {
        return $this->hasOne('App\Model\PayoutInformation', 'payout_id', 'id')->latest();
    }
    public function bank_account_details()
    {
        return $this->hasOne('App\Model\BankAccountDetails', 'user_id', 'type_id');
    }
    public function address()
    {
        return $this->hasOne('App\Model\Address', 'user_id', 'type_id');
    }

    public function getTimeAttribute()
    {
        return convertToUser($this->created_at,  'Y-m-d h:i:s a');
    }

    public function getPreviousDueAttribute()
    {
        $list = Payout::where('id', '!=', $this->id)->where('type', $this->type)->where('type_id', $this->type_id)->where('created_at', '<=', $this->created_at)->get();

        $value = $list->sum('total_payable') - $list->sum('total_paid');
        return round($value, 2);
    }
    public function getCurrentDueAttribute()
    {
        if (is_null($this->balance)) {
            return round($this->total_payable, 2);
        }
        return round($this->balance, 2);
    }

    public function getRecordsAttribute()
    {
        if (!is_null($this->record_ids)) {

            if ($this->type == 'DOC') {
                $list = \DB::table('appointments')->select('appointment_unique_id as unique_id', 'tax', 'commission', 'total')->whereIn('id', $this->record_ids)->get();
            } else {
                $list = \DB::table('orders')->select('unique_id', 'tax', 'commission', 'total')->whereIn('id', $this->record_ids)->get();
            }
            return $list;
        }
        return NULL;
    }
}
