<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
class AcivityDetailsController extends Controller
{
    public function index($id){   
        $id = Crypt::decrypt($id);        
       $user = Auth::user() ;
       $activity = Activity::where('id',$id)->first();         
//       dd($activity);
       return view('pages.business.activity-details',['user_id'=>Crypt::encrypt($user->id),'activity'=>$activity]);       
    }
}
