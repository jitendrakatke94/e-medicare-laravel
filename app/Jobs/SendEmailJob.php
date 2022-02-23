<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\OTPverificationMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\ConfirmationMail;
use App\Mail\Notification;
use App\Mail\PaymentNotification;
use App\Mail\RejectionMail;
use Illuminate\Support\Facades\Log;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->details['mail_type']) {
            case 'otpverification':
                $email = new OTPverificationMail($this->details);
                break;
            case 'forgotpassword':
                $email = new ForgotPasswordMail($this->details);
                break;
            case 'confirmation':
                $email = new ConfirmationMail($this->details);
                break;
            case 'rejection':
                $email = new RejectionMail($this->details);
                break;
            case 'payment_notification':
                $email = new PaymentNotification($this->details);
                break;
            case 'notification':
                $email = new Notification($this->details);
                break;
            default:
                return false;
                break;
        }
        try {
            Mail::to($this->details['email'])->send($email);
            Log::debug('SendEmailJob', ['Mail sent']);
        } catch (\Exception $e) {
            Log::debug('SendEmailJob', ['exception' => $e->getMessage()]);
        }
    }
}
