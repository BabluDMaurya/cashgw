<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\AdminLogin;
use App\User;
use Mail;
use File;
use App\Mail\CloseAccountMailToAdmin;
use App\Mail\CloseAccountMailToUser;
use App\Http\Requests\AccountRequest;
use Validator;
use Hash;
use App\Traits\BalanceTrait;
use App\ChangePrimaryAddressRequest;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UpdateApproval;
class IndividualAccountSettingController extends Controller {
    
    use BalanceTrait,Notifiable;    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $user = Auth::user();
        $mes = 'No record added';
        
        if (isset($request->phonenumber)) {
            $this->validate($request, [
                'phonenumber' => 'required|max:11',
                    ], [
                'phonenumber.required' => 'Phone Number Required',
                'phonenumber.max' => 'Phone Number Should be 11 digits',
            ]);
            if ($request->phonenumbervalue == 1) {
                $user->individual->primary_phone = $request->phonenumber;
                $user->individual->save();

                $user->master->primary_phone = $request->phonenumber;
                $user->master->save();
            } else {
                $user->individual->secondary_phone = $request->phonenumber;
                $user->individual->save();

                $user->master->secondary_phone = $request->phonenumber;
                $user->master->save();
            }
            $mes = 'Phone number added Successfully';
        }
        if (isset($request->emailaddress)) {
            $this->validate($request, [
                'emailaddress' => ['required', 'string', 'email','emailformate','max:255', 'emaildomain', 'uniqueemail', 'unique:users,email'],
                    ], [
                'emailaddress.unique' => '(' . $request->emailaddress . ') email address already exists',
            ]);

            if ($request->emailaddressvalue == 1) {
                $user->individual->primary_email = $request->emailaddress;
                $user->individual->save();

                $user->master->primary_email = $request->emailaddress;
                $user->master->save();
            } else {
                $user->individual->secondary_email = $request->emailaddress;
                $user->individual->save();

                $user->master->secondary_email = $request->emailaddress;
                $user->master->save();
            }
            $mes = 'Email address added Successfully';
        }
        if (isset($request->addlone)) {
            $this->validate($request, [
                'addlone' => 'required',
                'towncity' => 'required|alpha',
                'zip' => 'required',
                'state' => 'required|alpha',
                'country' => 'alpha',
                    ], [
                'addlone.required' => 'Address Line 1 Required',
                'towncity.required' => 'Town/ City Required',
                'towncity.alpha' => 'Only Alphabate allow',
                'zip.required' => 'Please provide a valid zipcode.',
                'state.required' => 'State Required',
                'state.alpha' => 'Only Alphabate allow',
                'country.alpha' => 'Only Alphabate allow',
            ]);

            if ($request->addressvalue == 1) {
                $user->individual->billing_address_line_one = $request->addlone;
                $user->individual->billing_address_line_two = $request->addltwo;
                $user->individual->billing_address_townOrcity = $request->towncity;
                $user->individual->billing_address_zipcode = $request->zip;
                $user->individual->billing_address_state = $request->state;
                $user->individual->billing_address_country = $request->country;
                $user->individual->save();

                $user->master->billing_address_line_one = $request->addlone;
                $user->master->billing_address_line_two = $request->addltwo;
                $user->master->billing_address_townOrcity = $request->towncity;
                $user->master->billing_address_zipcode = $request->zip;
                $user->master->billing_address_state = $request->state;
                $user->master->billing_address_country = $request->country;
                $user->master->save();
            }
            $mes = 'Address added Successfully';
        } 
        
            if (!empty($request->AddressLineOne)){
                
                $this->validate($request, [
                    'AddressLineOne' => 'required',
                    'TownOrCity' => 'required|alpha',
                    'Zipcode' => 'required',
                    'State' => 'required|alpha',
                    'Country' => 'alpha',
                    'approvalproofaddress' => 'required'
                        ], [
                    'AddressLineOne.required' => 'Address Line 1 Required',
                    'TownOrCity.required' => 'Town/ City Required',
                    'TownOrCity.alpha' => 'Only Alphabate allow',
                    'Zipcode.required' => 'Please provide a valid zipcode.',
                    'State.required' => 'State Required',
                    'State.alpha' => 'Only Alphabate allow',
                    'Country.alpha' => 'Only Alphabate allow',
                    'approvalproofaddress.required' => 'Address Proof required',
                ]);               
                
                if ($request->primaryaddressvalue == 3) {  
                    
                    if ($request->hasFile('approvalproofaddress')) {                 
                        $file = $request->file('approvalproofaddress');                
                        $approvalproofaddressfileName = $user->id.'_approvalproofaddress'.time().'.'. $file->getClientOriginalExtension();
                        $fileuploadpath = public_path().'/images/'.$user->id;
                        $file->move($fileuploadpath, $approvalproofaddressfileName); 
                    }else{
                        $approvalproofaddressfileName = $request->approvalproofaddressold;
                    }  
                    
                    ChangePrimaryAddressRequest::create([
                        'user_id' => $user->id,
                        'role' => $request->role,
                        'add_line_one' => $request->AddressLineOne,
                        'add_line_two' => $request->AddressLineTwo,                
                        'town_or_city' => $request->TownOrCity,
                        'zip' => $request->Zipcode,
                        'state' => $request->State,                
                        'country' => $request->Country,
                        'address_proof'=>$approvalproofaddressfileName,                        
                    ]);
                }
                $notifydata = [
                            'request_status' => 7,
                            'action'=>'Approval',
                            'process'=>1,
                            'type'=>'UpdateApproval',
                            'tab' => 1,
                        ];
                
                $admin = AdminLogin::where('email',config('constants.AdminMail'))->first();
                $admin->notify(new UpdateApproval($notifydata));
                $mes = 'Approval Request Sent Successfully.Please wait for the admin approval.';
            }
        
