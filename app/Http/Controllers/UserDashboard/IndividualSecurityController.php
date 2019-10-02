<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\User;
use Hash;
use Validator;
use Mail;   
use App\Mail\UserChangedPasswordNotificationToUser;

class IndividualSecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{            
            $user = Auth::user(); 
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception("User not login");
            }            

        }catch (DecryptException $e) {           
            $errormes = 'Decryption error';
        }
        catch(QueryException $qe){             
            $errormes = 'User table error';
        }
        catch(Exception $ee){           
            $errormes = 'Code error';
        }finally {          
            if(empty($errormes)){
                return view('pages.user.account-security',['user_id'=>$id]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
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
    public function edit($id)
    {
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
    public function update(Request $request, $id)
    {
         if(Auth::Check()){             
            $user = Auth::user(); 
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){
               Auth::logout();   
               session()->flash('status','Decryption error');
               return redirect('/login');
            } 
             
            $validator = Validator::make($request->all(),[
            'currentpassword' => 'required|currentpassword',            
            'newpassword' => 'required|string|min:8|same:newpassword|passwordcheck',
            'confirmpass' => 'required|same:newpassword',
            ],[
            'currentpassword.required' => 'Please enter current password',
            'newpassword.required' => 'Please enter password',
            'confirmpass.same' => 'Please enter the confirm password same as new password',    
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }
            $user = Auth::user();
            $user = User::find($user->id);
            $user->password = Hash::make($request->newpassword);
            $user->save();
            session()->flash('status',"Password Change Successfully.");
            Mail::to($user->email)->send(new UserChangedPasswordNotificationToUser());   
            return redirect()->back();  
            }else{
              return redirect()->to('/');
            }   
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
