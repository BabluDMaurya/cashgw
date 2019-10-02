<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CreateInvoice;
use App\InvoiceItemsList;
use App\TaxInformations;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Traits\CalculateBalanceAfterChargeTrait;
class InvoiceDetailsController extends Controller
{
    use CalculateBalanceAfterChargeTrait;
   public function index($id){ 
       $user = Auth::user();
       $decryptid = Crypt::decrypt($id);       
       $invoicedata = CreateInvoice::where('id',$decryptid)->first(); 
       $invoiceitem = InvoiceItemsList::where('create_invoice_id',$decryptid)->get(); 
       $items = array();
       foreach($invoiceitem as $item){
          if( $item->item_tax_id > 0){
              $itemtaxs = TaxInformations::where('id',$item->item_tax_id)->first();
              $itemtax = $itemtaxs->tax_rate;
          }else{
              $itemtax = 0;
          }
          $items[] = [
                'itemdesc' => $item->item_desc,
                'itemquantity' => $item->item_quantity,
                'itemprice' => $item->item_price,                
                'itemtax' => $itemtax,
           ];
       }
       $charge = $this->transactionCharges(1);
       $calresult = $this->calculateBalanceAfterCharge($invoicedata->invoice_grand_total,$charge);       
       return view('pages.business.invoice-details',['user_id'=>Crypt::encrypt($user->id),'invoice'=>$invoicedata,'invoiceitem'=>$items,'calresult'=>$calresult,'invoiceId'=>$id]);       
    }
}
