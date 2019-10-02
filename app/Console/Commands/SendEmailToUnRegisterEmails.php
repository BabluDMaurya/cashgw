<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
use App\Mail\JoinCashgwMail;
use Carbon\Carbon;
class SendEmailToUnRegisterEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:unregister';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail To Un Register Email Id Every Third Day of the Request';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed    
     */
    public function handle()
    {
        $data = DB::table('un_register_emails')->where('updated_at', '<=', Carbon::now()->subDays(3)->toDateTimeString())->get();
        foreach($data as $value){
            if($value->mailcount <= 3){
                DB::table('un_register_emails')->where('row_id',$value->row_id)->update(['mailcount'=>$value->mailcount + 1,'updated_at'=>DB::raw('NOW()')]);
                Mail::to($value->email)->send(new JoinCashgwMail());
            }
        }
    }
}
