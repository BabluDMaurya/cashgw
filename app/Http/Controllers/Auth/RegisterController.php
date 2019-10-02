<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\VerifyUser;
use App\Business;
use App\Individual;
use App\Mail\VerifyMail;
use Mail;
use Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = array(
                    'email.unique' => '{'.$data['email'].'} email address already exists',
            );
        return Validator::make($data, [
            'email' => ['required','string','email','emailformate','uniqueemail','max:255','unique:users,email','emaildomain'],
            'password' => 'required|string|min:8|confirmed|passwordcheck',
            'agree' => 'required',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(Session::has('cgwregisteruseraccounttype')){           
                $user = User::create([
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),                
                    'role' => Session::get('cgwregisteruseraccounttype'),
                ]);            
            if($user->role == 2){
                Business::create([
                    'user_id' => $user->id,
                    'verify' => 0,
                    'kyc' => 0,
                    'kyc_verify' => 0,
                    'admin_verify' => 0,
                    'account_status' => 1,
                ]);
            }else{
                Individual::create([
                    'user_id' => $user->id,
                    'verify' => 0,
                    'kyc' => 0,
                    'kyc_verify' => 0,
                    'admin_verify' => 0,
                    'account_status' => 1,
                ]);
            }
            
            $verifyUser = VerifyUser::create([
                'user_id' => $user->id,
                'token' => $data['_token'],
            ]);
            
            Session::forget('cgwregisteruseraccounttype');
            return $user;
        }else{
           return redirect('sign-up'); 
        }
        
    }
    protected function register(Request $request){        
        $this->validator($request->all())->validate();        
        event(new Registered($user = $this->create($request->all()))); 
        Mail::to($user->email)->send(new VerifyMail($user));                
        if (Mail::failures()) {
            $request->session()->flash('status', 'We can not sent you an activation code.');            
        }else{
            $request->session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');
        }
        $this->guard()->logout();
        return redirect(route('login'));
    }
    protected function verify($token){
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $userrole = $verifyUser->user;
            if($userrole->role == 2){
                $user = $verifyUser->business;
                if(!$user->verify) {
                    $verifyUser->business->verify = 1;
                    $verifyUser->business->save();
                    $status = "Your e-mail is verified.";
                    VerifyUser::where('token', $token)->delete();
                }else{
                    $status = "Your e-mail is already verified.";
                }
            }else{
                $user = $verifyUser->individual;
                if(!$user->verify) {
                    $verifyUser->individual->verify = 1;
                    $verifyUser->individual->save();
                    $status = "Your e-mail is verified.";
                    VerifyUser::where('token', $token)->delete();
                    
                }else{
                    $status = "Your e-mail is already verified.";
                }
            }
            session()->flash('status', $status);
        }else{
            session()->flash('warning', 'Sorry your email cannot be identified.');
        }
        return redirect('/login');
    }
}
