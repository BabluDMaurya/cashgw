<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\RequestForMoneyToAdmin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use File;
use DB;
use Validator;
use App\AdminLogin;
use App\Mail\AdminRequestPaymentMail;
use Mail;
use App\AmountBalanceMaster;
use App\Traits\BalanceTrait;
use App\Activity;
use App\BankDetails;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ManagePaymentRequest;
use App\Traits\TransactionIdTrait;

class IndividualSummaryController extends Controller
{
    use BalanceTrait,Notifiable,TransactionIdTrait;
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
        if(isset($request->balance_request)){
            $this->validate($request,[
            'balance' => 'required|regex:/^\d+(\.\d{1,2})?$/', 
            'balance_request' => 'required',    
            'bankid' => 'required',    
            ],[
            'balance.required' => 'Amount Required',
            'balance_request.required' => 'Please Select Currency',
            'bankid.required' => 'Please Choose Bank',    
            ]);
            
            $bankdetails = BankDetails::where('id',$request->bankid)->first(); 
            $transactionId = $this->createTID();
            
            RequestForMoneyToAdmin::create([
                'user_id' => $user->id,
                'balance' => $request->balance,                
                'currency_requested'=>$request->balance_request,
                'admin_action' => 1,
                'status'=>1,
                'bank_name' =>$bankdetails->bank,
                'bankid'=>$request->bankid,
                'refcode'=>substr($bankdetails->bank,0,2).'_'.$bankdetails->ifsc.'_'.$user->id,
                'transaction_id'=>$transactionId,
            ]);
              
            $userdetails = $user->individualkyc;
            
            //create activity             
            $activity = $this->createActivity($user->id,$user->id,0,config('constants.AdminName'),config('constants.AdminMail'),1,$request->balance,11,NULL,config('constants.BRTA'),$transactionId,$request->balance_request,date('Y-m-d'));
            
            $admin = AdminLogin::find(1);                
            $cryptedid = Crypt::encrypt($user->id);
            
            $maildata = [
               'userid' =>$cryptedid,
               'fname' =>$userdetails->fname,
               'lname' =>$userdetails->lname,
               'balance' =>$request->balance,
               'currency' =>$request->balance_request,
               'refcode' =>substr($bankdetails->bank,0,2).'_'.$bankdetails->ifsc.'_'.$user->id,
               'bank_name' =>$bankdetails->bank,
               'acno' =>$bankdetails->acno,
            ];
            
            //notification 
                $notifydata = [                                
                   'action'=>'managepaymentrequest',
                   'process'=>1,
                   'type' => 'ManagePaymentRequest',
                   'tab' => 1,  
               ];
               $admin->notify(new ManagePaymentRequest($notifydata));
               
            Mail::to($admin->email)->send(new AdminRequestPaymentMail($maildata));
            if (Mail::failures()) {
                session()->flash('status', 'We can not sent balance request.');            
            }else{
                session()->flash('status','Balance request successfully send.');
            }
        }    
        return redirect('/individual-balance/'.$cryptedid);
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
            $bal = array();
            $mybals = $this->getBalance();
            if(count($mybals) > 0){
                if(count($mybals) > 1){
                    foreach($mybals as $mybal){                
                        if($mybal['currency_requested'] == 2){
                            $bal['EUR'] = number_format((float)$mybal['balance'], 2, '.', '');
                        }else{
                            $bal['USD'] = number_format((float)$mybal['balance'], 2, '.', '');
                        }                
                    }
                }else{
                    foreach($mybals as $mybal){                
                        if($mybal['currency_requested'] == 2){
                            $bal['EUR'] = number_format((float)$mybal['balance'], 2, '.', '');
                            $bal['USD'] = 0.00;
                        }else{
                            $bal['USD'] = number_format((float)$mybal['balance'], 2, '.', '');
                            $bal['EUR'] = 0.00;
                        }                
                    }          
                }           
            }else{
                $bal['EUR'] = 0.00;
                $bal['USD'] = 0.00;
            }
            
            $sendmoney = Activity::where('user_id',$user->id)->where('type',1)->orderBy('updated_at', 'DESC')->limit(20)->get();
            $requestmoney = Activity::where('user_id',$user->id)->where('type',2)->orderBy('updated_at', 'DESC')->limit(20)->get();
            $sentmoney = Activity::where('user_id',$user->id)->where('type',3)->orderBy('updated_at', 'DESC')->limit(20)->get();
//            $currencyconverter = Activity::where('user_id',$user->id)->where('type',4)->orderBy('updated_at', 'DESC')->limit(20)->get();
            $sentinvoice = Activity::where('user_id',$user->id)->where('type',5)->orderBy('updated_at', 'DESC')->limit(20)->get();
            $paidinvoice = Activity::where('user_id',$user->id)->whereIn('type', array(7))->orderBy('updated_at', 'DESC')->limit(20)->get();
            
            $receivedinvoice = Activity::where('user_id',$user->id)->whereIn('type', array(6))->orderBy('updated_at', 'DESC')->limit(20)->get();
            $processedinvoice = Activity::where('user_id',$user->id)->whereIn('type', array(8))->orderBy('updated_at', 'DESC')->limit(20)->get();
            
            $Admin = Activity::where('user_id',$user->id)->whereIn('type', array(11,12,13,14))->orderBy('updated_at', 'DESC')->limit(20)->get();
            
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
                return view('pages.user.summary',[
                    'user_id'=>$id,
                    'role'=>$user->role,
                    'individual'=>$user->individual,
                    'individualkyc'=>$user->individualkyc,
                    'balance'=>$bal,                                     
                    'requestmoney'=>$requestmoney,
                    'sendmoney'=>$sendmoney,
                    'sentmoney'=>$sentmoney,
                    'sentinvoice'=>$sentinvoice,
                    'paidinvoice'=>$paidinvoice,                    
                    'receivedinvoice'=>$receivedinvoice,
                    'processedinvoice'=>$processedinvoice,                    
                    'admin'=>$Admin,
                    
                ]);
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
        $bankaccs = BankDetails::get();
        
        $this->validate($request,[
            'balance' => 'required|regex:/^\d+(\.\d{1,2})?$/', 
            'balance_request' => 'required',    
            ],[
            'balance.required' => 'Amount Required',
            'balance_request.required' => 'Please Select Currency',
            ]);
        return view('pages.user.bankaccounts',['user_id'=>$id,'request'=>$request,'bankaccs'=>$bankaccs]);  
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
            session()->flash('status','Decryption error');
            return redirect('/login');
        } 
            $mes = 'Updated Unsuccessfully.';
            
            if(!empty($request->myphoto) && ($decrypted == $user->id)){
                $validator = Validator::make($request->all(),[
                'myphoto'=>'required',
                ],[
                'myphoto.required'=>'Image Required',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator);
                }
                    $fileuploadpath = public_path().'/images/'.$user->id;     
                    $file = $request->file('myphoto');                
                    $phfileName = $user->id.'_PhotoFile.'.$file->getClientOriginalExtension();
                    $file->move($fileuploadpath, $phfileName); 

                    $user->individualkyc->photo = $phfileName;                            
                    $user->individualkyc->save();
                    
                    $user->master->photo = $phfileName; 
                    $user->master->save();

                $mes = 'Photo Updated Successfully';
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
