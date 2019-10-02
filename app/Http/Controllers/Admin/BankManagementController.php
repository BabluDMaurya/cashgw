<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddBankRequest;
use App\BankDetails;
use App\Currencie;
class BankManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }
    
    public function index()
    {
        $bankaccs = BankDetails::get();
        $currency = Currencie::get();        
//        dd($currency);
        
        return view('pages.admin.bank', ['bankaccs'=>$bankaccs,'currency'=>$currency]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currency = Currencie::get();     
        return view('pages.admin.addbankaccount',['currency'=>$currency]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddBankRequest $request)
    {
        BankDetails::create([
            'bank' => $request->bank, 
            'bankcode'=> $request->bankcode,
            'ifsc'=> $request->ifsccode, 
            'branch'=> $request->branch, 
            'currency'=> $request->currency, 
            'acno'=> $request->acno, 
            'name'=> $request->name, 
            'address'=> $request->bankaddress, 
        ]); 
         session()->flash('status',config('constants.AddBankA/CSuccess'));
         return redirect('/bank');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankdetails = BankDetails::where('id',$id)->first();        
        return view('pages.admin.bankdetails', ['details'=>$bankdetails]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bankdetails = BankDetails::where('id',$id)->first();
        return view('pages.admin.addbankaccount', ['details'=>$bankdetails]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddBankRequest $request, $id)
    {
        BankDetails::where('id',$id)->update([
            'bank' => $request->bank, 
            'bankcode'=> $request->bankcode,
            'ifsc'=> $request->ifsccode, 
            'branch'=> $request->branch, 
            'currency'=> $request->currency, 
            'acno'=> $request->acno, 
            'name'=> $request->name, 
            'address'=> $request->bankaddress, 
            ]);
        session()->flash('status',config('constants.EditBankA/CSuccess'));
        return redirect('/bank');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BankDetails::where('id',$id)->delete();
        session()->flash('status',config('constants.DelBankA/CSuccess'));
        return redirect('/bank');
    }
}
