<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Activity;
use PDF;
use Carbon\Carbon;
class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
         try{            
            $user = Auth::user(); 
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception("User not login");
            } 
            $sendmoney = Activity::where('user_id',$user->id)->where('type',1)->orderBy('updated_at', 'DESC')->get();
            $requestmoney = Activity::where('user_id',$user->id)->where('type',2)->orderBy('updated_at', 'DESC')->get();
            $sentmoney = Activity::where('user_id',$user->id)->where('type',3)->orderBy('updated_at', 'DESC')->get();
//            $currencyconverter = Activity::where('user_id',$user->id)->where('type',4)->orderBy('updated_at', 'DESC')->limit(20)->get();
            $sentinvoice = Activity::where('user_id',$user->id)->where('type',5)->where('showdate', '<=', Carbon::now()->toDateString())->orderBy('updated_at', 'DESC')->get();
            $paidinvoice = Activity::where('user_id',$user->id)->whereIn('type', array(7))->where('showdate', '<=', Carbon::now()->toDateString())->orderBy('updated_at', 'DESC')->get();
            
            $receivedinvoice = Activity::where('user_id',$user->id)->whereIn('type', array(6))->where('showdate', '<=', Carbon::now()->toDateString())->orderBy('updated_at', 'DESC')->get();
            $processedinvoice = Activity::where('user_id',$user->id)->whereIn('type', array(8))->where('showdate', '<=', Carbon::now()->toDateString())->orderBy('updated_at', 'DESC')->get();
            
            $Admin = Activity::where('user_id',$user->id)->whereIn('type', array(11,12,13,14))->orderBy('updated_at', 'DESC')->get();
            
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
//            return view('pages.business.total-activity',['user_id'=>$id,'activites'=>$myactivites]);
                return view('pages.business.total-activity',[
                    'user_id'=>$id,
                    'role'=>$user->role,                    
                    'requestmoney'=>$requestmoney,
                    'sendmoney'=>$sendmoney,
                    'sentmoney'=>$sentmoney,
                    'sentinvoice'=>$sentinvoice,
                    'paidinvoice'=>$paidinvoice,                    
                    'receivedinvoice'=>$receivedinvoice,
                    'processedinvoice'=>$processedinvoice,                    
                    'admin'=>$Admin,
                ]);
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
    public function edit(Request $request,$id)
    {
        if(($request->seloption == 1) && ($request->stran != '')){
            $email = "email = '".$request->stran."'";  
        }else{
            $email = "1 = 1";
        }
        
        if(($request->seloption == 2) && ($request->stran != '')){
            $transaction = "transactionid = '".$request->stran."'";
        }else{
            $transaction = "1 = 1";
        }
        
        if(($request->seloption == 3) && ($request->stran != '')){
            $name = "name = '".$request->stran."'";
        }else{
            $name = "1 = 1";
        }
        
        if($request->seldate !=''){
            $date = "updated_at = '".date('Y-m-d',strtotime($request->seldate))."'";  
        }else{
            $date = "1 = 1";
        }
        
        if(($request->currency !='') && ($request->currency != 0)){
            $currency = "currency = " .$request->currency;
        }else{
            $currency = "1 = 1";
        }

        if(($request->type !='') && ($request->type !=0)){
            $type = "type = ".$request->type;
        }else{
            $type = "1 = 1";
        }
        
        if($request->type == 5 || $request->type == 6 || $request->type == 7 || $request->type == 8){
            $page = 'invoice';
        }else{
            $page = 'activity';
        }

        if(($request->action !='') && ($request->action != 0)){
            $action = "action = ".$request->action;
        }else{
            $action = "1 = 1";
        }
        
        if(($request->archieve !='') && ($request->archieve != 0)){
            $archieve = "archieve = ".$request->archieve;
        }else{
            $archieve = "1 = 1";
        }        
        $myactivites = Activity::whereRaw($date)                
                ->whereRaw($email)
                ->whereRaw($transaction)
                ->whereRaw($name)                  
                ->whereRaw($currency)
                ->whereRaw($type)
                ->whereRaw($action)
                ->whereRaw($archieve)
                ->where('user_id',Crypt::decrypt($id))
                ->orderBy('id', 'DESC')
                ->limit(30)
                ->get();        
        if($request->downloadpdf == 1){
            // Send data to the view using loadView function of PDF facade
            $pdf = PDF::loadView('pages.pdf.total-activity-pdf',['user_id'=>$id,'activites'=>$myactivites]);
            // If you want to store the generated pdf to the server then you can use the store function
            $pdf->save(storage_path('pdf').'_activites.pdf');
            // Finally, you can download the file using download function
            return $pdf->setPaper('a4')->download('cashgw-activites.pdf');
        }
        return view('pages.business.total-activity-list',['user_id'=>$id,'content'=>$myactivites,'page'=>$page]);
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
        $activites = Activity::find($request->id);  
         $activites->archieve = $request->archieve;
         $activites->save();
         return 'updated';
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
