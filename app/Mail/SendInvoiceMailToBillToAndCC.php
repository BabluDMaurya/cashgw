<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoiceMailToBillToAndCC extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $userEmail;
    public $invoiceNumber;
    public $invoiceDate;
    public $dueDate;
    public $invoiceTotal; 
    public $invoiceId;
    public $url;


    public function __construct($userEmail, $invoiceNumber, $invoiceDate, $dueDate, $invoiceTotal, $invoiceId,$url)
    {
     $this->userEmail = $userEmail;
     $this->invoiceNumber = $invoiceNumber;
     $this->invoiceDate = $invoiceDate;
     $this->dueDate = $dueDate;
     $this->invoiceTotal = $invoiceTotal;
     $this->invoiceId = $invoiceId;
     $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.SendInvoiceMailToBillToAndCC');
    }
}
