<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\AdminLogin;
class ManagePaymentRequestController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
        $IndividualPaymentRequest = DB::table('users')
            ->join('individuals', 'users.id', '=', 'individuals.user_id')
            ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
            ->join('request_for_money_to_admins', 'users.id', '=', 'request_for_money_to_admins.user_id') 
            ->select('users.email',
                    'request_for_money_to_admins.created_at',
                    'individual_kycs.fname',
                    'request_for_money_to_admins.id',
                    'request_for_money_to_admins.balance',
                    'request_for_money_to_admins.bank_name',
                    'request_for_money_to_admins.refcode',
                    'request_for_money_to_admins.admin_action',
                    'request_for_money_to_admins.currency_requested')            
                    ->where('users.role', '=', 1)            
            ->get(); 
        
        $BusinessPaymentRequest = DB::table('users')
            ->join('businesses', 'users.id', '=', 'businesses.user_id')
            ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
            ->join('request_for_money_to_admins', 'users.id', '=', 'request_for_money_to_admins.user_id')
            ->select('users.email',
                    'request_for_money_to_admins.created_at',                    
                    'business_kycs.fname',
                    'business_kycs.business_type',
                    'request_for_money_to_admins.id',                    
                    'request_for_money_to_admins.balance',
                    'request_for_money_to_admins.bank_name',
                    'request_for_money_to_admins.refcode',
                    'request_for_money_to_admins.admin_action',
                    'request_for_money_to_admins.currency_requested')            
                    ->where('users.role', '=', 2)            
            ->get(); 
        $user = AdminLogin::where('email',config('constants.AdminMail'))->first();
        $user->unreadNotifications()->where('notifiable_type','App\AdminLogin')->whereIn('type',['App\Notifications\ManagePaymentRequest'])->update(['read_at' => now()]);
        return view('pages.admin.manage-payment-request',compact('IndividualPaymentRequest','BusinessPaymentRequest')) ;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
