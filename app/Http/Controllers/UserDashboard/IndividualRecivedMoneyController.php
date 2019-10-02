<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\Traits\BalanceTrait;
use App\RequestForMoneyToUser;
use App\RequestForMoneyToAdmin;
use App\SendMoneyToUser;
use App\IndividualKyc;
use App\BusinessKyc;
use App\User;
class IndividualRecivedMoneyController extends Controller
{
    use BalanceTrait;
    
    public function index($id) {
        try{ 
            $user = Auth::user();
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception(config('constants.DecryptionError'));
            }       
            $usersrecord = array();
            $requestUsers = RequestForMoneyToUser::select('user_id','balance_to','currency_requested','updated_at')->where('from',$user->id)->where('action',2)->where('status',2)->orderby('updated_at','desc')->get(); 
            $requestAdmin = RequestForMoneyToAdmin::select('user_id','balance','currency_requested','updated_at')->where('user_id',$user->id)->where('admin_action',2)->where('status',2)->orderby('updated_at','desc')->get(); 
            $sendMoney = SendMoneyToUser::select('from','balance_to','currency_requested','updated_at')->where('user_id',$user->id)->where('action',2)->where('status',2)->orderby('updated_at','desc')->get();

            $results1 = array();
            foreach($requestUsers as $value){
                $userdata = User::where('id',$value->user_id)->select('id','email','role')->first();
                if($userdata->role == 2){
                    $name = BusinessKyc::where('user_id',$value->user_id)->select('fname')->first();
                }else{
                    $name = IndividualKyc::where('user_id',$value->user_id)->select('fname')->first();
                }
                $results1[] = [
                    'name'=>$name->fname,    
                    'email'=>$userdata->email,    
                    'form' => $value->user_id,
                    'balance'=>$value->balance_to,    
                    'currencytype'=>$value->currency_requested,
                    'date'=>$value->updated_at   
                ];
            }

            $results2 = array();
            foreach($requestAdmin as $value){
                $userdata = User::where('id',$value->user_id)->select('id','email','role')->first();
                if($userdata->role == 2){
                    $name = BusinessKyc::where('user_id',$value->user_id)->select('fname')->first();
                }else{
                    $name = IndividualKyc::where('user_id',$value->user_id)->select('fname')->first();
                }
                $results2[] = [
                    'name'=>$name->fname,    
                    'email'=>$userdata->email,    
                    'form' => $value->user_id,
                    'balance'=>$value->balance,    
                    'currencytype'=>$value->currency_requested,
                    'date'=>$value->updated_at   
                ];
            }
            
            $results3 = array();
            foreach($sendMoney as $value){
                $userdata = User::where('id',$value->from)->select('id','email','role')->first();
                if($userdata->role == 2){
                    $name = BusinessKyc::where('user_id',$value->from)->select('fname')->first();
                }else{
                    $name = IndividualKyc::where('user_id',$value->from)->select('fname')->first();
                }
                $results3[] = [
                    'name'=>$name->fname,    
                    'email'=>$userdata->email,    
                    'form' => $value->from,
                    'balance'=>$value->balance_to,    
                    'currencytype'=>$value->currency_requested,
                    'date'=>$value->updated_at   
                ];
            }
            //Mass update Notofication
            $user->unreadNotifications()->where('notifiable_type','App\User')->whereIn('type',['App\Notifications\SendMoney','App\Notifications\AdminNotify','App\Notifications\RequestPayment'])->update(['read_at' => now()]);
                        
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
                return view('pages.user.recived-money',['user_id'=>$id,'balance'=>$this->getBalance(),'requestUsers'=>$results1,'requestAdmin'=>$results2,'sendMoney'=>$results3]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
                return redirect('/login');
            }       
        }
    }
}
