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
use App\RequestForMoneyToAdmin;
use App\RequestForMoneyToUser;
use App\User;
use Validator;
use Mail;
use App\Mail\CancelSentRequestPaymentMail;
use App\Mail\EditSentRequestPaymentMail;
use App\Traits\BalanceTrait;
use App\UnRegisterEmail;
class IndividualSentRequestMoneyController extends Controller {

    use BalanceTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
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
            $adminrecord = array();

            $requestAdmin = RequestForMoneyToAdmin::where('user_id',$user->id)->orderBy('updated_at', 'DESC')->get(); 
            if(!empty($requestAdmin)){
                foreach($requestAdmin as $values){                    
                    $adminrecord[] = [
                            'id'=> $values->id,
                            'date' => date('d-m-Y',strtotime($values->updated_at)),
                        'amount' => $values->balance,
                            'status' => $values->admin_action, 
                            'user_action'=>$values->user_action,
                            'currency' => ($values->currency_requested == 1)?'USD':'EURO',
                    ];
                }
            }
            $requestUsers = RequestForMoneyToUser::where('from',$user->id)->orderBy('updated_at', 'DESC')->get();
            if(!empty($requestUsers)){
                foreach($requestUsers as $values){
                    if($values->action != 4){
                    $userdetails = User::where('id',$values->user_id)->first();
                        if($userdetails['role'] == 2){
                            $businessdetails = BusinessKyc::where('user_id',$values->user_id)->first();
                            $email = ($userdetails['email'] != NULL) ? $userdetails['email'] : 'AN';
                            $name = ($businessdetails['fname'] != NULL) ? $businessdetails['fname'] : 'AN';
                        }elseif($userdetails['role'] == 1){
                            $businessdetails = IndividualKyc::where('user_id',$values->user_id)->first();    
                            $email = ($userdetails['email'] != NULL) ? $userdetails['email'] : 'AN';
                            $name = ($businessdetails['fname'] != NULL) ? $businessdetails['fname'] : 'AN';
                        }else{
                            $records = UnRegisterEmail::where('row_id',$values->id)->where('user_id',$user->id)->where('table','request_for_money_to_users')->first();
                            $email = ($records != NULL) ? $records->email : 'AN';
                            $name = 'AN';
                        }
                    }else if($values->action == 4){
                        $records = UnRegisterEmail::where('row_id',$values->id)->where('user_id',$user->id)->where('table','request_for_money_to_users')->first();
                        $email = ($records != NULL) ? $records->email : 'AN';
                        $name = 'AN';
                    }
                    $usersrecord[] = [
                        'id'=> $values->id,
                            'date' => date('d-m-Y',strtotime($values->updated_at)),
                        'amount' => $values->balance,
                        'email' => $email,
                        'name' => $name,
                            'status' => $values->action,
                        'user_action'=>$values->user_action,
                            'currency' => ($values->currency_requested == 1)?'USD':'EURO',
                    ];
                }
            }
          //Mass update Notofication App\Notifications\AdminNotify
                $user->unreadNotifications()->where('notifiable_type','App\User')->where('type','App\Notifications\RequestPayment')->update(['read_at' => now()]);              
                $user->unreadNotifications()->where('notifiable_type','App\User')->where('type','App\Notifications\AdminNotify')->update(['read_at' => now()]);              
        }catch (DecryptException $e) {           
            $errormes = config('constants.DecryptException');
        }
        catch(QueryException $qe){             
            $errormes = config('constants.QueryException');
        }
        catch(Exception $ee){           
            $errormes = config('constants.Exception');
        } finally {
            if (empty($errormes)) {
                return view('pages.user.sent-request-money', ['user_id' => $id, 'balance' => $this->getBalance(), 'requestedMoneyFromUser' => $usersrecord, 'requestedMoneyFromAdmin' => $adminrecord]);
            } else {
                Auth::logout();
                session()->flash('status', $errormes);
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
    public function edit($id) {
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

                 if(($request->action == 2)||($request->action == 1)){ //edit request
                        if($request->action == 1){
                            $Rfmtu = RequestForMoneyToAdmin::find($request->id);
                            if($Rfmtu->user_id > 0){
                            $toemailid = config('constants.AdminMail');
                            $dataname = 'admin';
                                $userdata = [
                                    'balance' => $request->amount,
                                    'currency_requested' => ($request->balance_request == 1)?'USD':'EURO',
                                    'role' => 'other',
                                    'name' => $dataname, 
                                  ];
                                Mail::to($toemailid)->send(new EditSentRequestPaymentMail($userdata)); 
                            }
                        }else{
                            $Rfmtu = RequestForMoneyToUser::find($request->id);
                            if($Rfmtu->user_id > 0){
                                $requestUser = User::where('id',$Rfmtu->user_id)->first();
                                $toemailid = $requestUser->email;
                                $dataname = 'user';
                                session()->flash('active-tab','Sent-Request-To-Users-Tab');
                                $userdata = [
                                    'balance' => $request->amount,
                                    'currency_requested' => ($request->balance_request == 1)?'USD':'EURO',
                                    'role' => 'other',
                                    'name' => $dataname, 
                                  ];
                                Mail::to($toemailid)->send(new EditSentRequestPaymentMail($userdata)); 
                            }
                        }                      
                            $Rfmtu->balance = $request->amount;
                            $Rfmtu->currency_requested = $request->balance_request;
                            $Rfmtu->save();
                              $selfdata = [
                                'balance' => $request->amount,
                                'currency_requested' => ($request->balance_request == 1)?'USD':'EURO',
                                'role' => 'self',    
                              ];
                       
                        Mail::to($user->email)->send(new EditSentRequestPaymentMail($selfdata)); 
                        if (Mail::failures()) {
                            $mes = config('constants.MailFailures');
                        }else{
                            $mes = 'edit';
                        }
                }elseif(($request->action == 3)||($request->action == 4)){ //cancel the request                    
//                    dd($request);
                    if($request->action == 3){
                        $Rfmtu = RequestForMoneyToUser::find($request->id);
                        $requestdetails = RequestForMoneyToUser::where('id',$request->id)->first(); 
                        $requestUser = User::where('id',$requestdetails->from)->first();
                        $toemailid = $requestUser->email;
                        $Rfmtu->action = $request->action;
                        $dataname = 'user';
                        session()->flash('active-tab','Sent-Request-To-Users-Tab');
                    }else{
                        $Rfmtu = RequestForMoneyToAdmin::find($request->id);
                        $requestdetails = RequestForMoneyToAdmin::where('id',$request->id)->first(); 
                        $toemailid = config('constants.AdminMail');
                        $Rfmtu->admin_action = $request->action;
                        $dataname = 'admin';
                    }                    
                        $Rfmtu->status = 1;
                        $Rfmtu->save(); 
                        
                    $userdata = [
                       'balance' => $requestdetails->balance,
                       'currency_requested' => ($requestdetails->currency_requested == 1)?'USD':'EURO',
                       'role' => 'other',
                       'name' => $dataname, 
                     ];
                     $selfdata = [
                       'balance' => $requestdetails->balance,
                       'currency_requested' => ($requestdetails->currency_requested == 1)?'USD':'EURO',
                       'role' => 'self',  
                     ]; 
                        Mail::to($user->email)->send(new CancelSentRequestPaymentMail($selfdata));          
                        Mail::to($toemailid)->send(new CancelSentRequestPaymentMail($userdata));      
                        if (Mail::failures()) {
                            $mes = config('constants.MailFailures');
                        }else{
                            $mes = 'rejected';
                        }
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
    public function destroy($id) {
        Auth::logout();
        return redirect('/login');
    }
}
