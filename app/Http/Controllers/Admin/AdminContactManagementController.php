<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Contact;
use App\AdminLogin;
class AdminContactManagementController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }
    public function index() 
    {        
    	if(Auth::check()) {      
            $data = Contact::orderBy('created_at', 'desc')->get();    
            //Mass update Notofication
            $user = AdminLogin::where('email',config('constants.AdminMail'))->first();
            $user->unreadNotifications()->where('notifiable_type','App\AdminLogin')->whereIn('type',['App\Notifications\ContactUs'])->update(['read_at' => now()]);
            return view('pages.admin.contact-management',['datas'=>$data]);
        }
	}
	public function adminContact(Request $request)
	{
        try {
        	$validation_rules = array(
	            'email'    => 'required|email',
	            'message' => 'required',
	            'message_id' => 'required',
	        );
        	$this->validate($request,$validation_rules);
        } catch (\Exception $e) {
        	$response = array('status' => false,'message'=>'somthing went wrong');
        	return response()->json($response, 200);exit();
        }
        try {
        	$contact = Contact::find(\Crypt::decrypt($request->message_id));
		    $contact->admin_reply = $request->message;
			$contact->save();
        } catch (\Exception $e) {
        	$response = array('status' => false,'message'=>'id is not validate or something went wrong');
        	return response()->json($response, 200);exit();
        }
        try {
        	$this->email_payload['message'] = $request->message ;
        	\Mail::to($request->email)->send(new \App\Mail\AdminReplay($this->email_payload));	
        } catch (\Exception $e) {
        	$response = array('status' => false,'message'=>'Email has not been send');
        	return response()->json($response, 200);exit();	
        }
        $response = array('status' => true,'message'=>'Email has been send successfully..!!!!');
        return response()->json($response, 200);
        
	}
        public function contactDelete(Request $request){ 
                $recorddelete = Contact::where('id',$request->id)->delete();
                $response = array('status' => true,'message'=>'Message Deleted successfully.');
        	return response()->json($response, 200);                
    }
}
