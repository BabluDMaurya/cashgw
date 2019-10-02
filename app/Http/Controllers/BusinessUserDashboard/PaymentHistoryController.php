<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\BusinessTotalTransaction;
class PaymentHistoryController extends Controller
{
    public function index($id){
        try{            
            $user = Auth::user();            
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception("User not login");
            }
            if($user->role == 2){
                $totaltransaction = $user->businesstotaltran()->where('archieve',1)->orderBy('updated_at','DESC')->get();
            }else{
                $totaltransaction = $user->individualtotaltran()->where('archieve',1)->orderBy('updated_at','DESC')->get();
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
                return view('pages.business.payment-history',['user_id'=>$id,'paymenthistory'=>$totaltransaction]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
                return redirect('/login');
            }       
        }
    }
    public function archieveView(Request $request){
        try{            
            $user = Auth::user();                        
            if($user->role == 2){
                $totaltransaction = $user->businesstotaltran()->where('archieve',$request->status)->orderBy('updated_at','DESC')->get();
            }else{
                $totaltransaction = $user->individualtotaltran()->where('archieve',$request->status)->orderBy('updated_at','DESC')->get();
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
                return view('pages.business.payment-history-list',['user_id'=>$request->id,'paymenthistory'=>$totaltransaction]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
                return redirect('/login');
            }       
        }
    }
    public function updateArchieve(Request $request){
        if(Auth::check()){
            BusinessTotalTransaction::where('id',$request->rowid)->update([ 'archieve'=>$request->status]);
            echo 'updated';
        }
    }
}
