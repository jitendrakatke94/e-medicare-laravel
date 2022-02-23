<?php

namespace App\Console\Commands;

use App\Model\DoctorPersonalInfo;
use App\Model\LaboratoryInfo;
use App\Model\Payout;
use App\Model\Pharmacy;
use App\Model\Sales;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PayoutScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:payoutScheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Payouts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Log::debug('PayoutScheduler', ['function' => 'started....']);

            $types = array('DOC', 'MED', 'LAB');

            if (Carbon::now()->startOfMonth()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $monthStartDate = Carbon::now()->startOfMonth();
                $monthEndDate = Carbon::now()->endOfMonth();

                foreach ($types as $key => $type) {
                    $cycle = 'MONTHLY';
                    if ($type == 'DOC') {
                        $lists = DoctorPersonalInfo::withTrashed()->select('user_id')->where('payout_period', 0)->get();
                    } else if ($type == 'MED') {
                        $lists = Pharmacy::withTrashed()->select('user_id')->where('payout_period', 0)->get();
                    } else if ($type == 'LAB') {
                        $lists = LaboratoryInfo::withTrashed()->select('user_id')->where('payout_period', 0)->get();
                    }
                    //Monthly payout
                    $this->weeklyandMonthlyPayout($lists, $type, $monthStartDate, $monthEndDate, $cycle);
                }
            }

            //check condition for weekly
            if (Carbon::now()->dayOfWeek === Carbon::MONDAY) {
                $weeklyStartDate  = Carbon::now()->subDays(7)->startOfWeek(); //Monday
                $weeklyEndDate  = Carbon::now()->subDays(7)->endOfWeek(); //Sunday
                // $weeklyStartDate  = Carbon::now()->startOfWeek(); //Monday
                // $weeklyEndDate  = Carbon::now()->endOfWeek(); //Sunday
                foreach ($types as $key => $type) {
                    $cycle = 'WEEKLY';
                    if ($type == 'DOC') {
                        $lists = DoctorPersonalInfo::withTrashed()->select('user_id')->where('payout_period', 1)->get();
                    } else if ($type == 'MED') {
                        $lists = Pharmacy::withTrashed()->select('user_id')->where('payout_period', 1)->get();
                    } else if ($type == 'LAB') {
                        $lists = LaboratoryInfo::withTrashed()->select('user_id')->where('payout_period', 1)->get();
                    }
                    //Weekly payout
                    $this->weeklyandMonthlyPayout($lists, $type, $weeklyStartDate, $weeklyEndDate, $cycle);
                }
            }
        } catch (\Exception $e) {
            Log::debug('PayoutScheduler', ['exception' => $e->getMessage()]);
        }
        return;
    }

    public function weeklyandMonthlyPayout($lists, $type, $startDate, $endDate, $cycle)
    {
        foreach ($lists as $key => $list) {

            $query = Sales::where('type', $type)->where('type_id', $list->user_id)->whereBetween('created_at', [$startDate, $endDate])->where('payment_complete', 0)->whereHas('payment', function ($query) {
                $query->where('payment_status', 'Paid');
            });

            $sales = $query->get();

            if ($sales->count() > 0) {
                $record_ids = array();
                if ($type == 'DOC') {
                    $sales_records = $query->with('payment.appointments')->get();
                    foreach ($sales_records as $key => $sales_record) {
                        if (!is_null($sales_record->payment->appointments)) {
                            $record_ids[] = $sales_record->payment->appointments->id;
                        }
                    }
                } else {
                    $sales_records = $query->with('payment.orders')->get();
                    foreach ($sales_records as $key => $sales_record) {
                        if (!is_null($sales_record->payment->orders)) {
                            $record_ids[] = $sales_record->payment->orders->id;
                        }
                    }
                }

                Sales::where('type', $type)->where('type_id', $list->user_id)->whereBetween('created_at', [$startDate, $endDate])->whereHas('payment', function ($query) {
                    $query->where('payment_status', 'Paid');
                })->update(['payment_complete' => 1]);

                $period = $startDate->format('d F Y') . ' - ' . $endDate->format('d F Y');
                $type_id = $list->user_id;
                $payable_to_vendor = $sales->sum('payable_to_vendor');
                $total_sales = $sales->sum('total');
                $earnings = $sales->sum('earnings');
                $this->createPayoutEntry($type, $cycle, $period, $type_id, $payable_to_vendor, $total_sales, $earnings, $record_ids);
            }
        }
        return;
    }

    public function createPayoutEntry($type, $cycle, $period, $type_id, $payable_to_vendor, $total_sales, $earnings, $record_ids)
    {
        Payout::create([
            'payout_id' => getPayOutId(),
            'type' => $type,
            'cycle' => $cycle,
            'period' => $period,
            'type_id' => $type_id,
            'total_paid' => 0,
            'total_payable' => $payable_to_vendor,
            'total_sales' => $total_sales,
            'earnings' => $earnings,
            'record_ids' => $record_ids,
        ]);
        return;
    }
}
