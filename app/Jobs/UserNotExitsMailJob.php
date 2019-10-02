<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\JoinCashgwMail;
class UserNotExitsMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 240;
    public $emailto;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($search_text)
    {
        $this->emailto = $search_text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        Mail::to($this->emailto)->send(new JoinCashgwMail());
    }
    
    public function retryUntil()
    {
        return now()->addSeconds(60);
    }
}
