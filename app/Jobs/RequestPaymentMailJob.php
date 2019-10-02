<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\RequestPaymentMail;
use Exception;
class RequestPaymentMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $timeout = 600;
    public $emailone,$emailtwo,$userdatas,$admindatas;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fromemail,$userdata,$toemail,$admindata)
    {
        $this->emailone = $fromemail;
        $this->emailtwo = $toemail;
        $this->userdatas = $userdata;
        $this->admindatas = $admindata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        if(!empty($this->emailone)){
            Mail::to($this->emailone)->send(new RequestPaymentMail($this->userdatas));
        }
        if($this->emailtwo){
            Mail::to($this->emailtwo)->send(new RequestPaymentMail($this->admindatas));       
        }
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
