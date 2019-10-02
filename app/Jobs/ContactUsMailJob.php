<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ContactAdminMail;
use Exception;
class ContactUsMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $timeout = 600;
    public  $contactData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contactData = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(config('constants.AdminMail'))->send(new ContactAdminMail($this->contactData));
    }
    
    public function retryUntil()
    {
        return now()->addSeconds(100);
    }
    
    public function failed(Exception $exception)
    {
        Log::error($exception);
    }
}
