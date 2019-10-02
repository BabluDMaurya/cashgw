<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Session;
class MyDashboard extends Controller{
    protected function redirectUserDashboardBaseOnRole() {
        $roles = Auth::user()->role;
            if(Session::has('invoiceId')){
                $invoiceId = Session::get('invoiceId');
                $url = '/pay-invoice/'.encrypt($invoiceId);
                return redirect($url);
            }else if($roles == 1){   
                $id = Auth::user()->id;     
                $url = '/individual-account/'.Crypt::encrypt($id);
                Session::put('logindashboard', $url);
                return redirect($url);             
            }else if($roles == 2){
                $id = Auth::user()->id;                
                $url = '/business-account/'.Crypt::encrypt($id);
                Session::put('logindashboard', $url);
                return redirect($url);                 
            }else{
//                Auth::logout();
                return redirect('/login')->with('status','logout from dashboard');
            }
    }
}
