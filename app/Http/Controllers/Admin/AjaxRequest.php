<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DefaultTransactionCharge;
use Response;
use App\User;
use App\SetTransactionCharge;
use App\SetPercentTransactionCharge;
use App\SetFlatTransactionCharge;
use Illuminate\Support\Facades\Crypt;

class AjaxRequest extends Controller {

    public function fees(Request $request) {
        if ($request->selectedoption != 3) {
            $defaultTCharge = DefaultTransactionCharge::where('charge_type', $request->selectedoption)->select('charge', 'transaction_type')->get();
            $output = '';
            foreach ($defaultTCharge as $value) {
                if ($value->transaction_type == 1) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Request Fees: ' . $value->charge . '%</label>';
                    $output .= '</div>';
                }
                if ($value->transaction_type == 2) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Invoice Fees: ' . $value->charge . '%</label>';
                    $output .= '</div>';
                }
                if ($value->transaction_type == 3) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Currency Converter Fees: ' . $value->charge . '%</label>';
                    $output .= '</div> ';
                }
            }
            return $output;
        } else if ($request->selectedoption == 3) {
            $output = '';

            $output .= '<div class="form-group">';
            $output .= '<select class="form-control" name= "setcharge">';
            $output .= '<option value="1">Percent</option>';
            $output .= '<option value="2">Flat</option>';
            $output .= '</select>';
            $output .= '</div>';

            $output .= '<div class="form-group">';
            $output .= '<label class="col-form-label">Request Fees: '
                    . '<input class="form-control" name="requestfees" type="text"/>'
                    . '</label>';
            $output .= '</div>';

            $output .= '<div class="form-group">';
            $output .= '<label class="col-form-label">Invoice Fees: '
                    . '<input class="form-control" name="invoicefees" type="text"/>'
                    . '</label>';
            $output .= '</div>';

            $output .= '<div class="form-group">';
            $output .= '<label class="col-form-label">Currency Converter Fees: '
                    . '<input class="form-control" name="currencyconverterfees" type="text"/>'
                    . '</label>';
            $output .= '</div>';

            return $output;
        }
    }

    public function feesedit(Request $request) {

        $user = User::where('id', decrypt($request->editfeesid))->first();

        $output = '';
        if ($user->fees != 3) {

            $defaultTCharge = DefaultTransactionCharge::where('charge_type', $user->fees)->select('charge', 'transaction_type')->get();

            $output .= '<select class="form-control" name="selcharge">';
            $output .= '<option value="1" ';
            if ($user->fees == 1) {
                $output .= 'selected';
            }
            $output .= '>% Default</option>';
            $output .= '<option value="2" ';
            if ($user->fees == 2) {
                $output .= 'selected';
            }
            $output .= '>Flat Default</option>';
            $output .= '<option value="3" ';
            if ($user->fees == 3) {
                $output .= 'selected';
            }
            $output .= '>Set</option>';
            $output .= '</select>';

            $output .= '<div id="charge">';
            foreach ($defaultTCharge as $value) {
                if ($value->transaction_type == 1) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Request Fees: ' . $value->charge . '%</label>';
                    $output .= '</div>';
                }
                if ($value->transaction_type == 2) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Invoice Fees: ' . $value->charge . '%</label>';
                    $output .= '</div>';
                }
                if ($value->transaction_type == 3) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Currency Converter Fees: ' . $value->charge . '%</label>';
                    $output .= '</div> ';
                }
            }
            $output .= '</div> ';
        } else if ($user->fees == 3) {
            $data = SetTransactionCharge::where('user_id', decrypt($request->editfeesid))->first();
            if ($data->charge_type == 1) {
                $fees = SetPercentTransactionCharge::where('user_id', decrypt($request->editfeesid))->get();
            } else if ($data->charge_type == 2) {
                $fees = SetFlatTransactionCharge::where('user_id', decrypt($request->editfeesid))->get();
            }
            $output .= '<select class="form-control" name="selcharge">';
            $output .= '<option value="1" ';
            if ($user->fees == 1) {
                $output .= 'selected';
            }
            $output .= '>% Default</option>';
            $output .= '<option value="2" ';
            if ($user->fees == 2) {
                $output .= 'selected';
            }
            $output .= '>Flat Default</option>';
            $output .= '<option value="3" ';
            if ($user->fees == 3) {
                $output .= 'selected';
            }
            $output .= '>Set</option>';
            $output .= '</select>';

            $output .= '<div id="charge">';
            $output .= '<div class="form-group">';
            $output .= '<select class="form-control" name= "setcharge">';
            $output .= '<option value="1"';
            if ($data->charge_type == 1) {
                $output .= 'selected';
            }
            $output .= '>Percent</option>';
            $output .= '<option value="2"';
            if ($data->charge_type == 2) {
                $output .= 'selected';
            }
            $output .= '>Flat</option>';
            $output .= '</select>';
            $output .= '</div>';

            foreach ($fees as $value) {
                if ($value->transaction_type == 1) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Request Fees: '
                            . '<input class="form-control" name="requestfees" type="number" value="' . $value->charge . '"/>'
                            . '</label>';
                    $output .= '</div>';
                }
                if ($value->transaction_type == 2) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Invoice Fees: '
                            . '<input class="form-control" name="invoicefees" type="number" value="' . $value->charge . '"/>'
                            . '</label>';
                    $output .= '</div>';
                }
                if ($value->transaction_type == 3) {
                    $output .= '<div class="form-group">';
                    $output .= '<label class="col-form-label">Currency Converter Fees: '
                            . '<input class="form-control" name="currencyconverterfees" type="number" value="' . $value->charge . '"/>'
                            . '</label>';
                    $output .= '</div>';
                }
            }

            $output .= '</div>';
        }
        return $output;
    }
    public function feeEdit(Request $request){
        $user_id = decrypt($request->id);        
        $status = $request->status_val;  
        $selcharge = $request->selcharge;

        $users = User::where('id', $user_id)->first();
        $users->fees = $selcharge;
        $users->save();          
        
        if($status == 3 && $selcharge == 3){
                SetTransactionCharge::where('user_id',$user_id)->delete();
             if($request->setcharge == 1){  
                SetPercentTransactionCharge::where('user_id',$user_id)->delete();
             }else if($request->setcharge == 2){  
                SetFlatTransactionCharge::where('user_id',$user_id)->delete();
             }
         }
         
        if($selcharge == 3){
//            $this->validate([
//                'requestfees' => 'required|numeric',
//                'invoicefees' => 'required|numeric',
//                'currencyconverterfees' => 'required|numeric',
//            ],[
//                'requestfees.required' => 'Request fees Required',
//                'requestfees.numeric' => 'Enter Number for Request fees',
//                'invoicefees.required' => 'Invoice fees Required',
//                'invoicefees.numeric' => 'Enter Number for Invoice fees',
//                'currencyconverterfees.required' => 'Currency Converter fees Required',
//                'currencyconverterfees.numeric' => 'Enter Number for Currency Converter fees',
//            ]);
            
            SetTransactionCharge::create([
               'user_id'=> $user_id,
                'charge_type'=> $request->setcharge,
            ]);            
            $chargearray = [$request->requestfees,$request->invoicefees,$request->currencyconverterfees];
            // [request money, invoice , currency conversion]
            $i = 1;
           if($request->setcharge == 1){               
               foreach($chargearray as $value){
                    SetPercentTransactionCharge::create([
                        'user_id'=> $user_id,
                        'charge'=>$value,
                        'transaction_type'=>$i,
                    ]);
                $i++;    
               }
           }else{
               foreach($chargearray as $value){
                    SetFlatTransactionCharge::create([
                        'user_id'=> $user_id,
                        'charge'=>$value,
                        'transaction_type'=>$i,
                    ]);
                $i++;    
               }
           }
        }    
        
        session()->flash('status',config('constants.UserApproved'));
        return redirect()->back();
        
    }
}
