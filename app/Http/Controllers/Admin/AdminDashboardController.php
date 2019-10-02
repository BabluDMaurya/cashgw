<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Individual;
use App\Business;
use App\RequestForMoneyToAdmin;
use App\AdminAmountBalanceMaster;
class AdminDashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }
    public function index(){
        if(Auth::check()){
            $adminbal = AdminAmountBalanceMaster::select('balance')->first();
            
            $businesskyc = Business::where('admin_verify',0)->where('kyc_verify',1)->where('account_status',1)->count('id');
            $individualkyc = Individual::where('admin_verify',0)->where('kyc_verify',1)->where('account_status',1)->count('id');
            $totalkyc = number_format($individualkyc + $businesskyc);
            if(!empty($totalkyc)){
                $totalkycs= $totalkyc;
            }else{
                $totalkycs = 0;
            }
            
            $business = number_format(Business::where('admin_verify',1)->where('account_status',1)->count('id'));
            if(!empty($business)){
                $businesss = $business;
            }else{
                $businesss = 0;
            }
            $individual = number_format(Individual::where('admin_verify',1)->where('account_status',1)->count('id'));
            if(!empty($individual)){
                $individuals = $individual;
            }else{
                $individuals = 0;
            }
                        
            $requestmoneysum = array();
            $requestmoney = RequestForMoneyToAdmin::where('admin_action',1)->select('balance')->get();            
            if(!empty($requestmoney)){
                foreach($requestmoney as $balance){
                    $requestmoneysum[] = $balance->balance;
                }
                $totalrequest = number_format(array_sum($requestmoneysum),2);            
            }else{
                $totalrequest = 0.00;
            }
            $adminbalanc = number_format($adminbal->balance,2);
            return view('pages.admin.index',['totalrequestmoney'=>$totalrequest,'tbaccount'=>$businesss,'tiaccount'=>$individuals,'tkyc'=>$totalkycs,'adminbalance'=>$adminbalanc]);
        }
    }
}
