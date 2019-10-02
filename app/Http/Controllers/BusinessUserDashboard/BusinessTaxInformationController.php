<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\TaxInformations;

class BusinessTaxInformationController extends Controller
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
        $user = Auth::user();  
        $mes = 'No record added';
        
        if (isset($request->firstTd)) {
            $this->validate($request, [
                'firstTd' => 'required|alpha',
                'secondTd' => 'required|integer',
                    ], [
                'firstTd.required' => 'Tax Name Required',
                'firstTd.alpha' => 'Tax Name allow alphabets only',
                'secondTd.required' => 'Tax Rate Required', 
                'secondTd.integer' => 'Tax Rate allow numbers only',     
            ]);
            
            $taxinfo = TaxInformations::create([
                'user_id' => $user->id,
                'tax_name' => $request->firstTd,
                'tax_rate' => $request->secondTd,                                  
            ]);            
            
            $lastId = $taxinfo->id;
            
            return json_encode(array("status"=>"success","message"=>"Successfully Added","lastInsertedId"=>$lastId));
            
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
                $taxInfoList = TaxInformations::where('user_id',$user->id)->where('status',0)->get();
                return view('pages.business.tax-information',['user_id'=>$id,'taxInfoList'=>$taxInfoList]);  
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
        if (isset($request->firstTd)) {
            $this->validate($request, [
                'firstTd' => 'required|alpha',
                'secondTd' => 'required|integer',
                    ], [
                'firstTd.required' => 'Tax Name Required',
                'firstTd.alpha' => 'Tax Name allow alphabets only',
                'secondTd.required' => 'Tax Rate Required', 
                'secondTd.integer' => 'Tax Rate allow numbers only',     
            ]);
            $taxInfoupdated = TaxInformations::find($request->id);             
            $taxInfoupdated->tax_name = $request->firstTd;
            $taxInfoupdated->tax_rate = $request->secondTd;            
            $taxInfoupdated->save();
            
            return json_encode(array("status"=>"success","message"=>"Successfully Updated"));
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
        Auth::logout();
        return redirect('/login');
    }
    
    public function DeleteTaxInfo(Request $request){
        $id = $request->id;
        $deleteupdated = TaxInformations::find($id);   
        $deleteupdated->status = 1;
        $deleteupdated->save();        
    }
}
