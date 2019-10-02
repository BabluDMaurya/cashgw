<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
class AcivityDetailsController extends Controller
{
    public function index($id){       
        $id = Crypt::decrypt($id);
       $user = Auth::user() ;
       $activity = Activity::where('id',$id)->first();        
       return view('pages.user.activity-details',['user_id'=>Crypt::encrypt($user->id),'activity'=>$activity]);       
    }
}
