<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\Business;
use App\Individual;
use App\DefaultTransactionCharge;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AccountApproval;
class AdminManageAccountsController extends Controller
{
    use Notifiable;
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
        $defaultTCharge = DefaultTransactionCharge::where('charge_type',1)->get();        
        $BusinessUser = DB::table('users')
            ->join('businesses', 'users.id', '=', 'businesses.user_id')
            ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
            ->select('users.email',
                    'users.fees',
                    'businesses.user_id',
                    'businesses.account_status',
                    'business_kycs.business_type',
                    'business_kycs.business_name',
                    'business_kycs.fname',
                    'business_kycs.add_line_one',
                    'business_kycs.add_line_two',
                    'business_kycs.town_or_city',
                    'business_kycs.state',
                    'business_kycs.country')            
                    ->where('users.role', '=', 2)            
            ->get();
        
        $IndividualUser = DB::table('users')
            ->join('individuals', 'users.id', '=', 'individuals.user_id')
            ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
            ->select('users.email',
                    'users.fees',
                    'individuals.user_id',
                    'individuals.account_status',
                    'individual_kycs.fname',
                    'individual_kycs.add_line_one',
                    'individual_kycs.add_line_two',
                    'individual_kycs.town_or_city',
                    'individual_kycs.state',
                    'individual_kycs.country')            
                    ->where('users.role', '=', 1)            
            ->get();

            return view('pages.admin.manage-accounts',['IndividualUser'=>$IndividualUser,'BusinessUser'=>$BusinessUser,'defaultTCharge'=>$defaultTCharge]);        
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
            $user = DB::table('users')->where('id',decrypt($id))->first();            
          if($user->role == 1){
              $data = DB::table('users')
                    ->join('individuals', 'users.id', '=', 'individuals.user_id')
                    ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
                    ->select('users.email',
                            'users.id',
                            'users.fees',
                            'users.role',
                            'individuals.verify',
                            'individuals.kyc_verify',
                            'individuals.account_status',
                            'individuals.lang',
                            'individuals.primary_email',
                            'individuals.secondary_email',
                            'individuals.primary_phone',
                            'individuals.secondary_phone',
                            //represantive Info                            
                            'individual_kycs.fname',
                            'individual_kycs.mname',
                            'individual_kycs.lname',
                            'individual_kycs.dob',
                            'individual_kycs.passport_no',
                            'individual_kycs.passport_country',
                            'individual_kycs.passport_expdate',
                            'individual_kycs.passport',
                            //address                            
                            'individual_kycs.add_line_one',
                            'individual_kycs.add_line_two',
                            'individual_kycs.town_or_city',
                            'individual_kycs.state',
                            'individual_kycs.country',     
                            'individual_kycs.zip',
                            'individual_kycs.currency',     
                            'individual_kycs.address_proof',
                            //address                            
                            'individual_kycs.photo')            
                            ->where('users.role', '=', 1)
                            ->where('users.id',decrypt($id))
                    ->first();
          }else if($user->role == 2){
              $data = DB::table('users')
                    ->join('businesses', 'users.id', '=', 'businesses.user_id')
                    ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
                    ->select('users.email',
                            'users.id',
                            'users.fees',
                            'users.role',
                            'businesses.verify',
                            'businesses.kyc_verify',
                            'businesses.account_status',
                            'businesses.lang',
                            'businesses.primary_email',
                            'businesses.secondary_email',
                            'businesses.primary_phone',
                            'businesses.secondary_phone',
                            //business stap
                            'business_kycs.business_name',
                            'business_kycs.business_type',
                            'business_kycs.business_certificate',
                            'business_kycs.business_memorandum',
                            //represantive Info                            
                            'business_kycs.fname',
                            'business_kycs.mname',
                            'business_kycs.lname',
                            'business_kycs.dob',
                            'business_kycs.passport_no',
                            'business_kycs.passport_country',
                            'business_kycs.passport_expdate',
                            'business_kycs.passport',
                            //address                            
                            'business_kycs.add_line_one',
                            'business_kycs.add_line_two',
                            'business_kycs.town_or_city',
                            'business_kycs.state',
                            'business_kycs.country',     
                            'business_kycs.zip',
                            'business_kycs.currency',     
                            'business_kycs.address_proof',
                            //address                            
                            'business_kycs.photo')   
                            ->where('users.role', '=', 2) 
                            ->where('users.id',decrypt($id))
                    ->first();
          }          
//          dd($data);
        return view('pages.admin.view-accounts',['data'=>$data]);
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
        if($request->role == 2){
            $data = Business::where('user_id',$id)->first();        
        }else{
            $data = Individual::where('user_id',$id)->first();
        }
        $data->account_status = $request->status;
        $data->save();
        $notifydata = [
                        'request_status' => 6,
                        'action'=>'accountupdate',
                        'process'=>$request->status,
                        'type'=>'accountUpdate',
                    ];
        $userdeatils = User::where('id',$id)->first();  
        $userdeatils->notify(new AccountApproval($notifydata));  
        
        if($request->status == 2){
            $mess = config('constants.AccountdeDeactive');
        }else{
            $mess = config('constants.AccountActive');
        }
        session()->flash('status',$mess);        
        return redirect()->back();
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
