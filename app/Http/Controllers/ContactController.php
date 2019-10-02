<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Contact;
use App\ManageCms;
use App\Http\Requests\ContactRequest;
use Mail;
use App\Mail\ContactAdminMail;
use Illuminate\Database\QueryException;
use Exception;
use App\AdminLogin;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ContactUs;
use App\Jobs\ContactUsMailJob;
use Carbon\Carbon;
class ContactController extends Controller
{
    use Notifiable;
    protected $fillable = ['name','email','subject','message'];
    public function __construct(){
      $footerData = ManageCms::where('page_id', 6)->get()->toArray();
      \View::share('footerData',$footerData);
    }
    public function index(){
        return view('pages.contact');
    }
    public function formsubmit( ContactRequest $request) {
                    
        try{
            $userdetails = AdminLogin::where('email',config('constants.AdminMail'))->first();
            
            $contact = new Contact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->comment;
            $contact->save();        
            
                Mail::to(config('constants.AdminMail'))->send(new ContactAdminMail($contact));
//            $job = (new ContactUsMailJob($contact))->delay(Carbon::now()->addSeconds(10));
//                  $this->dispatch($job);
                  
            $notifydata = [
                            'request_status' => 7,
                            'action'=>'contactsend',
                            'process'=>1,
                            'type'=>'contact',
                        ];
            
            $userdetails->notify(new ContactUs($notifydata));
        }catch(QueryException $qe){
            if($qe->getCode()){
                $errormes = 'Database Error';
                session()->flash('status',$errormes);
            }; 
        }catch(Exceptions $e){
            if($e->getCode()){
                $errormes = 'Server Error';
                session()->flash('status',$errormes);
            }; 
        }finally{
            if(empty($errormes)){
                return response()->json(['success'=>'Your Message successfully send.']);
            }else{
               return response()->json(['success'=> $errormes]);
            }
        }        
        
    }    
}
