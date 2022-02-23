<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImportMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->details['error_file']) {
            return $this->subject('Payout - Bulk Import')
                ->markdown('mails.importmail')
                ->attach($this->details['error_file']);
        } else {
            return $this->subject('Payout - Bulk Import')
                ->markdown('mails.importmail');
        }
    }
}
