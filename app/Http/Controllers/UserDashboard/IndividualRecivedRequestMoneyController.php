<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\BusinessKyc;
use App\IndividualKyc;
use App\User;
use Validator;
use App\RequestForMoneyToUser;
use Mail;
use App\Traits\TransactionIdTrait;
use App\Mail\RequestPaymentMail;
use App\Traits\BalanceTrait;
use App\Traits\TwoFATrait;
use App\EmailOTPCheck;
use Illuminate\Notifications\Notifiable;
use App\Notifications\RequestPayment;
class IndividualRecivedRequestMoneyController extends Controller
{
    use BalanceTrait,TwoFATrait,TransactionIdTrait,Notifiable;
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
        Auth::logout();
       return redirect('/login');
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
                throw new Exception(config('constants.DecryptionError'));
            }       
            $usersrecord = array();
            $requestUsers = $user->requestMoneyFromUser;
            $requestUsersrec = $requestUsers->where('action',1)->where('status',1)->sortBydesc('id'); 
            $usersrecorddoller = array();
            $usersrecordeuro = array();
            if(!empty($requestUsersrec)){
                foreach($requestUsersrec as $values){
                    if($values->currency_requested == 1){
                        $userdetails = User::where('id',$values->from)->first();
                        if($userdetails->role == 2){
                           $details = BusinessKyc::where('user_id',$values->from)->first();
                       }else if($userdetails->role == 1){
                           $details = IndividualKyc::where('user_id',$values->from)->first();
                       }else{
                           throw new Exception(config('constants.Exception'));
                       }
                        $usersrecorddoller[] = [
                            'id'=> $values->id,
                            'date' => date('d-m-Y',strtotime($values->updated_at)),
                            'amount' => $values->balance,
                            'email' => $userdetails->email,
                            'name' => $details->fname,
                            'currency' => $values->currency_requested,
                        ];
                    }    
                }
                
                foreach($requestUsersrec as $values){
                    if($values->currency_requested == 2){
                        $userdetails = User::where('id',$values->from)->first();
                        if($userdetails->role == 2){
                           $details = BusinessKyc::where('user_id',$values->from)->first();
                       }else if($userdetails->role == 1){
                           $details = IndividualKyc::where('user_id',$values->from)->first();
                       }else{
                           throw new Exception(config('constants.Exception'));
                       }
                        $usersrecordeuro[] = [
                            'id'=> $values->id,
                            'date' => date('d-m-Y',strtotime($values->updated_at)),
                            'amount' => $values->balance,
                            'email' => $userdetails->email,
                            'name' => $details->fname,
                            'currency' => $values->currency_requested,
                        ];
                    }    
                }
                //Mass update Notofication
                $user->unreadNotifications()->where('notifiable_type','App\User')->where('type','App\Notifications\RequestPayment')->update(['read_at' => now()]);
            }
                        
        }catch (DecryptException $e) {           
            $errormes = config('constants.DecryptException');
        }
        catch(QueryException $qe){             
            $errormes = config('constants.QueryException');
        }
        catch(Exception $ee){           
            $errormes = config('constants.Exception');
        }finally {          
            if(empty($errormes)){                  
                return view('pages.user.recived-request-money',['user_id'=>$id,'balance'=>$this->getBalance(),'requestedMoneyFromUserdoller'=>$usersrecorddoller,'requestedMoneyFromUsereuro'=>$usersrecordeuro]);  
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
    public function edit($id)
    {
        Auth::logout();
       return redirect('/login');
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
        if(Auth::Check()){ 
        $user = Auth::user();
        $decrypted = Crypt::decrypt($id);            
        if($user->id != $decrypted){               
            Auth::logout();   
            session()->flash('status',config('constants.DecryptException'));
            return redirect('/login');
        } 
            $mes = 'Updated Unsuccessfully.';
            if(!empty($request->brrmaction) && ($decrypted == $user->id)){
                $validator = Validator::make($request->all(),[
                    'id'=>'required',
                    'action'=>'required',
                ],[
                    'id.required'=>'User id required',
                    'action.required'=>'Action required',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator);
                }
                 $Rfmtu = RequestForMoneyToUser::find($request->id);
                 $requestdetails = RequestForMoneyToUser::where('id',$request->id)->first(); 
                 $request->amount = $requestdetails->balance;
                 $otpdata = $this->sendOTP($request);
                 $data = [
                        'number' => $otpdata['number'],
                        'amount' => $otpdata['amount'], 
                        'id'=>$request->id,
                        'action' => $request->action,
                        'email'=>$user->email,
                        'recivedrequest' => 'Yes',
                        'url'=>'individual-recived-request/'.$id,
                        'murl'=>'individual-recived-request/'.$id,
                        ];
                 return view('pages.user.send-money-otp',['user_id'=>$id,'data'=>$data]); 
            }
                
                if(!empty($request->otp) && ($decrypted == $user->id)){                
                $validator = Validator::make($request->all(),[
                    'id'=>'required',
                    'action'=>'required',
                    '_token' => 'required|exists:email_o_t_p_checks,token', 
                    'email'=>'required|exists:email_o_t_p_checks,email',    
                    'otp' => 'required|exists:email_o_t_p_checks,otp',
                ],[
                    'id.required'=>'User id Required',
                    'action.required'=>'Action Required',
                    '_token.required' => 'token required',
                    '_token.exists' => 'token does not exits', 
                    'email.required' => 'email required',
                    'email.exists' => 'email does not exits', 
                    'otp.required' => 'otp required',
                    'otp.exists' => 'otp does not exits', 
                ]);
                if($validator->fails()){
                    $failedRules = $validator->failed();
                    if(isset($failedRules['otp']['Exists'])){                        
                      session()->flash('status','otp does not exits');
                    }
                    return redirect()->back()->withErrors($validator);
                }else{
                    EmailOTPCheck::where('token',$request->_token)->where('email',$user->email)->where('otp',$request->otp)->delete();
                }
                 $Rfmtu = RequestForMoneyToUser::find($request->id);
                 $requestdetails = RequestForMoneyToUser::where('id',$request->id)->first(); 
                 $requestUser = User::where('id',$requestdetails->from)->first();
                
                 $admindata = [
                    'balance' => $requestdetails->balance,
                    'currency_requested' => $requestdetails->currency_requested,
                    'email' => $requestUser->email,
                    'request_status' => 2,
                  ];
                  $userdata = [
                    'balance' => $requestdetails->balance,
                    'currency_requested' => $requestdetails->currency_requested,
                    'email' => 'user',  
                    'request_status' => 2,  
                  ];
                 
                 if($request->action == 2){ //accept request                     
                    $result = $this->recivedRequestMoneyBalance($requestdetails);

                    if($result == 1){                       
                        $Rfmtu->action = $request->action;
                        $Rfmtu->status = 2;
                        $Rfmtu->save();  
                        
                            Mail::to($requestUser->email)->send(new RequestPaymentMail($userdata));          
                            Mail::to($user->email)->send(new RequestPaymentMail($admindata));            
                            if (Mail::failures()) {
                                $mes = config('constants.MailFailures');
                            }else{
                                $mes = 'accept';
                            }
                            $notifydata = [
                                    'balance'=> $requestdetails->balance,
                                    'currency_requested'=> $requestdetails->currency_requested,
                                    'request_status' => 2, 
                                    'action'=>'accept',
                                    'process'=>2,
                                    'tab'=>2,
                                ];
                                $requestUser->notify(new RequestPayment($notifydata));
                    }else{
                        $mes = 'addbalance';
                    }
                }elseif($request->action == 3){ //reject request
                    
                        $Rfmtu->action = $request->action;
                        $Rfmtu->status = 1;
                        $Rfmtu->save();             
                        
                            Mail::to($requestUser->email)->send(new RequestPaymentMail($userdata));          
                            Mail::to($user->email)->send(new RequestPaymentMail($admindata));      
                            if (Mail::failures()) {
                                $mes = config('constants.MailFailures');
                            }else{
                                $mes = 'rejected';
                            }
                            $notifydata = [
                                    'balance'=> $requestdetails->balance,
                                    'currency_requested'=> $requestdetails->currency_requested,
                                    'request_status' => 2,  
                                    'action'=>'rejected',
                                    'process'=>2,
                                    'tab'=>2
                                ];
                                $requestUser->notify(new RequestPayment($notifydata));
                }                        
            }        
            if(!empty($mes)){
                session()->flash('status',$mes);
                return redirect()->back();
            }
        }else{
            Auth::logout();   
            session()->flash('status','Logout');
            return redirect('/login');
        }
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
