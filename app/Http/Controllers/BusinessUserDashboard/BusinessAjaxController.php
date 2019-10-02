<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\AddressBook;
use App\Traits\CurrencyConverterAPI;
class BusinessAjaxController extends Controller
{
    use CurrencyConverterAPI;
    public function autoComplete(Request $request) {
        $user = Auth::user(); 
        $query = $request->get('term','');  
        $data=array();
        if(is_numeric($query) == TRUE){
            $data[0]=array('value'=>'Only Email Allowed','id'=>0);
            return $data;            
        }else{     
            $emails = AddressBook::where('user_id',$user->id)->where('status',1)->where('email','LIKE','%'.$query.'%')->get(); 
            
            foreach ($emails as $email) {
                $data[]=array('value'=>$email->email,'id'=>$email->id);
            }
            if(count($data))
                return $data;
            else
                $data[0]=array('value'=>'No Record Found','id'=>0);
                return $data;
        }
    }
    public function setSessionBackUrl(Request $request){
        if(!empty($request->get('backUrl',''))){
            $request->session()->put('backUrl', $request->get('backUrl',''));            
            if ($request->session()->has('backUrl')) {
                return  'true';
            }else{
                return  'false';
            }            
        }else{
            return  'false';
        } 
    }
}
