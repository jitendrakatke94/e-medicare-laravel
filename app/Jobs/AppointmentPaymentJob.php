<?php

namespace App\Jobs;

use App\Model\Appointments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AppointmentPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $appointment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Appointments $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $current_appointment = Appointments::findOrFail($this->appointment->id);

            \Log::debug('AppointmentPaymentJob', ['function' => 'handle', 'appointment id' => $this->appointment->id]);
            if ($current_appointment->payment_status == 'Not Paid') {
                $current_appointment->delete();
                \Log::debug('AppointmentPaymentJob', ['function' => 'id DELETED', 'appointment id' => $this->appointment->id]);
            }
            return;
        } catch (\Exception $e) {
            \Log::error(['AppointmentPaymentJob EXCEPTION' => $e->getMessage()]);
            return;
        }
    }
}
