<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\BusinessInformations;
use App\InvoiceCategory;

class BusinessInformationDetailsController extends Controller {

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
        
        if (isset($request->category_id)) {
            $this->validate($request, [
//                'business_logo' => 'required',
                'category_id' => 'required',
                'business_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'first_name' => 'required|alpha',
                'last_name' => 'alpha',
                'address' => 'required',                
                'phone' => 'required|max:10',
                'email_id' => 'required|email|emailformate|string',
                'website' => 'required', 
                'tax_id' => 'required|integer', 
                    ], [
//                'business_logo.required' => 'Logo Required',      
                'category_id.required' => 'Category Required',
                'business_name.regex' => 'only allows letters, hyphens and spaces',
                'business_name.required' => 'Business Name Required',
                'first_name.alpha' => 'Only Alphabate allow',
                'first_name.required' => 'First Name Required', 
                'last_name.alpha' => 'Only Alphabate allow',
                'address.required' => 'Address Required',    
                'phone.required' => 'Phone Number Required',
                'phone.max' => 'Phone Number Should be 10 digits', 
                'email_id.required' => 'Email Required',    
                'email_id.email' => 'Please Enter Valid Email',
                'website.required' => 'Website Required',
                'tax_id.required' => 'Tax Id Required',
                'tax_id.integer' => 'Tax Id Number Only',       
            ]);
            
            if ($request->hasFile('business_logo')) {                 
                $file = $request->file('business_logo');                
                $business_logofileName = $user->id.'business_logo'.time().'.'. $file->getClientOriginalExtension();
                $fileuploadpath = public_path().'/images/'.$user->id;
                $file->move($fileuploadpath, $business_logofileName); 
            }else{
                $business_logofileName = '';
            } 
            
            BusinessInformations::create([
                'user_id' => $user->id,
                'business_logo'=>$business_logofileName,       
                'category_id' => $request->category_id,
                'business_name' => $request->business_name,                
                'first_name' => $request->first_name,        
                'last_name' => $request->last_name,
                'address' => $request->address,
                'phone' => $request->phone,                
                'fax' => $request->fax,        
                'email_id' => $request->email_id,
                'website' => $request->website,
                'tax_id' => $request->tax_id,
                'additional_info' => $request->additional_info,
            ]);
           $mes = 'Business Information Added Successfully';
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
                throw new Exception(config('constants.DecryptionError'));
            }
        } catch (DecryptException $e) {
            $errormes = config('constants.DecryptException');
        } catch (QueryException $qe) {
            $errormes = config('constants.QueryException');
        } catch (Exception $ee) {
            $errormes = config('constants.Exception');
        } finally {
            if (empty($errormes)) {  
                $allCategory = InvoiceCategory::where('status',0)->get(); 
                $selected_id_value = BusinessInformations::where('user_id', '=', $user->id)->where('status',0)->orderBy('business_informations.category_id', 'ASC')->limit(1)->get();              
                return view('pages.business.business-information',['user_id'=>$id,'selected_id_value'=>$selected_id_value,'allCategory'=>$allCategory]);  
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
        $user = Auth::user(); 
        $mes = 'No record added';
        
            $this->validate($request, [
//                'business_logo' => 'required',
                'category_id' => 'required',
                'business_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'first_name' => 'required|alpha',
                'last_name' => 'alpha',
                'address' => 'required',                
                'phone' => 'required|max:10',
                'email_id' => 'required|email|emailformate|string',
                'website' => 'required',
                'tax_id' => 'required|integer', 
                    ], [
//                'business_logo.required' => 'Logo Required',
                'category_id.required' => 'Category Required',
                'business_name.regex' => 'only allows letters, hyphens and spaces',
                'business_name.required' => 'Business Name Required',
                'first_name.alpha' => 'Only Alphabate allow',
                'first_name.required' => 'First Name Required', 
                'last_name.alpha' => 'Only Alphabate allow',
                'address.required' => 'Address Required',    
                'phone.required' => 'Phone Number Required',
                'phone.max' => 'Phone Number Should be 10 digits', 
                'email_id.required' => 'Email Required',    
                'email_id.email' => 'Please Enter Valid Email',
                'website.required' => 'Website Required',
                'tax_id.required' => 'Tax Id Required',
                'tax_id.integer' => 'Tax Id Number Only',   
            ]);
            
            if ($request->hasFile('business_logo')) {                 
                $file = $request->file('business_logo');                
                $business_logofileName = $user->id.'business_logo'.time().'.'. $file->getClientOriginalExtension();
                $fileuploadpath = public_path().'/images/'.$user->id;
                $file->move($fileuploadpath, $business_logofileName); 
            }  
            
            
            $busiInfoupdated = BusinessInformations::find($request->id); 
            if ($request->hasFile('business_logo')) {
                $busiInfoupdated->business_logo = $business_logofileName;
            }
            $busiInfoupdated->category_id = $request->category_id;
            $busiInfoupdated->business_name = $request->business_name;
            $busiInfoupdated->first_name = $request->first_name;
            $busiInfoupdated->last_name = $request->last_name;
            $busiInfoupdated->address = $request->address;
            $busiInfoupdated->phone = $request->phone;
            $busiInfoupdated->fax = $request->fax;
            $busiInfoupdated->email_id = $request->email_id;
            $busiInfoupdated->website = $request->website;
            $busiInfoupdated->tax_id = $request->tax_id;
            $busiInfoupdated->additional_info = $request->additional_info;
            $busiInfoupdated->save();            
            $mes = 'Business Information Updated Successfully.';
            
            if(!empty($mes)){
                session()->flash('status',$mes);
                return redirect()->back();
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Auth::logout();
        return redirect('/login');
    }
    
    public function GetSingleBusinessInfo(Request $request){
       $user = Auth::user();
       $selected_id = $request->selected_id;
    
        $singleBusinessInfoDetailsArr = BusinessInformations::where('category_id',$selected_id)->where('user_id', '=', $user->id)->where('status',0)->orderBy('business_informations.category_id', 'ASC')->first(); 
        $singleBusinessInfoDetails = [];
        if(!empty($singleBusinessInfoDetailsArr)){            
            foreach($singleBusinessInfoDetailsArr->toArray() as $key => $value){
                try {
                    $singleBusinessInfoDetails[$key] = Crypt::decrypt($value);
                } catch (DecryptException $e) {
                    $singleBusinessInfoDetails[$key] = $value;
                }
            }
        }
        echo json_encode($singleBusinessInfoDetails);
    }
    

}
