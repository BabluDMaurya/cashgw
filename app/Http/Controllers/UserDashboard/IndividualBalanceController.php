<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\Traits\BalanceTrait;
use App\Traits\CurrencyConverter;
use Validator;
use App\CurrencyConvertionTransaction;
use App\Traits\TransactionIdTrait;
use App\Currencie;
class IndividualBalanceController extends Controller
{
    use BalanceTrait,CurrencyConverter,TransactionIdTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $bal = array();
            $mybals = $this->getBalance();
            if(count($mybals) > 0){
                if(count($mybals) > 1){
                    foreach($mybals as $mybal){                
                        if($mybal['currency_requested'] == 2){
                            $bal['EUR'] = $mybal['balance'];
                        }else{
                            $bal['USD'] = $mybal['balance'];
                        }                
                    }
                }else{
                    foreach($mybals as $mybal){                
                        if($mybal['currency_requested'] == 2){
                            $bal['EUR'] = $mybal['balance'];
                            $bal['USD'] = 0.00;
                        }else{
                            $bal['USD'] = $mybal['balance'];
                            $bal['EUR'] = 0.00;
                        }                
                    }          
                }
            }else{
                $bal['EUR'] = 0.00;
                $bal['USD'] = 0.00;
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
                return view('pages.user.balance',['user_id'=>$id,'individual'=>$user->individual,'individualkyc'=>$user->individualkyc,'balance'=>$bal]);  
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
        try{            
            $user = Auth::user(); 
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception("User not login");
    }
            $currencydata = Currencie::where('code',$request->input('currencytype'))->first();              
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
                return view('pages.user.currency-convert',['user_id'=>$id,'balance'=>$this->getCurrencyBalance($currencydata->id),'currency'=>$request->input('currencytype')]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
                return redirect('/login');
            }       
        }
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
            $mes = 'Currency not Converted.';
            if(!empty($request->balance) && ($decrypted == $user->id)){
                $request->ttype = 3;
                return $result = $this->currencyConvert($request); 
            }

            if(!empty($request->convertcurrency == 'Convert') && ($decrypted == $user->id)){
                
                $validator = Validator::make($request->all(),[
                'amount' => 'required',
                ],[
                'amount.required' => 'amount Required',
                ]);
                 if($validator->fails()){
                    return redirect()->back()->withErrors($validator);
                }
                $fcurrencydata = Currencie::where('code',$request->from_currency)->first();
                $tcurrencydata = Currencie::where('code',$request->to_currency)->first();
//                $totalamount = ($request->amount+$request->canvertion_charge+$request->cashgw_charge);
                $totalamount = ($request->amount+$request->canvertion_charge);
                $tId = $this->createCCID();
                $userbal = $this->updateBalanceAfterCurrencyConvert($request->convertedAmount,$totalamount,$fcurrencydata->id,$tcurrencydata->id,$request->canvertion_charge,$tId);                
                if($userbal['status'] == 'success'){                   
                CurrencyConvertionTransaction::create([
                    'transactionId' => $tId,
                    'user_id' => $user->id,
                    'fromCurrency' => $request->from_currency,
                    'toCurrency' => $request->to_currency,
                    'rate' => $request->convertionRate,
                    'amount' => $request->amount,
                    'convertedAmount' => $request->convertedAmount,
                    'canvertionCharge' => $request->canvertion_charge,
//                    'cashgwCharge' => $request->cashgw_charge,
                ]);                
                   return $mes = [
                                'status'=>'success',
                                'remainbalance' => $userbal['fbalance'],
                           ];
                }else{                    
                    Auth::logout();   
                    session()->flash('status',$userbal);
                    return redirect('/login');
                }
            }                   
        }else{
            Auth::logout();   
            session()->flash('status','Logout');
            return redirect('/login');
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
