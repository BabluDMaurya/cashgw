<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\CreateInvoice;
use App\InvoiceItemsList;
use App\IndividualKyc;
use App\Individual;
use App\AddressBook;
use App\InvoiceCategory;
use App\TaxInformations;
use DB;
use Mail;
use App\Mail\SendInvoiceMailToBillToAndCC;
use PDF;
use App\Currencie;
use App\BusinessInformations;
use Carbon\Carbon;
class IndividualManageInvoiceController extends Controller
{
    public function index($id){ 
        
         try{            
            $user = Auth::user(); 
            $decrypted = Crypt::decrypt($id);            
            if($user->id != $decrypted){               
                throw new Exception("User not login");
            }            
            $AllInvoice = CreateInvoice::where('user_id',$user->id)->where('archived_status',0)->get();
            //Mass update Notofication
            $user->unreadNotifications()
                    ->where('notifiable_type','App\User')
                    ->where('type','App\Notifications\Invoice')
//                    ->where('data["showdate"]','<=',Carbon::now()->toDateString())
                    ->update(['read_at' => now()]);
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
                return view('pages.user.invoice-manage',['user_id'=>$id,'AllInvoice'=>$AllInvoice]);  
            }else{
                Auth::logout();   
                session()->flash('status',$errormes);
                return redirect('/login');
            }       
        }
    }
    public function dowonloadPDF(Request $request) {        
        $invoice_status = $request->invoice_status;
        $archive_status = $request->archive_status;
        $user = Auth::user();         
        if($invoice_status == 'all'){
            $InvoiceStatusDetailsGrid = CreateInvoice::where('user_id',$user->id)->where('archived_status',$archive_status)->get();        
        }else{
            $InvoiceStatusDetailsGrid = CreateInvoice::where('user_id',$user->id)->where('invoice_status',$invoice_status)->where('archived_status',$archive_status)->get();        
        }        
//        dd($InvoiceStatusDetailsGrid);
       $pdf = PDF::loadView('pages.ajaxmodal.manage_invoice_pdf', ['user_id'=>$user->id,'activites'=>$InvoiceStatusDetailsGrid]);  
       return $pdf->download('Invoice_detail-'.date('d-m-Y H:i:s').'.pdf');
    }
    
    public function InvoiceStatusAjax(Request $request){
        $invoice_status = $request->invoice_status;
        $archive_status = $request->archive_status;
        $user = Auth::user();         
        if($invoice_status == 'all'){
            $InvoiceStatusDetailsGrid = CreateInvoice::where('user_id',$user->id)->where('archived_status',$archive_status)->get();        
        }else{
            $InvoiceStatusDetailsGrid = CreateInvoice::where('user_id',$user->id)->where('invoice_status',$invoice_status)->where('archived_status',$archive_status)->get();        
        }        
        return view('pages.ajaxmodal.GetInvoiceStatusDetails', ['InvoiceStatusDetailsGrid' => $InvoiceStatusDetailsGrid,'role'=>$request->role,'user_id'=>encrypt($user->id)]);
    }
    
    public function ChangeBatchAction(Request $request){
        $action_status =  $request->batch_action_status;
        $arrayofids = $request->chkinvoiceid;
       
        if($action_status == 4){
        DB::table('create_invoices')->whereIn('id', $arrayofids)->update(array('invoice_status' => $action_status)); 
        
        }elseif($action_status == 1){
        DB::table('create_invoices')->whereIn('id', $arrayofids)->update(array('archived_status' => $action_status));
        
        }else{
            $usersemail = DB::table('create_invoices')
                    ->select('bill_to_email')
                    ->whereIn('id', $arrayofids)
                    ->get();
            foreach($usersemail as $emailids){                
                Mail::to($emailids->bill_to_email)->send(new SendInvoiceMailToBillToAndCC());
            }
            
            CreateInvoice::whereIn('id', $arrayofids)
             ->update([
               'reminder_count'=> \Illuminate\Support\Facades\DB::raw('reminder_count+1')
             ]);
        }
    }
    
    public function EditInvoice(Request $request,$id){
        $user = Auth::user();  
        $data['individualKyc'] = IndividualKyc::where('user_id',$user->id)->first();
        $data['individualtwodetails'] = Individual::select('primary_email','primary_phone')->where('user_id',$user->id)->first();
        $data['addressBookContacts'] = AddressBook::where('user_id',$user->id)->where('status',1)->distinct()->get(['email']);
        $data['allCategory'] = InvoiceCategory::where('status',0)->get(); 
        $data['allTaxList'] = TaxInformations::where('user_id',$user->id)->where('status',0)->get();        
        $data['SingleInvoiceDetails'] = CreateInvoice::where('user_id',$user->id)->where('id',Crypt::decrypt($id))->first();
        $data['invoiceItemList'] = InvoiceItemsList::where('create_invoice_id',Crypt::decrypt($id))->get();
        $data['currencyMaster'] = Currencie::get();
        $data['user_id'] = encrypt($user->id);
        
         //business information
        $selected_id = $data['SingleInvoiceDetails']->invoice_cat_id;
        $getBusinessInfo = BusinessInformations::where('category_id', $selected_id)->where('user_id', $user->id)->first();
        $getBusinessInfoDetails = [];
        if (!empty($getBusinessInfo)) {
            foreach ($getBusinessInfo->toArray() as $key => $value) {
                try {
                    $getBusinessInfoDetails[$key] = Crypt::decrypt($value);
                } catch (DecryptException $e) {
                    $getBusinessInfoDetails[$key] = $value;
                }
            }
        }
        $data['getBusinessInfoDetails'] = $getBusinessInfoDetails;
        
        return view('pages.user.edit-invoice')->with($data);  
    }
    public function CopyInvoice(Request $request,$id){        
        $user = Auth::user();  
        $data['individualKyc'] = IndividualKyc::where('user_id',$user->id)->first();
        $data['individualtwodetails'] = Individual::select('primary_email','primary_phone')->where('user_id',$user->id)->first();
        $data['addressBookContacts'] = AddressBook::where('user_id',$user->id)->where('status',1)->distinct()->get(['email']);
        $data['allCategory'] = InvoiceCategory::where('status',0)->get(); 
        $data['allTaxList'] = TaxInformations::where('user_id',$user->id)->where('status',0)->get();        
        $data['SingleInvoiceDetails'] = CreateInvoice::where('user_id',$user->id)->where('id',Crypt::decrypt($id))->first();
        $data['invoiceItemList'] = InvoiceItemsList::where('create_invoice_id',Crypt::decrypt($id))->get();
        $data['currencyMaster'] = Currencie::get();
        $data['user_id'] = encrypt($user->id);
//business information
        $selected_id = $data['SingleInvoiceDetails']->invoice_cat_id;
        $getBusinessInfo = BusinessInformations::where('category_id', $selected_id)->where('user_id', $user->id)->first();
        $getBusinessInfoDetails = [];
        if (!empty($getBusinessInfo)) {
            foreach ($getBusinessInfo->toArray() as $key => $value) {
                try {
                    $getBusinessInfoDetails[$key] = Crypt::decrypt($value);
                } catch (DecryptException $e) {
                    $getBusinessInfoDetails[$key] = $value;
                }
            }
        }
        $data['getBusinessInfoDetails'] = $getBusinessInfoDetails;
        return view('pages.user.copy-invoice')->with($data);  
    }
    
    public function PrintInvoiceView(Request $request){
        $id = Crypt::decrypt($request->selected_id);
        $user = Auth::user();  
        $SingleInvoiceDetails = CreateInvoice::where('user_id',$user->id)->where('id',$id)->first(); 
        $invoiceItemList = InvoiceItemsList::where('create_invoice_id',$id)->get();
        return view('pages.ajaxmodal.InvoiceView', ['userid'=>$user->id,'SingleInvoiceDetails' => $SingleInvoiceDetails,'invoiceItemList'=>$invoiceItemList]);
        
    }
    
    public function generatePDF(Request $request,$id)
    {   
       $user = Auth::user(); 
       $CreateInvoice = CreateInvoice::where('user_id',$user->id)->where('id',Crypt::decrypt($id))->first(); 
       $InvoiceItemList = InvoiceItemsList::where('create_invoice_id',Crypt::decrypt($id))->get();  
       $pdf = PDF::loadView('pages.ajaxmodal.generate_pdf', ['user_id'=>$user->id,'CreateInvoice'=>$CreateInvoice,'InvoiceItemList'=>$InvoiceItemList]);  
       return $pdf->download('Invoice_detail-'.$CreateInvoice->invoice_number.'.pdf');
    }
    
    public function DeleteDraftOrCancelInvoice(Request $request){
        $invoice_id = Crypt::decrypt($request->selected_id);
        $link = $request->link;
        if($link == 'delete-draft-invoice'){
            $CreateInvoice= CreateInvoice::findorfail($invoice_id); 
            $CreateInvoice->delete(); 
            echo "1";
        }else if ($link == 'cancel-invoice'){
            $CreateInvoice = CreateInvoice::find($invoice_id);
            $CreateInvoice->invoice_status = 4;
            $CreateInvoice->save();
            echo "2";
        }
        
    }
    
    
}
