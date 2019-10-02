<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\RequestForMoneyToUser;
use App\User;
use App\AddressBook;
//use Mail;
//use App\Mail\RequestPaymentMail;
use App\Traits\UserStatusTrait;
use App\Traits\AddUserOnAddressBook;
//use App\Mail\JoinCashgwMail;
use Validator;
use Illuminate\Support\Facades\Route;
use App\Jobs\UserNotExitsMailJob;
use App\Jobs\RequestPaymentMailJob;
use Carbon\Carbon;
use App\Traits\PaymentHistoryTrait;
use App\Traits\ActivityTrait;
use Illuminate\Notifications\Notifiable;
use App\Notifications\RequestPayment;
use App\Traits\TransactionIdTrait;
use App\Traits\UnRegisterEmailTrait;
class BusinessRequestPaymentController extends Controller
{
    use UserStatusTrait,AddUserOnAddressBook,ActivityTrait,PaymentHistoryTrait,Notifiable,TransactionIdTrait,UnRegisterEmailTrait;
    public $currentpath;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->currentpath = Route::getFacadeRoot()->current()->uri();
    }
    public function index()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user(); 
        $mes = 'No record added';
        if(isset($request->search_text)){ 
            $validator = Validator::make($request->all(), [
//            'user_id'=>'required',    
            'amount' => 'required|integer', 
            'balance_request'=>'required',   
            'note'=>'required',  
            'search_text' => 'required|email|string|exists:users,email|emailformate|emaildomain',     
            ],[
//            'user_id.required' => 'User Required',  
            'amount.required' => 'Amount Required',      
            'amount.integer' => 'amount should be integer',
            'balance_request.required'=>'Please select Currency.', 
            'note.required' => 'Note Required',
            'search_text.required' => 'Email Address or Phone Number Required',
            'search_text.email' => 'Enter valid Email',    
            'search_text.exists' => 'Cashgw send a mail to this email.when he/she register then your request proceeds.',     
            ]);            
            $transactionId = $this->createTID();
            if ($validator->fails()){
                $failedRules = $validator->failed();
                if(isset($failedRules['search_text']['Exists'])){
                    $insertedrow = RequestForMoneyToUser::create([
                        'from' => $user->id,
                        'user_id' => 0,    
                        'balance'=>$request->amount,
                        'currency_requested'=>$request->balance_request,
                        'action' => 4,//unregister user
                        'status'=>1, 
                        'note'=>$request->note,
                        'transaction_id'=>$transactionId,
                    ])->id;
                    $this->unRegisterEmail('request_for_money_to_users', $insertedrow, $user->id, $request->search_text, 1, 'user_id', Null);                
                    //create activity                        
                    $reciver = $this->getReciverNameIDRoleByEmail($request->search_text);
                    $sender = $this->getSenderNameEmailRoleById();
                    $activity1 = $this->createActivity($sender['id'],$sender['id'],0,$reciver['name'],$reciver['email'],1,$request->amount,2,NULL,$request->note,$transactionId,$request->balance_request,date('Y-m-d'));
                    $this->unRegisterEmail('activities', $activity1, $user->id, $request->search_text, 1, 'name', Null);
                    
                    $activity2 = $this->createActivity($reciver['id'],$sender['id'],0,$sender['name'],$sender['email'],1,$request->amount,2,NULL,$request->note,$transactionId,$request->balance_request,date('Y-m-d'));
                    $this->unRegisterEmail('activities', $activity2, $user->id, $request->search_text, 1, 'user_id', Null);
                    // add user in address book //
                  
                    $job = (new UserNotExitsMailJob($request->search_text))->delay(Carbon::now()->addSeconds(20));
                            dispatch($job);
                    session()->flash('status',config('constants.UserNotExits'));
                    return redirect('/'.$this->currentpath.'/'.$request->id);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(trim($request->search_text) != trim($user->email)){                
                  $requestUser = User::select('id')->where('email',$request->search_text)->first();
                  $userstatus = $this->CheckUserStatus($requestUser->id);
                if($userstatus == config('constants','Activeuser')){                              
                  $lastId = RequestForMoneyToUser::create([
                      'from' => $user->id,
                      'user_id' => $requestUser->id,    
                      'balance'=>$request->amount,
                      'currency_requested'=>$request->balance_request,
                      'action' => 1,// pending status
                      'status'=>1, 
                      'note'=>$request->note,
                      'transaction_id'=>$transactionId,
                  ]);
                  $last_id = $lastId->id;
                  $admindata = [
                    'balance' => $request->amount,
                    'currency_requested' => $request->balance_request,
                    'email' => $request->search_text,
                    'request_status' => 1,    
                  ];
                  $userdata = [
                    'balance' => $request->amount,
                    'currency_requested' => $request->balance_request,
                    'email' => 'user',
                    'request_status' => 1,    
                  ];
                  
                  $notifydata = [
                            'from' => $requestUser->id,                
                            'user_id' => $user->id,
                            'balance'=> $request->amount,
                            'currency_requested'=> $request->balance_request,
                            'note'=>$request->note,                            
                            'request_status' => 2, 
                            'action'=>'send',
                            'process'=>1,
                            'tab'=>$request->balance_request,
                        ];

                        $client = User::where('id', $requestUser->id)->first();
                        $client->notify(new RequestPayment($notifydata));
                  
                  $job = (new RequestPaymentMailJob($request->search_text,$userdata,$user->email,$admindata))->delay(Carbon::now()->addSeconds(20));
                  $this->dispatch($job);
                  
                  //create activity                        
                        $reciver = $this->getReciverNameEmailRoleById($requestUser->id);              
                        $sender = $this->getSenderNameEmailRoleById();
                        // method parameter (userid,name,email,status [1=pending,2=success],balance,type 2=requested money,fees,descriptions)
                       $activity1 =  $this->createActivity($sender['id'],$sender['id'],0,$reciver['name'],$reciver['email'],1,$request->amount,2,NULL,$request->note,$transactionId,$request->balance_request,date('Y-m-d'));
                       $activity2 = $this->createActivity($reciver['id'],$sender['id'],$last_id,$sender['name'],$sender['email'],1,$request->amount,2,NULL,$request->note,$transactionId,$request->balance_request,date('Y-m-d'));
                  
                  
                  $mes = config('constants.RequestSuccess');
                  }else{
                    $mes = $userstatus;
                }
            }else{
              $mes = config('constants.NoAction');  
            }          
        } 
         session()->flash('status',$mes);
          return redirect('/'.$this->currentpath.'/'.$request->id);       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{            
            $user = Auth::user(); 
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception("User not login");
            }
            $addressBookContacts = AddressBook::select('id','email')->distinct()->where('user_id',$user->id)->get(['email']);
        }catch (DecryptException $e) {           
            $errormes = 'Decryption error';
        }
        catch(QueryException $qe){             
            $errormes = 'User table error';
        }
        catch(Exception $ee){           
            $errormes = 'Code error';
        }finally {          
            if(empty($errormes)){   
                return view('pages.business.request-payment',['user_id'=>$id,'addressBookContacts'=>$addressBookContacts]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
                return redirect('/login');
            }       
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = Auth::user(); 
        $mes = 'No record added';
        if(isset($request->search_text)){ 
            $validator = Validator::make($request->all(), [
            'search_text' => 'required|email|string|emailformate|emaildomain',   
//            'user_id'=>'required',                   
            ],[
            'search_text.required' => 'Email Address or Phone Number Required',
            'search_text.email' => 'Email required', 
//            'user_id.required' => 'User Required',               
            ]);
            if ($validator->fails()) {
//                    $emailonaddressbook = $this->AddUserOnMyAddressbook($request->search_text);
                    return redirect()->back()->withErrors($validator)->withInput();
            }else{
                    $emailonaddressbook = $this->AddUserOnMyAddressbook($request->search_text);
            }            
            $data = [
                        'search_text'=>$request->search_text,
                        'user_id'=>$request->user_id,
                        'title'=>config('constants.RequestPaymentTitle'),
                        'desc'=>config('constants.RequestPaymentDesc'), 
                        'method'=>'POST',
                        'murl'=>'business-send-money',
                        'url'=>'/business-request-payment',
                        ];
            return view('pages.business.amount',['user_id'=>$id,'data'=>$data]); 
        }
          session()->flash('status',$mes);
          return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::logout();
        return redirect('/login');
    }
}
