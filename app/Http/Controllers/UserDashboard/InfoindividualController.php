<?php
namespace App\Http\Controllers\UserDashboard;
use Illuminate\Http\Request;
use App\Mail\IndividualKycMail;
use App\Mail\AdminVerifyMail;
use Mail;
use App\Http\Requests\InfoIndividualRequest;
use App\Individual;
use App\IndividualKyc;
use Auth;
use App\VerifyUser;
use File;
use App\AdminLogin;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Illuminate\Notifications\Notifiable;
use App\Notifications\BusinessApproval;
use App\Notifications\IndividualApproval;
use App\Activity;
use App\UnRegisterEmail;
use App\RequestForMoneyToUser;
class InfoindividualController extends Controller
{
    use Notifiable;
    public function index(){        
        $user = Auth::user();
        $user_id =$user->id; 
        return view('pages.user.info-individual',['user_id'=>$user_id]);
    }
    
    public function KYCAddProfilePic(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'myphoto' => 'required',
                ], [
            'myphoto.required' => 'Image Required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }        
        $path = public_path() . '/images/' . $user->id;        
        if (!is_dir($path)) {
                mkdir($path);
                chmod($path, 0777);
        }        
        $image = base64_decode($request->myphoto);
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $image_name = $user->id . '_PhotoFile.png';
        $path = public_path() . '/images/' . $user->id . '/' . $image_name;
        file_put_contents($path, $image);
        echo $image_name;
    }
    
    public function KycFormSubmit(InfoIndividualRequest $request){ 
        $user = Auth::user();    
        $fileName = null;
        $passfileName = null;
        $paddfileName = null;
        $errormes = '';   
                
        try{
            $fileuploadpath = public_path().'/images/'.$user->id;
            File::isDirectory($fileuploadpath) or File::makeDirectory($fileuploadpath, 0777, true, true);            
            if (request()->hasFile('passfile')) {                 
                $file = $request->file('passfile');                
                $passfileName = $user->id.'_passfile.'. $file->getClientOriginalExtension();
                $file->move($fileuploadpath, $passfileName); 
            }
            if (request()->hasFile('proofaddress')) {                 
                $file = $request->file('proofaddress');                
                $paddfileName = $user->id.'_proofaddress.'. $file->getClientOriginalExtension();
                $file->move($fileuploadpath, $paddfileName); 
            }
            IndividualKyc::create([
                'user_id'=>$user->id,                
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
                'photo'=> $request->uploadphoto,
            ]);
    
            Individual::where('user_id',$user->id)->update(['kyc' => 1]); 

//            $unrdata = UnRegisterEmail::where('email',$user->email)->get();
//            foreach($unrdata as $data){
//                if($data->cname == 'user_id' && $data->table == 'RequestForMoneyToUser'){                    
//                    RequestForMoneyToUser:: where('id',$data->row_id)->update([$data->cname => $user->id]);
////                    UnRegisterEmail::where('id',$data->id)->delete();
//                }elseif(($data->cname == 'name' || $data->cname == 'user_id') && $data->table == 'Activity'){
//                    if($data->cname == 'name'){
//                        $cvalue = $request->fname;
//                    }elseif($data->cname == 'user_id'){
//                        $cvalue = $user->id;
//                    }                    
//                    Activity:: where('id',$data->row_id)->update([$data->cname => $cvalue]);
////                    UnRegisterEmail::where('id',$data->id)->delete();
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
                $admin = AdminLogin::find(1);                
                $cryptedid = Crypt::encrypt($user->id);                
                Mail::to($user->email)->send(new IndividualKycMail($request->_token,$request->fname,$request->lname)); 
                if (Mail::failures()) {
                    $status = 'We can not send you an activation code.';            
                }else{            
                    $status = 'We sent you an activation code. Check your email and click on the link to verify.';
                }  
                Mail::to($admin->email)->send(new AdminVerifyMail($cryptedid,$request->fname,$request->lname));
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
                    $status = "Your KYC e-mail is verified.";
                    // send Emial to admin
                        $admin = AdminLogin::find(1);                
                        $cryptedid = Crypt::encrypt($userid);
                        Mail::to($admin->email)->send(new AdminVerifyMail($cryptedid,$userkyc->fname,$userkyc->lname));
                    //
                    //Notification Send to Admin.
                        $notifydata = [            
                            'action'=>'Approval',
                            'process'=>1,
                            'type' => 'BusinessAccountApproval',
                            'tab' => 1,
                        ];        
                        $admin->notify(new BusinessApproval($notifydata));    
                    VerifyUser::where('token', $token)->delete();
                }else{
                    $status = "Your KYC e-mail is already verified.";
                }
            }else{
                $user = $verifyUser->individual;
                $userkyc = $verifyUser->individualkyc;
                if(!$user->kyc_verify) {
                    $verifyUser->individual->kyc_verify = 1;
                    $verifyUser->individual->save();
                    $status = "Your KYC e-mail is verified.";
                    // send Emial to admin
                        $admin = AdminLogin::find(1);                
                        $cryptedid = Crypt::encrypt($userid);
                        Mail::to($admin->email)->send(new AdminVerifyMail($cryptedid,$userkyc->fname,$userkyc->lname));
                    
                        //Notification Send to Admin.
                        $notifydata = [            
                            'action'=>'Approval',
                            'process'=>1,
                            'type' => 'IndividualAccountApproval',
                            'tab'=> 1,
                        ];        
                        $admin->notify(new IndividualApproval($notifydata));
                    VerifyUser::where('token', $token)->delete();
                }else{
                    $status = "Your KYC e-mail is already verified.";
                }
            }
            session()->flash('status', $status);
        }else{
            session()->flash('warning', 'Sorry your KYC not verified.');
        }        
        return redirect('/login');
    }
}
