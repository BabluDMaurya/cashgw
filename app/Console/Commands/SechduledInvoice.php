<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
use App\Mail\SendInvoiceMailToBillToAndCC;
use Carbon\Carbon;
class SechduledInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:sechinvoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Schedule Invoice Mail.';

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
     $data = DB::table('create_invoices')->where('invoice_status',2)->where('invoice_date', '=', Carbon::now()->toDateString())->get();
        if(count($data) > 0){
           foreach($data as $value){               
            DB::table('create_invoices')->where('id',$value->id)->update(['invoice_status'=>3,'updated_at'=>DB::raw('NOW()')]);
            Mail::to($value->bill_to_email)->send(new SendInvoiceMailToBillToAndCC($value->bill_to_email, $value->invoice_number, $value->invoice_date, $value->due_date_value, $value->invoice_grand_total, encrypt($value->id),'pay-invoice'));
           }
        }
    }
}
