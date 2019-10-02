<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrimaryAddressRejectMail extends Mailable
{
    use Queueable, SerializesModels;
    public $bname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bname)
    {
       $this->bname = $bname;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.PrimaryAddressRejectedMail');
    }
}
