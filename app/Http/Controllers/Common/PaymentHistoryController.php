<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;

class PaymentHistoryController extends Controller
{
    public function index($id){
//        $user = Auth::user();    
//        if($user->role == 2){
//                $totaltransaction = $user->businesstotaltran()->orderBy('updated_at','DESC')->get();
//            }else{
//                $totaltransaction = $user->individualtotaltran()->orderBy('updated_at','DESC')->get();
//            }
//            dd($totaltransaction);
        try{            
            $user = Auth::user();            
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception("User not login");
            }
            if($user->role == 2){
                $totaltransaction = $user->businesstotaltran()->orderBy('updated_at','DESC')->get();
            }else{
                $totaltransaction = $user->individualtotaltran()->orderBy('updated_at','DESC')->get();
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
                return view('pages.common.payment-history',['user_id'=>$id,'paymenthistory'=>$totaltransaction]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
                return redirect('/login');
            }       
        }
    }
}