        session()->flash('status', $mes);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        try {
            $user = Auth::user();
            $decrypted = Crypt::decrypt($id);
            if ($user->id != $decrypted) {
                throw new Exception("User not login");
            }
            $bal = array();
            $mybals = $this->getBalance();
            if(count($mybals) > 0){
            if(count($mybals) > 1){
                    foreach($mybals as $mybal){                
                        if($mybal['currency_requested'] == 2){
                            $bal['EUR'] = $mybal['balance'];
                        }else{
                            $bal['USD'] = $mybal['balance'];
                        }                
                    }
                }else{
                    foreach($mybals as $mybal){                
                        if($mybal['currency_requested'] == 2){
                            $bal['EUR'] = $mybal['balance'];
                            $bal['USD'] = 0.00;
                        }else{
                            $bal['USD'] = $mybal['balance'];
                            $bal['EUR'] = 0.00;
                        }                
                    }          
                }           
            }else{
                $bal['EUR'] = 0.00;
                $bal['USD'] = 0.00;
            }
            //Mass update Notofication
            $user->unreadNotifications()->where('notifiable_type','App\User')->whereIn('type',['App\Notifications\AccountApproval','App\Notifications\UpdateApproval'])->update(['read_at' => now()]);
        } catch (DecryptException $e) {
            $errormes = 'Decryption error';
        } catch (QueryException $qe) {
            $errormes = 'User table error';
        } catch (Exception $ee) {
            $errormes = 'Code error';
        } finally {
            if (empty($errormes)) {
                return view('pages.user.account-setting', ['user_id' => $id, 'user_email' => $user->email, 'user_join' => $user->created_at, 'individual' => $user->individual, 'individualkyc' => $user->individualkyc,'balance'=>$bal]);
            } else {
                Auth::logout();
                session()->flash('status', $errormes);
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
    public function edit($id) {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
//        try{
//        dd($request->session()->all());
        if (Auth::Check()) {
            $user = Auth::user();
            $decrypted = Crypt::decrypt($id);
            if ($user->id != $decrypted) {
                Auth::logout();
                session()->flash('status', 'Decryption error');
                return redirect('/login');
            }
            $mes = 'Updated Unsuccessfully.';

            if (!empty($request->phonenumber) && ($decrypted == $user->id)) {
                $validator = Validator::make($request->all(), [
                            'phonenumber' => 'required|max:11',
                                ], [
                            'phonenumber.required' => 'Phone Number Required',
                            'phonenumber.max' => 'Phone Number Should be 11 digits',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                if ($request->phoneid == 1) {
                    $user->individual->primary_phone = $request->phonenumber;
                    $user->individual->save();

                    $user->master->primary_phone = $request->phonenumber;
                    $user->master->save();
                } else {
                    if($request->phonenumbervalue == 1){
                            $user->individual->primary_phone = $request->phonenumber;
                            $user->individual->secondary_phone = Null;
                            $user->individual->save();

                            $user->master->primary_phone = $request->phonenumber;
                            $user->master->secondary_phone = Null;
                            $user->master->save();
                    }else{
                        $user->individual->secondary_phone = $request->phonenumber;
                        $user->individual->save();

                        $user->master->secondary_phone = $request->phonenumber;
                        $user->master->save();   
                    }
                }
                $mes = 'Phone number Updated Successfully.';
            }

            if (!empty($request->emailaddress) && ($decrypted == $user->id)) {
                $validator = Validator::make($request->all(), [
                            'emailaddress' => ['required', 'string', 'email','emailformate','unique:users,email', 'uniqueemail', 'max:255', 'emaildomain'],
                                ], [
                            'emailaddress.unique' => '(' . $request->emailaddress . ') email address already exists',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                if ($request->emailid == 1) {
                    $user->individual->primary_email = $request->emailaddress;
                    $user->individual->save();

                    $user->master->primary_email = $request->emailaddress;
                    $user->master->save();
                } else {
                    $user->individual->secondary_email = $request->emailaddress;
                    $user->individual->save();

                    $user->master->secondary_email = $request->emailaddress;
                    $user->master->save();
                }
                $mes = 'Email Updated Successfully.';
            }

            if (!empty($request->addlone) && ($decrypted == $user->id)) {

                $validator = Validator::make($request->all(), [
                            'addlone' => 'required',
                            'towncity' => 'required|alpha',
                            'zip' => 'required',
                            'state' => 'required|alpha',
                            'country' => 'alpha',
                                ], [
                            'addlone.required' => 'Address Line 1 Required',
                            'towncity.required' => 'Town/ City Required',
                            'towncity.alpha' => 'Only Alphabate allow',
                            'zip.required' => 'Please provide a valid zipcode.',
                            'state.required' => 'State Required',
                            'state.alpha' => 'Only Alphabate allow',
                            'country.alpha' => 'Only Alphabate allow',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                if ($request->addressvalue == 2) {
                    $user->individual->billing_address_line_one = $request->addlone;
                    $user->individual->billing_address_line_two = $request->addltwo;
                    $user->individual->billing_address_townOrcity = $request->towncity;
                    $user->individual->billing_address_zipcode = $request->zip;
                    $user->individual->billing_address_state = $request->state;
                    $user->individual->billing_address_country = $request->country;
                    $user->individual->save();

                    $user->master->billing_address_line_one = $request->addlone;
                    $user->master->billing_address_line_two = $request->addltwo;
                    $user->master->billing_address_townOrcity = $request->towncity;
                    $user->master->billing_address_zipcode = $request->zip;
                    $user->master->billing_address_state = $request->state;
                    $user->master->billing_address_country = $request->country;
                    $user->master->save();
                }
                $mes = 'Address added Successfully';
            }



            if (!empty($request->FirstName) && ($decrypted == $user->id)) {
                $validator = Validator::make($request->all(), [
                    'FirstName' => 'required',
                    'LastName' => 'required',
                    'LangId' => 'required',
                    'Country' => 'required',
                        ], [
                    'FirstName.required' => 'First Name Required',
                    'LastName.required' => 'Last Name Required',
                    'LangId.required' => 'Language Required',
                    'Country.required' => 'Country Required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }

                $user->individualkyc->fname = $request->FirstName;
                $user->individualkyc->mname = $request->MiddleName;
                $user->individualkyc->lname = $request->LastName;
                $user->individualkyc->country = $request->Country;
                $user->individualkyc->save();

                $user->individual->lang = $request->LangId;
                $user->individual->save();

                $user->master->fname = $request->FirstName;
                $user->master->mname = $request->MiddleName;
                $user->master->lname = $request->LastName;
                $user->master->country = $request->Country;
                $user->master->lang = $request->LangId;
                $user->master->save();

                $mes = 'Personal Details Update Successfully';
            }
            
            if (!empty($mes)) {
                session()->flash('status', $mes);
                return redirect()->back();
            }
        } else {
            Auth::logout();
            session()->flash('status', 'Logout');
            return redirect('/login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $user = Auth::user();
        $admin = AdminLogin::find(1);
        try {
            $decrypted = Crypt::decrypt($id);
            if ($user->id != $decrypted) {
                throw new Exception("User not login");
            }
            $user->individual->account_status = 2;
            $user->individual->save();

            $user->master->account_status = 2;
            $user->master->save();

            Mail::to($admin->email)->send(new CloseAccountMailToAdmin());
            Mail::to($user->email)->send(new CloseAccountMailToUser());
        } catch (DecryptException $e) {
            $errormes = 'Decryption error';
        } catch (QueryException $qe) {
            $errormes = 'User table error';
        } catch (Exception $ee) {
            $errormes = 'Code error';
        } finally {
            if (empty($errormes)) {
                Auth::logout();
                return redirect('/');
            } else {
                return back()->with($errormes);
            }
        }
    }

    public function AddProfilePic(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'myphoto' => 'required',
                ], [
            'myphoto.required' => 'Image Required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $image = base64_decode($request->myphoto);
        // echo "<pre>";
        // print_r($image);exit;
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $image_name = $user->id . '_PhotoFile.png';
        $path = public_path() . '/images/' . $user->id . '/' . $image_name;

        file_put_contents($path, $image);

        $user->individualkyc->photo = $image_name;
        $user->individualkyc->save();

        $user->master->photo = $image_name;
        $user->master->save();

        echo '/public/images/' . $user->id . '/' . $image_name;
    }

}
