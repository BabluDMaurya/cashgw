<?php
namespace App\Traits;
 
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\AmountBalanceMaster;
use App\AdminAmountBalanceMaster;
use App\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\Traits\PaymentHistoryTrait;
use App\Traits\ActivityTrait;
use App\Traits\CalculateBalanceAfterChargeTrait;
use App\SendMoneyToUser;
use App\RequestForMoneyToUser;
use App\CreateInvoice;
//use Illuminate\Notifications\Notifiable;
use App\Notifications\Invoice;
trait BalanceTrait {
 use PaymentHistoryTrait,ActivityTrait,CalculateBalanceAfterChargeTrait;
    // admin module 
    public function getAdminBalance() {
            return $adminbalance = AdminAmountBalanceMaster::first();   
    }
    
    public function updateAdminBalnace($balance){
        $adminamount = AdminAmountBalanceMaster::first();
        $adminamount->balance = $balance;
        $adminamount->save();
        return TRUE;
    }
    // admin module 
    
    public function getBalance(){
        if(Auth::Check()){ 
            $user = Auth::user();                    
            $balance = $user->balance;
            return  $balance;
        }else{
            Auth::logout();   
            session()->flash('status','Logout');
            return redirect('/login');
        }
    }
    public function getCurrencyBalance($currencyflag) {
        if(Auth::Check()){ 
            $user = Auth::user();                    
            $balance = $user->balance;
            $result = '';
            if(count($balance) > 0){
                foreach($balance as $bal){
                    if($bal->currency_requested == $currencyflag){ 
                        $result = [
                        'rowid'=> $bal->id,
                        'balance' => $bal->balance,
                        'admin_request' => $bal->admin_request,
                        'user_id' => $bal->user_id,                          
                            ];
                        return  $result;    
                    }
                }
                return $result = 'currencynotfound';
            }else{
                return $result = 'no_row';
            }
        }else{
            Auth::logout();   
            session()->flash('status','Logout');
            return redirect('/login');
        }
    }
    
    public function getBalanceByUserId($id,$currencyflag){
        $balance = AmountBalanceMaster::where('user_id',$id)->select('balance','user_id','id','admin_request','currency_requested')->get();
        $result = '';
         if(count($balance)> 0){
            foreach($balance as $bal){ 
                if($bal->currency_requested == $currencyflag){ 
                    $result = [
                    'rowid'=> $bal->id,
                    'balance' => $bal->balance,
                    'admin_request' => $bal->admin_request,
                    'user_id' => $bal->user_id,    
                        ];
                    return  $result;
                }
            }
            return  $result = 'currencynotfound';
        }else{
           return $result = 'no_row';
        }
    }
    public function updateUserBalnace($newbalance,$rowid,$currencyrequest){
        $balance = AmountBalanceMaster::find($rowid);
        $balance->balance = $newbalance;
        $balance->save();
        return $balance;
    }
    
    
    public function updateMasterBalnace($newbalance,$currencyrequest,$userid) { 
        $user = User::find($userid);
        if($currencyrequest == 1){ 
            $user->master->usd_balance = $newbalance;
            $user->master->save();                    
        }else{
            $user->master->euro_balance = $newbalance;
            $user->master->save();
        }
        return $user;
    }
    
    public function createUserBalnace($newbalance,$currencyrequest,$userid) {        
        $balance = AmountBalanceMaster::create([
            'user_id' => $userid,
            'balance' => $newbalance,                
            'currency_requested'=>$currencyrequest,
            'admin_request' => 1,
        ]);
        return $balance;
    }
    
