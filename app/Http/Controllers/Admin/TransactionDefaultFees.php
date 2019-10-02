<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DefaultTransactionCharge;
class TransactionDefaultFees extends Controller
{
    
     public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fees = DefaultTransactionCharge::get();  
        return view('pages.admin.default-fees', ['fees'=>$fees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.default-fees-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'charge' => 'required|numeric', 
            'transaction_type' => 'required|numeric|digits_between:1,5',
            'charge_type' =>'required|numeric',
            ],[
            'charge.required' => 'Charge Required.',
            'charge.numeric' => 'Charge should be numneric.',    
            'charge.digits_between'=>'Charge should be between 1 to 5',    
            'transaction_type.required' => 'Transaction Type Required.',
            'charge_type.required' =>'Fees Type Required.',
            ]);
        DefaultTransactionCharge::create([
            'charge' => $request->charge, 
            'transaction_type' => $request->transaction_type,
            'charge_type' => $request->charge_type, 
        ]); 
         session()->flash('status',config('constants.AddFeesSuccess'));
         return redirect('/defaultfees');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bankdetails = DefaultTransactionCharge::where('id',$id)->first();
        return view('pages.admin.default-fees-create', ['details'=>$bankdetails]);
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
        $this->validate($request,[
            'charge' => 'required|numeric', 
            'transaction_type' => 'required|numeric|digits_between:1,5',
            'charge_type' =>'required|numeric',
            ],[
            'charge.required' => 'Charge Required.',
            'charge.numeric' => 'Charge should be numneric.',    
            'charge.digits_between'=>'Charge should be between 1 to 5',    
            'transaction_type.required' => 'Transaction Type Required.',
            'charge_type.required' =>'Fees Type Required.',
            ]);
        
        DefaultTransactionCharge::where('id',$id)->update([
            'charge' => $request->charge, 
            'transaction_type' => $request->transaction_type,
            'charge_type' => $request->charge_type, 
            ]);
        session()->flash('status',config('constants.EditFeesSuccess'));
        return redirect('/defaultfees');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DefaultTransactionCharge::where('id',$id)->delete();
        session()->flash('status',config('constants.DelFeesSuccess'));
        return redirect('/defaultfees');
    }
}
