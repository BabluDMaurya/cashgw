<?php
namespace App\Http\Controllers\Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
use App\Http\Controllers\Controller;
class SignupController extends Controller
{
    public function index(){
        return view('pages.sign-up');
    }
     public function formsubmit( SignupRequest $request) {
         if($request->radio == 'busi'){                 
             Session::put('cgwregisteruseraccounttype', '2');
//             return redirect('/sign-up-business');
         }else{
             Session::put('cgwregisteruseraccounttype', '1');
//             return redirect(route('register'));
         }
         return redirect(route('register'));
    }
}