    public function recivedRequestMoneyBalance($requestdetails){
        $errormes = '';
         try{            
            $balance = $this->getCurrencyBalance($requestdetails->currency_requested);
            $userbalance = $this->getBalanceByUserId($requestdetails->from,$requestdetails->currency_requested); 
            
            $charge = $this->transactionCharges(1);
            $calresult = $this->calculateBalanceAfterCharge($requestdetails->balance,$charge);
                        
            if($calresult['balance'] > 0){ // check balance after chashgw charge 
                if(($balance != 'no_row') && ($balance != 'currencynotfound') && (($balance['balance'] >= $requestdetails->balance))){ 
                    $this->updateUserBalnace(($balance['balance']-$requestdetails->balance),$balance['rowid'],$requestdetails->currency_requested);
                    $this->updateMasterBalnace(($balance['balance']-$requestdetails->balance),$requestdetails->currency_requested,$requestdetails->user_id);

                    if(($userbalance != 'no_row') && ($userbalance != 'currencynotfound') && (($userbalance['balance']) >= 0)){ 
                            $result = $this->updateUserBalnace(($userbalance['balance']+$calresult['balance']),$userbalance['rowid'],$requestdetails->currency_requested);
                            $this->updateMasterBalnace(($userbalance['balance']+$calresult['balance']),$requestdetails->currency_requested,$requestdetails->from);
                        }else{
                            $result = $this->createUserBalnace($calresult['balance'],$requestdetails->currency_requested,$requestdetails->from);                    
                            $this->updateMasterBalnace($calresult['balance'],$requestdetails->currency_requested,$requestdetails->from);
                        }
                        // update admin balance
                        $adminbalance = $this->getAdminBalance();
                        $this->updateAdminBalnace(($adminbalance->balance+$calresult['TranCharge']));

                            RequestForMoneyToUser::where('id',$requestdetails['id'])->update([
                                'balance_to'=> Crypt::encrypt($calresult['balance']),
                            ]); 
//                            $transactionId = $this->createTID();
                        $this->createPaymentHistory($requestdetails['from'],$requestdetails['balance'],$calresult['balance'],$requestdetails['note'],$requestdetails['transaction_id']);                    
                        //create activity                        
                            $reciver = $this->getReciverNameEmailRoleById($requestdetails['from']);              
                            $sender = $this->getSenderNameEmailRoleById();
                            // method parameter (userid,name,email,status [1=pending,2=success],balance,type 2=requested money,fees,descriptions)
                           $activity1 =  $this->createActivity($sender['id'],$sender['id'],0,$reciver['name'],$reciver['email'],2,$calresult['balance'],1,$calresult['TranCharge'],$requestdetails['note'],$requestdetails['transaction_id'],$requestdetails['currency_requested'],date('Y-m-d'));
                           $activity2 = $this->createActivity($reciver['id'],$sender['id'],0,$sender['name'],$sender['email'],2,$calresult['balance'],3,$calresult['TranCharge'],$requestdetails['note'],$requestdetails['transaction_id'],$requestdetails['currency_requested'],date('Y-m-d'));
                           $activity3 = $this->updateActivityStatus($requestdetails['transaction_id'],Crypt::encrypt(2));
                      $mess =  1;   
                }else{
                    $mess = 'not enough balance';
                }
            }else{
                $mess = 'please enter the amount greater then transaction charge.';
            }
        }catch (DecryptException $e) {           
            $errormes = 'Decryption error';
        }
        catch(QueryException $qe){             
            $errormes = 'User table error';
        }
        catch(Exception $ee){           
            $errormes = 'Code error';
        }finally{  
            if(empty($errormes)){  
                return $mess;   
            }else{
                return $errormes; 
            }     
        }
    }
    public function sendRequestMoneyBalance($requestdetails){
        $errormes = '';       
         try{            
            $balance = $this->getCurrencyBalance($requestdetails['currency_requested']);
            $userbalance = $this->getBalanceByUserId($requestdetails['from'],$requestdetails['currency_requested']);
            
            $charge = $this->transactionCharges(1);
            $calresult = $this->calculateBalanceAfterCharge($requestdetails['balance'],$charge);        
            if($calresult['balance'] > 0){ // check balance after chashgw charge 
            if(($balance != 'no_row') &&  ($balance != 'currencynotfound') && (($balance['balance'] >= $requestdetails['balance']))){ 
                
                //take the send money transaction charge here and add balance
                
                $this->updateUserBalnace(($balance['balance']-$requestdetails['balance']),$balance['rowid'],$requestdetails['currency_requested']);
                $this->updateMasterBalnace(($balance['balance']-$requestdetails['balance']),$requestdetails['currency_requested'],$requestdetails['user_id']);
                
                
                    if(($userbalance != 'no_row') && ($userbalance != 'currencynotfound') && (($userbalance['balance']) >= 0)){ 
                        $result = $this->updateUserBalnace(($userbalance['balance']+$calresult['balance']),$userbalance['rowid'],$requestdetails['currency_requested']);
                        $this->updateMasterBalnace(($userbalance['balance']+$calresult['balance']),$requestdetails['currency_requested'],$requestdetails['from']);
                    }else{
                        $result = $this->createUserBalnace($calresult['balance'],$requestdetails['currency_requested'],$requestdetails['from']);                    
                        $this->updateMasterBalnace($calresult['balance'],$requestdetails['currency_requested'],$requestdetails['from']);
                    }                    
                   // update admin balance
                    $adminbalance = $this->getAdminBalance();
                    $this->updateAdminBalnace(($adminbalance->balance+$calresult['TranCharge']));
                    
                        SendMoneyToUser::where('id',$requestdetails['row_id'])->update([
                            'balance_to'=> Crypt::encrypt($calresult['balance']),
                        ]);  
                    $transactionId = $this->createTID();
                    $this->createPaymentHistory($requestdetails['from'],$requestdetails['balance'],$calresult['balance'],$requestdetails['note'],$transactionId);                    
                    
                    //create activity                        
                    $reciver = $this->getReciverNameEmailRoleById($requestdetails['from']);              
                    $sender = $this->getSenderNameEmailRoleById();
                    // method parameter (userid,name,email,status [1=pending,2=success],balance,type 2=send money,fees,descriptions)
                   $activity1 =  $this->createActivity($sender['id'],$sender['id'],0,$reciver['name'],$reciver['email'],2,$requestdetails['balance'],1,$calresult['TranCharge'],$requestdetails['note'],$transactionId,$requestdetails['currency_requested'],date('Y-m-d'));
                   $activity2 = $this->createActivity($reciver['id'],$sender['id'],0,$sender['name'],$sender['email'],2,$requestdetails['balance'],3,$calresult['TranCharge'],$requestdetails['note'],$transactionId,$requestdetails['currency_requested'],date('Y-m-d'));
                       
                  $mess =  1;   
            }else{
                $mess = 'not enough balance';
            }
            }else{
                $mess = 'please enter the amount greater then transaction charge.';
            }
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
                return $mess;   
            }else{
                return $errormes; 
            }     
        }
    }    
    public function recivedRequestAddBalanceAdmin($rowdetails){
        $errormes = '';
         try{            
            $balance = $this->getAdminBalance();
            $userbalance = $this->getBalanceByUserId($rowdetails->user_id,$rowdetails->currency_requested);              
//            dd($userbalance);
            if(($balance->balance >= $rowdetails->balance)){            
                $this->updateAdminBalnace(($balance->balance-$rowdetails->balance));
                    if(($userbalance != 'no_row') && ($userbalance != 'currencynotfound') && (($userbalance['balance']) >= 0)){                      
                        $result = $this->updateUserBalnace(($userbalance['balance']+$rowdetails->balance),$userbalance['rowid'],$rowdetails->currency_requested);
                        $this->updateMasterBalnace(($userbalance['balance']+$rowdetails->balance),$rowdetails->currency_requested,$rowdetails->user_id);
                    }else{
                        $result = $this->createUserBalnace($rowdetails->balance,$rowdetails->currency_requested,$rowdetails->user_id);                    
                        $this->updateMasterBalnace($rowdetails->balance,$rowdetails->currency_requested,$rowdetails->user_id);
                    }
                 $mess =  1;   
            }else{
                $mess = 'not enough balance';
            }            
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
                return $mess;   
            }else{
                return $errormes; 
            }     
        }
    }
    public function updateBalanceAfterCurrencyConvert($plusAmount,$minuAmount,$fcurrency,$tcurrency,$charge,$tid){
            
        $errormes = '';
         try{            
            $user = Auth::user();   
            $fbalance = $this->getCurrencyBalance($fcurrency);
            $tbalance = $this->getCurrencyBalance($tcurrency);
            $adminbalance = $this->getAdminBalance();
            if($fbalance['balance'] > $minuAmount){
            
                if(($tbalance != 'no_row') && ($tbalance != 'currencynotfound') && (($tbalance['balance']) >= 0)){ 
                    $this->updateUserBalnace(($tbalance['balance']+$plusAmount),$tbalance['rowid'],$tcurrency);            
                    $this->updateMasterBalnace(($tbalance['balance']+$plusAmount),$tcurrency,$user->id);
                }else{                
                    $this->createUserBalnace($plusAmount,$tcurrency,$user->id);                    
                    $this->updateMasterBalnace($plusAmount,$tcurrency,$user->id);
                }  
                
            $this->updateUserBalnace(($fbalance['balance']-$minuAmount),$fbalance['rowid'],$fcurrency);
            $this->updateMasterBalnace(($fbalance['balance']-$minuAmount),$fcurrency,$user->id);
            
            $this->updateAdminBalnace($charge+$adminbalance->balance);                
            $mess =  [
                  'status'=>'success',
                  'fbalance'=>$fbalance['balance']-$minuAmount,
                ];   
                $status = 6;
            }else{
                $mess = 'not enough balance';
                $status = 7;
            }            
            $userdata = $this->getReciverNameEmailRoleById($user->id);  
            // method parameter (userid,name,email,status [1=pending,2=success],balance,type 4=currency conversion,fees,descriptions)
            $this->createActivity($userdata['id'],$userdata['id'],0,$userdata['name'],$userdata['email'],2,$minuAmount,4,$charge,config('constants.CCDES'),$tid,$fcurrency,date('Y-m-d'));
            
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
                return $mess;   
            }else{
                return $errormes; 
            }     
        }
    }    
    //Invoice Payment
    public function invoicePaymentBalance($requestdetails){

    $errormes = ''; 
         try{            
            $balance = $this->getCurrencyBalance($requestdetails['currency_requested']);

            $userbalance = $this->getBalanceByUserId($requestdetails['from'],$requestdetails['currency_requested']);

            $charge = $this->transactionCharges(1);

            $calresult = $this->calculateBalanceAfterCharge($requestdetails['balance'],$charge); 
            if($calresult['balance'] > 0){ // check balance after chashgw charge 
            if(($balance != 'no_row') &&  ($balance != 'currencynotfound') && (($balance['balance'] >= $requestdetails['balance']))){ 
                
                //take the send money transaction charge here and add balance
                
                $this->updateUserBalnace(($balance['balance']-$requestdetails['balance']),$balance['rowid'],$requestdetails['currency_requested']);
                $this->updateMasterBalnace(($balance['balance']-$requestdetails['balance']),$requestdetails['currency_requested'],$requestdetails['user_id']);
                
                
                    if(($userbalance != 'no_row') && ($userbalance != 'currencynotfound') && (($userbalance['balance']) >= 0)){ 
                        $result = $this->updateUserBalnace(($userbalance['balance']+$calresult['balance']),$userbalance['rowid'],$requestdetails['currency_requested']);
                        $this->updateMasterBalnace(($userbalance['balance']+$calresult['balance']),$requestdetails['currency_requested'],$requestdetails['from']);
                    }else{
                        $result = $this->createUserBalnace($calresult['balance'],$requestdetails['currency_requested'],$requestdetails['from']);                    
                        $this->updateMasterBalnace($calresult['balance'],$requestdetails['currency_requested'],$requestdetails['from']);
                    }                    
                   // update admin balance
                    $adminbalance = $this->getAdminBalance();
                    $this->updateAdminBalnace(($adminbalance->balance+$calresult['TranCharge']));
                        
                        CreateInvoice::where('id', $requestdetails['invoiceId'])->update(['invoice_status' => '5']);
                          
//                    $transactionId = $this->createTID();
                    $this->createPaymentHistory($requestdetails['from'],$requestdetails['balance'],$calresult['balance'],$requestdetails['note'],$requestdetails['transaction_id']);                    
                    
                    //create activity    
                    $reciver = $this->getReciverNameIDRoleByEmail($requestdetails['email_id']);                    
                    $sender = $this->getSenderNameEmailRoleById();
                    // method parameter (userid,name,email,status [1=pending,2=success],balance,type 2=send money,fees,descriptions)
                   $activity1 =  $this->createActivity($sender['id'],$sender['id'],$requestdetails['invoiceId'],$reciver['name'],$reciver['email'],2,$calresult['balance'],8,$calresult['TranCharge'],$requestdetails['note'],$requestdetails['transaction_id'],$requestdetails['currency_requested'],date('Y-m-d'));
                   $activity2 = $this->createActivity($reciver['id'],$sender['id'],$requestdetails['invoiceId'],$sender['name'],$sender['email'],2,$calresult['balance'],7,$calresult['TranCharge'],$requestdetails['note'],$requestdetails['transaction_id'],$requestdetails['currency_requested'],date('Y-m-d'));
                   $activity3 = $this->updateActivityStatus($requestdetails['transaction_id'],Crypt::encrypt(2));
                   $client = User::where('id', $reciver['id'])->first();
                   $notifydata = [            
                           'balance' => $calresult['balance'],              
                           'action'=>'paid',
                           'process'=>2,    
                           'request_status' => 5,
                           'tab'=>$client->role,
                           'showdate'=>date('Y-m-d'),
                       ];
                       
                       $client->notify(new Invoice($notifydata)); 
                       
                  $mess =  array('status' => 'paid', 'message' => 'Invoice paid successfully.','userId'=>$requestdetails['login_id']);                      
                  }else{                    
                $mess = array('status' => 'noMoney', 'message' => 'You have not enough money. Please add money in your account.','userId'=>$requestdetails['login_id']);
            }
            }else{                
                $mess = array('status' => 'noMoney', 'message' => 'please enter the amount greater then transaction charge.','userId'=>$requestdetails['login_id']);
            }
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
                return $mess;   
            }else{
                return $errormes; 
            }     
        }
    }    
}