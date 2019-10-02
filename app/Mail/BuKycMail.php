<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuKycMail extends Mailable
{
    use Queueable, SerializesModels;
    public $verifyUser,$userfname,$userlname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyUser,$fname,$lname)
    {        
       $this->verifyUser = $verifyUser;
       $this->userfname = $fname;
       $this->userlname = $lname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.KycBusiVerify');
    }
}
