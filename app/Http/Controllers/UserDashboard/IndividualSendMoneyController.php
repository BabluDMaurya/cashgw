<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\SendMoneyToUser;
use App\AddressBook;
use App\User;
use Mail;
use App\Mail\SendMoneyMail;
use App\Mail\JoinCashgwMail;
use App\Mail\SendMoneyOTPMail;
use App\Traits\BalanceTrait;
use App\Traits\TransactionIdTrait;
use App\Traits\UserStatusTrait;
use App\Traits\AddUserOnAddressBook;
use App\EmailOTPCheck;
use Validator;
use Illuminate\Notifications\Notifiable;
use App\Notifications\SendMoney;
class IndividualSendMoneyController extends Controller
{
    use BalanceTrait,TransactionIdTrait,UserStatusTrait,AddUserOnAddressBook,Notifiable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $validator = Validator::make($request->all(), [
                    '_token' => 'required|exists:email_o_t_p_checks,token', 
                    'email'=>'required|exists:email_o_t_p_checks,email',    
                    'otp' => 'required|exists:email_o_t_p_checks,otp',
                    ],[
                    '_token.required' => 'token required',
                    '_token.exists' => 'token does not exits', 
                    'email.required' => 'email required',
                    'email.exists' => 'email does not exits', 
                    'otp.required' => 'otp required',
                    'otp.exists' => 'otp does not exits', 
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    EmailOTPCheck::where('token',$request->_token)->where('email',$user->email)->where('otp',$request->otp)->delete();
                }
        if(isset($request->otp)){                 
            $requestUser = User::select('id')->where('email',$request->search_text)->first();
            if(trim($request->search_text) != trim($user->email)){                
                $userstatus = $this->CheckUserStatus($requestUser->id);
                if($userstatus == config('constants','Activeuser')){
                    $sendmoney = SendMoneyToUser::create([
                        'from' => $user->id,
                        'user_id' => $requestUser->id,                
                        'balance'=> $request->amount,
                        'currency_requested'=> $request->balance_request,
                        'action' => 1,
                        'status'=> 1,
                        'note'=>$request->note,
                    ]);                                      
                    $Smtu = SendMoneyToUser::find($sendmoney->id);                    
                    $sendmoneydata = [
                        'from' => $requestUser->id,                
                        'user_id' => $user->id,
                        'balance'=> $request->amount,
                        'currency_requested'=> $request->balance_request,
                        'note'=>$request->note,
                        'row_id' => $sendmoney->id,
                    ];                  
                    $result = $this->sendRequestMoneyBalance($sendmoneydata); 
                    if($result == 1){                       
                        $Smtu->action = 2;
                        $Smtu->status = 2;
                        $Smtu->save();

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
                            'row_id' => $sendmoney->id,
                            'request_status' => 1,  
                            'tab' => 1,
                        ];

                        $client = User::where('id', $requestUser->id)->first();
                        $client->notify(new SendMoney($notifydata));
                        
                        Mail::to($request->search_text)->send(new SendMoneyMail($userdata));          
                        Mail::to($user->email)->send(new SendMoneyMail($admindata));            
                        if(Mail::failures()){
                            $mes = config('constants.MailFailures');
                        }else{
                            $mes = config('constants.MoneySendSuccess');
                        }  
                       
                    }elseif($result == 'not enough balance'){
                        $mes = 'addbalance';
                    }else{
                        $mes = $result;
                    }
                }else{
                    $mes = $userstatus;
                }
            }else{
                $mes = config('constants.NoAction');
            }            
        }
          session()->flash('status',$mes);
          return redirect('/individual-send-money/'.$request->id);
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
                
                return view('pages.user.send-money',['user_id'=>$id,'addressBookContacts'=>$addressBookContacts]);  
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
    public function edit(Request $request,$id)
    {
        $user = Auth::user(); 
        $mes = 'No record added';
        if(isset($request->search_text)){ 
            $validator = Validator::make($request->all(), [
            'search_text' => 'required|email|string|emailformate|exists:users,email', 
            'user_id'=>'required',                   
            ],[
            'search_text.required' => 'Email Address or Phone Number Required',
            'search_text.email' => 'Email required',    
            'search_text.exists' => 'Cashgw send a mail to this email.when he/she register then your request proceeds.', 
            'user_id.required' => 'User Required',               
            ]);
            if ($validator->fails()) {
                $failedRules = $validator->failed();
                if(isset($failedRules['search_text']['Exists'])) {
                    $emailonaddressbook = $this->AddUserOnMyAddressbook($request->search_text);
                    Mail::to($request->search_text)->send(new JoinCashgwMail());
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }else{
                $emailonaddressbook = $this->AddUserOnMyAddressbook($request->search_text);                      
            }   
                $data = [
                        'search_text'=>$request->search_text,
                        'user_id'=>$request->user_id,
                        'title'=>config('constants.SendMoneyTitle'),
                        'desc'=>config('constants.SendMoneyDesc'),
                        'method'=>'GET',
                        'url'=>'/sendMoney/'.$id,
                        'murl'=>'individual-send-money',
                        'userrole'=>$user->role,
                        ];
                return view('pages.user.amount',['user_id'=>$id,'data'=>$data]); 
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
