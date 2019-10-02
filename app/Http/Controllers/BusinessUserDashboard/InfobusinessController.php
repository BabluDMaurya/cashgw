<?php
namespace App\Http\Controllers\BusinessUserDashboard;
use Illuminate\Http\Request;
use App\Mail\BuKycMail;
use App\Mail\AdminVerifyMail;
use Mail;
use App\Http\Requests\InfoBusinessRequest;
use App\Business;
use App\BusinessKyc;
use Auth;
use App\VerifyUser;
use File;
use App\AdminLogin;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Activity;
use Illuminate\Notifications\Notifiable;
use App\Notifications\BusinessApproval;
use App\Notifications\IndividualApproval;
use App\UnRegisterEmail;
use App\RequestForMoneyToUser;
class InfobusinessController extends Controller
{
    use Notifiable;
    public function index(){  
        $user = Auth::user();
        $user_id =$user->id; 
        return view('pages.business.info-business',['user_id'=>$user_id]);
    }
    
    public function KycFormSubmit(InfoBusinessRequest $request){ 
        $user = Auth::user();    
        $fileName = null;
        $bcfileName = null;
        $passfileName = null;
        $paddfileName = null;        
        $errormes = '';   
        
        try{
            $fileuploadpath = public_path().'/images/'.$user->id;
            File::isDirectory($fileuploadpath) or File::makeDirectory($fileuploadpath, 0777, true, true);
            if (request()->hasFile('bcirtificate')) {                 
                $file = $request->file('bcirtificate');                
                $bcfileName = $user->id.'_bcirtificate_'. $file->getClientOriginalExtension();
                $file->move($fileuploadpath, $bcfileName); 
            }
            if (request()->hasFile('passfile')) {                 
                $file = $request->file('passfile');                
                $passfileName = $user->id.'_passfile_'. $file->getClientOriginalExtension();
                $file->move($fileuploadpath, $passfileName); 
            }
            if (request()->hasFile('proofaddress')) {                 
                $file = $request->file('proofaddress');                
                $paddfileName = $user->id.'_proofaddress_'. $file->getClientOriginalExtension();
                $file->move($fileuploadpath, $paddfileName); 
            } 
            if (request()->hasFile('memorandum')) {                 
                $file = $request->file('memorandum');                
                $memofileName = $user->id.'_memorandum_'. $file->getClientOriginalExtension();
                $file->move($fileuploadpath, $memofileName); 
            } 

            BusinessKyc::create([
                'user_id'=>$user->id,
                'business_name' => $request->bname,
                'business_type'=> $request->btype,
                'business_certificate'=> $bcfileName,
                'business_memorandum'=>$memofileName,
                'fname'=>$request->fname,   
                'mname'=> $request->mname,
                'lname'=>$request->lname,
                'dob'=> $request->dob,
                'passport_no'=> $request->passno,
                'passport_country'=> $request->passcountry,
                'passport_expdate'=> $request->passexpdt,
                'passport'=>$passfileName,
                'add_line_one'=> $request->addlone,
                'add_line_two'=> $request->addltwo,
                'town_or_city'=> $request->towncity,
                'zip'=> $request->zip,
                'state'=> $request->state,
                'country'=> $request->country,
                'address_proof'=>$paddfileName,
                'currency' => $request->currency,
                'photo'=>$request->uploadphoto,
            ]);
            
            Business::where('user_id',$user->id)->update(['kyc' => 1]);   
//            $unrdata = UnRegisterEmail::where('email',$user->email)->get();
//            foreach($unrdata as $data){
//                if($data->cname == 'user_id' && $data->table == 'RequestForMoneyToUser'){                    
//                    RequestForMoneyToUser:: where('id',$data->row_id)->update([$data->cname => $user->id]);
//                    UnRegisterEmail::where('id',$data->id)->delete();
//                }elseif(($data->cname == 'name' || $data->cname == 'user_id') && $data->table == 'Activity'){
//                    if($data->cname == 'name'){
//                        $cvalue = $request->fname;
//                    }elseif($data->cname == 'user_id'){
//                        $cvalue = $user->id;
//                    }                    
//                    Activity:: where('id',$data->row_id)->update([$data->cname => $cvalue]);
//                    UnRegisterEmail::where('id',$data->id)->delete();
//                }
//            }
            VerifyUser::create([
                'user_id' => $user->id,
                'token' => $request->_token,
            ]);
        }catch(QueryException $qe){
             if($qe->getCode()){
                $errormes = 'Database Error';
                session()->flash('status',$errormes);
            };            
        }catch(Exception $e){
            if($e->getCode()){
                $errormes = 'Server Error';
                session()->flash('status',$errormes);
            };         
        }finally {            
            if(empty($errormes)){
                Mail::to($user->email)->send(new BuKycMail($request->_token,$request->fname,$request->lname)); 
                if (Mail::failures()) {
                    $status = 'We can not sent you an activation code.';            
                }else{            
                    $status = 'We sent you an activation code. Check your email and click on the link to verify.';
                }     
                session()->flash('status',$status);
                Auth::logout();
                return response()->json(['status'=>200]);
            }else{
                Auth::logout();
                return response()->json(['status'=>200,'error'=>$errormes]);
            }
        }               
    }
    
    protected function verifyKYC($token){
        $verifyUser = VerifyUser::where('token', $token)->first();        
        if(isset($verifyUser) ){
            $userrole = $verifyUser->user->role;
            $userid = $verifyUser->user->id;            
            if($userrole == 2){
                $user = $verifyUser->business;
                $userkyc = $verifyUser->businesskyc;
                if(!$user->kyc_verify) {
                    $verifyUser->business->kyc_verify = 1;
                    $verifyUser->business->save();
                    $status = config('constants.KYCVerify');
                    // send Emial to admin
                        $admin = AdminLogin::find(1);                
                        $cryptedid = Crypt::encrypt($userid);
                        Mail::to($admin->email)->send(new AdminVerifyMail($cryptedid,$userkyc->fname,$userkyc->lname));
                        
                    //Notification Send to Admin.
                        $notifydata = [            
                            'action'=>'Approval',
                            'process'=>1,
                            'type' => 'BusinessAccountApproval',
                            'tab' => 2,
                        ];        
                        $admin->notify(new BusinessApproval($notifydata));
        
        
                    VerifyUser::where('token', $token)->delete();
                }else{
                    $status = "Your Kyc already verified.";
                }
            }else{
                $user = $verifyUser->individual;
                $userkyc = $verifyUser->individualkyc;
                if(!$user->kyc_verify) {
                    $verifyUser->individual->kyc_verify = 1;
                    $verifyUser->individual->save();
                    $status = "Your Kyc verified.";
                    // send Emial to admin
                        $admin = AdminLogin::find(1);                
                        $cryptedid = Crypt::encrypt($userid);
                        Mail::to($admin->email)->send(new AdminVerifyMail($cryptedid,$userkyc->fname,$userkyc->lname));
                    
                    //Notification Send to Admin.
                        $notifydata = [            
                            'action'=>'Approval',
                            'process'=>1,
                            'type' => 'IndividualAccountApproval',
                            'tab' => 2, 
                        ];        
                        $admin->notify(new IndividualApproval($notifydata));
                    VerifyUser::where('token', $token)->delete();
                }else{
                    $status = "Your Kyc already verified.";
                }
            }
            session()->flash('status', $status);
        }else{
            session()->flash('warning', 'Sorry your KYC not verified.');
        }        
        return redirect('/login');
    }
}
