<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrimaryAddressApprovalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $fname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fname)
    {
       $this->fname = $fname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.PrimaryAddressApprovalMail');
    }
}
