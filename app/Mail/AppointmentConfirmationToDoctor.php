<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationToDoctor extends Mailable
{
    use Queueable, SerializesModels;
    public $record;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $this->record = $record;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Emedicare Patient Appointment Confirmation')->markdown('mails.doctorAppConfirmation');
    }
}
