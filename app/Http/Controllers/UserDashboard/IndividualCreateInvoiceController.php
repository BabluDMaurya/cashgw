<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\InvoiceCategory;
use App\ManageItem;
use App\BusinessInformations;
use App\TaxInformations;
use App\AddressBook;
use App\IndividualKyc;
use App\Individual;
use App\CreateInvoice;
use App\InvoiceItemsList;
use App\Activity;
use Mail;
use App\Mail\SendInvoiceMailToBillToAndCC;
use App\Mail\SendInvoiceMailToSender;
use App\User;
use App\EmailOTPCheck;
use App\Mail\SendInvoiceOtp;
use App\AmountBalanceMaster;
use App\Currencie;
//use App\Traits\PaymentHistoryTrait;
//use App\Traits\ActivityTrait;
use App\Traits\TransactionIdTrait;
use App\Jobs\UserNotExitsMailJob;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Route;
use App\Traits\AddUserOnAddressBook;

use Illuminate\Notifications\Notifiable;
use App\Notifications\Invoice;
use App\Traits\BalanceTrait;
use App\Mail\JoinCashgwMail;
use App\Traits\UnRegisterEmailTrait;
class IndividualCreateInvoiceController extends Controller {
use TransactionIdTrait,AddUserOnAddressBook,Notifiable,BalanceTrait,UnRegisterEmailTrait;

public $currentpath;

public function __construct() {
        $this->currentpath = Route::getFacadeRoot()->current()->uri();
    }

    public function index($id) {

        try {
            $user = Auth::user();
            $decrypted = Crypt::decrypt($id);
            if ($user->id != $decrypted) {
                throw new Exception("User not login");
            }
            $individualKyc = IndividualKyc::where('user_id', $user->id)->first();
            $individualtwodetails = Individual::select('primary_email', 'primary_phone')->where('user_id', $user->id)->first();
            $addressBookContacts = AddressBook::where('user_id', $user->id)->where('status', 1)->distinct()->get(['email']);
            $allCategory = InvoiceCategory::where('status', 0)->get();
            $allTaxList = TaxInformations::where('user_id', $user->id)->where('status', 0)->get();
            $currencyMaster = Currencie::get();
        } catch (DecryptException $e) {
            $errormes = 'Decryption error';
        } catch (QueryException $qe) {
            $errormes = 'User table error';
        } catch (Exception $ee) {
            $errormes = 'Code error';
        } finally {
            if (empty($errormes)) {
                return view('pages.user.create-invoice', ['user_id' => $id, 'allCategory' => $allCategory, 'addressBookContacts' => $addressBookContacts, 'individualKyc' => $individualKyc, 'individualtwodetails' => $individualtwodetails, 'allTaxList' => $allTaxList, 'currencyMaster' => $currencyMaster]);
            } else {
                Auth::logout();
                session()->flash('status', $errormes);
                return redirect('/login');
            }
        }
    }

    public function BusinessInfoOnChangeInvoiceCategory(Request $request) {
        $user = Auth::user();
        $selected_id = $request->selected_id;
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
        echo json_encode($getBusinessInfoDetails);
    }

    public function GetItemsOnChangeInvoiceCategory(Request $request) {
        $user = Auth::user();
        $selected_id = $request->selected_id;
        $ItemDetails = ManageItem::where('invoice_cat_id', $selected_id)->where('user_id', $user->id)->get();
        return view('pages.ajaxmodal.GetItemsDetailsOnAjax', ['ItemDetails' => $ItemDetails]);
    }

    public function CreateInvoiceList(Request $request) {
//        dd($request);
        $user = Auth::user();  
        
        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        $cur_date = date('Y-m-d');
        $status_value = $request->status_value;

        if ($invoice_date > $cur_date && $status_value == 3) {
            $status_value = 2;
        }
        $dueDate = date('Y-m-d', strtotime($request->invoice_date . "+$request->due_date days"));    
        
        $validator = Validator::make($request->all(), [            
            'invoice_category_id' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'bill_to_email' => 'required|email|string|emailformate|exists:users,email|emaildomain|itselfloginemail',
            'item_name'=>'required',
            'item_desc'=>'required',
            'item_price'=>'required|min:1|not_in:0',
                ], [
            'item_name'=>'Item Name Required',        
            'item_desc'=>'Item Description Required',        
            'item_price'=>'Item Price Required',     
            'invoice_category_id.required' => 'Category Required',
            'invoice_date.required' => 'Invoice Date Required',
            'due_date.required' => 'Due Date Required',
            'bill_to_email.required' => 'Please Select Email Id',
            'bill_to_email.email' => 'Please Enter Valid Email',
            'bill_to_email.exists' => 'Cashgw send a mail to this email.when he/she register then your request proceeds.',     
            ]);   
            
        //// ------------user doesnot exits ------------////
        $transactionId = $this->createTID();
        if ($validator->fails()){
                $failedRules = $validator->failed();
                if(isset($failedRules['bill_to_email']['Exists'])){
                    
                    if ($request->hasFile('invoice_business_logo')) {
                        $file = $request->file('invoice_business_logo');
                        $invoice_business_logo_fileName = $user->id . 'invoice_business_logo' . time() . '.' . $file->getClientOriginalExtension();
                        $fileuploadpath = public_path() . '/images/' . $user->id;
                        $file->move($fileuploadpath, $invoice_business_logo_fileName);
                    } else {
                        $invoice_business_logo_fileName = $request->invoice_business_logo_pre;
                    }
                    if ($request->hasFile('invoice_attach_file')) {
                        $file = $request->file('invoice_attach_file');
                        $invoice_attach_fileName = $user->id . 'invoice_attach_file' . time() . '.' . $file->getClientOriginalExtension();
                        $fileuploadpath = public_path() . '/images/' . $user->id;
                        $file->move($fileuploadpath, $invoice_attach_fileName);
                    } else {
                        $invoice_attach_fileName = '';
                    }        
                    $CreateInvoiceId = CreateInvoice::Create([
                                'user_id' => $user->id,
                                'invoice_cat_id' => $request->invoice_category_id,
                                'invoice_number' => $request->invoice_number,
                                'transaction_id' => $transactionId,
                                'invoice_date' => $invoice_date,
                                'reference' => $request->reference,
                                'business_logo' => $invoice_business_logo_fileName,
                                'business_name' => $request->business_name,
                                'first_name' => $request->first_name,
                                'address' => $request->address,
                                'phone' => $request->phone,
                                'email_id' => $user->email,
                                'due_date_value' => $dueDate,
                                'bill_to_email' => $request->bill_to_email,
                                'cc_email' => $request->cc_email,
                                'notes_to_recepient' => $request->notes_to_recepient,
                                'terms_and_conditions' => $request->terms_and_conditions,
                                'attach_file' => $invoice_attach_fileName,
                                'add_memo_to_self' => $request->add_memo_to_self,
                                'invoice_subtotal' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_subtotal)),
                                'invoice_discount_in_percent' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_discount_in_percent)),
                                'invoice_discount_in_value' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_discount_in_value)),
                                'invoice_shipping' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_shipping)),
                                'invoice_grand_total' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_grand_total)),
                                'currency' => $request->select_currency,
                                'tax_id' => $request->taxTypeSelect,
                                'invoice_status' => $status_value
                    ]);

                    $last_id = $CreateInvoiceId->id;

                    $itemLength = count($request->item_name);

                    for ($i = 0; $i < $itemLength; $i++) {
                        InvoiceItemsList::Create([
                            'create_invoice_id' => $last_id,
                            'item_name' => $request->item_name[$i],
                            'item_desc' => $request->item_desc[$i],
                            'item_quantity' => $request->item_quantity[$i],
                            'item_price' => $request->item_price[$i],
                            'item_amount' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->item_amount[$i])),
                            'item_tax_id' => $request->item_tax_id[$i],
                        ]);
                    }
                    

                    //create activity                        
                    $reciver = $this->getReciverNameIDRoleByEmail($request->bill_to_email);              
                    $sender = $this->getSenderNameEmailRoleById();

                    $activity1 =  $this->createActivity($sender['id'],$sender['id'],$last_id,$reciver['name'],$reciver['email'],1,trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_grand_total)),5,NULL,$request->notes_to_recepient,$transactionId,$request->select_currency,date('Y-m-d'));
                    $this->unRegisterEmail('activities', $activity1, $user->id, $request->bill_to_email, 1, 'name', Null);
                    
                    $activity2 = $this->createActivity($reciver['id'],$sender['id'],$last_id,$sender['name'],$sender['email'],1,trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_grand_total)),6,NULL,$request->notes_to_recepient,$transactionId,$request->select_currency,$invoice_date);
                    $this->unRegisterEmail('activities', $activity2, $user->id, $request->bill_to_email, 1, 'user_id', Null);
                    // add user in address book //
                    
                    $this->AddUserOnMyAddressbook($request->bill_to_email);
                    
                    //--end----//
                    Mail::to($user->email)->send(new SendInvoiceMailToSender($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total));
//                    Mail::to($request->bill_to_email)->send(new SendInvoiceMailToBillToAndCC($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total, encrypt($last_id),'pay-invoice'));
                    Mail::to($request->bill_to_email)->send(new JoinCashgwMail());
//                    $job = (new UserNotExitsMailJob($request->bill_to_email))->delay(Carbon::now()->addSeconds(20));
//                            dispatch($job);
                    
                    session()->flash('status',config('constants.UserNotExits'));
                    return redirect()->back();
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

//// ------------user doesnot exits ------------////
        
        if ($request->hasFile('invoice_business_logo')) {
            $file = $request->file('invoice_business_logo');
            $invoice_business_logo_fileName = $user->id . 'invoice_business_logo' . time() . '.' . $file->getClientOriginalExtension();
            $fileuploadpath = public_path() . '/images/' . $user->id;
            $file->move($fileuploadpath, $invoice_business_logo_fileName);
        } else {
            $invoice_business_logo_fileName = $request->invoice_business_logo_pre;
        }
        if ($request->hasFile('invoice_attach_file')) {
            $file = $request->file('invoice_attach_file');
            $invoice_attach_fileName = $user->id . 'invoice_attach_file' . time() . '.' . $file->getClientOriginalExtension();
            $fileuploadpath = public_path() . '/images/' . $user->id;
            $file->move($fileuploadpath, $invoice_attach_fileName);
        } else {
            $invoice_attach_fileName = '';
        }        
        $CreateInvoiceId = CreateInvoice::Create([
                    'user_id' => $user->id,
                    'invoice_cat_id' => $request->invoice_category_id,
                    'invoice_number' => $request->invoice_number,
                    'transaction_id' => $transactionId,
                    'invoice_date' => $invoice_date,
                    'reference' => $request->reference,
                    'business_logo' => $invoice_business_logo_fileName,
                    'business_name' => $request->business_name,
                    'first_name' => $request->first_name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email_id' => $user->email,
                    'due_date_value' => $dueDate,
                    'bill_to_email' => $request->bill_to_email,
                    'cc_email' => $request->cc_email,
                    'notes_to_recepient' => $request->notes_to_recepient,
                    'terms_and_conditions' => $request->terms_and_conditions,
                    'attach_file' => $invoice_attach_fileName,
                    'add_memo_to_self' => $request->add_memo_to_self,
                    'invoice_subtotal' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_subtotal)),
                    'invoice_discount_in_percent' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_discount_in_percent)),
                    'invoice_discount_in_value' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_discount_in_value)),
                    'invoice_shipping' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_shipping)),
                    'invoice_grand_total' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_grand_total)),
                    'currency' => $request->select_currency,
                    'tax_id' => $request->taxTypeSelect,
                    'invoice_status' => $status_value
        ]);
        $last_id = $CreateInvoiceId->id;
        $itemLength = count($request->item_name);
        for ($i = 0; $i < $itemLength; $i++) {
            InvoiceItemsList::Create([
                'create_invoice_id' => $last_id,
                'item_name' => $request->item_name[$i],
                'item_desc' => $request->item_desc[$i],
                'item_quantity' => $request->item_quantity[$i],
                'item_price' => $request->item_price[$i],
                'item_amount' => trim(str_replace($request->hiddenCurrencySymbol, "", $request->item_amount[$i])),
                'item_tax_id' => $request->item_tax_id[$i],
            ]);
        }  
        //create activity                        
        $reciver = $this->getReciverNameIDRoleByEmail($request->bill_to_email);              
        $sender = $this->getSenderNameEmailRoleById();

        $activity1 =  $this->createActivity($sender['id'],$sender['id'],$last_id,$reciver['name'],$reciver['email'],1,trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_grand_total)),5,NULL,$request->notes_to_recepient,$transactionId,$request->select_currency,date('Y-m-d'));
        Mail::to($user->email)->send(new SendInvoiceMailToSender($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total));
        

            $activity2 = $this->createActivity($reciver['id'],$sender['id'],$last_id,$sender['name'],$sender['email'],1,trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_grand_total)),6,NULL,$request->notes_to_recepient,$transactionId,$request->select_currency,$invoice_date);
            Mail::to($request->bill_to_email)->send(new SendInvoiceMailToBillToAndCC($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total, encrypt($last_id),'pay-invoice'));

            if ($request->cc_email != '') {
                Mail::to($request->cc_email)->send(new SendInvoiceMailToBillToAndCC($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total, encrypt($last_id),'pay-invoice'));
            }
            //notification 
             $notifydata = [            
                'balance' => $request->invoice_grand_total,              
                'action'=>'send',
                'process'=>1,
                'request_status' => 5,
                'tab'=>1,
                'showdate'=>$invoice_date, 
            ];
            $client = User::where('id', $reciver['id'])->first();
            $client->notify(new Invoice($notifydata));

        
        if($status_value == 1){
        $mes = 'Invoice Save as draft Successfully';    
        }else{
        $mes = 'Invoice Sent Successfully';
        }
        session()->flash('status', $mes);
        
        return redirect()->back();
    }

    public function updateInvoiceList(Request $request) {

        $user = Auth::user();
        $this->validate($request, [
//            'invoice_category_id' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'bill_to_email' => 'required|email|emailformate|string|itselfloginemail',
               'item_name'=>'required',
                    'item_desc'=>'required',
                    'item_price'=>'required|min:1|not_in:0',
                        ], [
                    'item_name'=>'Item Name Required',        
                    'item_desc'=>'Item Description Required',        
                    'item_price'=>'Item Price Required',  
//            'invoice_category_id.required' => 'Category Required',
            'invoice_date.required' => 'Invoice Date Required',
            'due_date.required' => 'Due Date Required',
            'bill_to_email.required' => 'Please Select Email Id',
            'bill_to_email.email' => 'Please Enter Valid Email'
        ]);
        $invoiceId = Crypt::decrypt($request->invoiceId);
        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));
//        echo $invoice_date;
//        exit();
        $cur_date = date('Y-m-d');
        $status_value = $request->status_value;

        if ($invoice_date > $cur_date && $status_value == 3) {
            $status_value = 2;
        }
        // exit();

        if ($request->hasFile('invoice_business_logo')) {
            $file = $request->file('invoice_business_logo');
            $invoice_business_logo_fileName = $user->id . 'invoice_business_logo' . time() . '.' . $file->getClientOriginalExtension();
            $fileuploadpath = public_path() . '/images/' . $user->id;
            $file->move($fileuploadpath, $invoice_business_logo_fileName);
        } else {
            $invoice_business_logo_fileName = $request->invoice_business_logo_pre;
        }
        if ($request->hasFile('invoice_attach_file')) {
            $file = $request->file('invoice_attach_file');
            $invoice_attach_fileName = $user->id . 'invoice_attach_file' . time() . '.' . $file->getClientOriginalExtension();
            $fileuploadpath = public_path() . '/images/' . $user->id;
            $file->move($fileuploadpath, $invoice_attach_fileName);
        } else {
            $invoice_attach_fileName = '';
        }
        $dueDate = date('Y-m-d', strtotime($request->invoice_date . "+$request->due_date days")); 
        $updateInvoiceId = CreateInvoice::find($invoiceId);
//        $updateInvoiceId->user_id = $user->id;
//        $updateInvoiceId->invoice_cat_id = $request->invoice_category_id;
//        $updateInvoiceId->invoice_number = $request->invoice_number;
        $updateInvoiceId->invoice_date = $invoice_date;
        $updateInvoiceId->reference = $request->reference;
        $updateInvoiceId->business_logo = $invoice_business_logo_fileName;
        $updateInvoiceId->business_name = $request->business_name;
        $updateInvoiceId->first_name = $request->first_name;
        $updateInvoiceId->address = $request->address;
        $updateInvoiceId->phone = $request->phone;
        $updateInvoiceId->email_id = $user->email;
        $updateInvoiceId->due_date_value = $dueDate;
        $updateInvoiceId->bill_to_email = $request->bill_to_email;
        $updateInvoiceId->cc_email = $request->cc_email;
        $updateInvoiceId->notes_to_recepient = $request->notes_to_recepient;
        $updateInvoiceId->terms_and_conditions = $request->terms_and_conditions;
        $updateInvoiceId->attach_file = $invoice_attach_fileName;
        $updateInvoiceId->add_memo_to_self = $request->add_memo_to_self;
        $updateInvoiceId->invoice_subtotal = trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_subtotal));
        $updateInvoiceId->invoice_discount_in_percent = trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_discount_in_percent));
        $updateInvoiceId->invoice_discount_in_value = trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_discount_in_value));
        $updateInvoiceId->invoice_shipping = trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_shipping));
        $updateInvoiceId->invoice_grand_total = trim(str_replace($request->hiddenCurrencySymbol, "", $request->invoice_grand_total));
        $updateInvoiceId->currency = $request->select_currency;
        $updateInvoiceId->tax_id = $request->taxTypeSelect;
        $updateInvoiceId->invoice_status = $status_value;
        $updateInvoiceId->save();

         $itemLength = count($request->item_name);

        for ($i = 0; $i < $itemLength; $i++) {
           if(isset($request->itemId[$i]) && !empty($request->itemId[$i])){
                $updateInvoiceItems = InvoiceItemsList::find(decrypt($request->itemId[$i]));            
                $updateInvoiceItems->create_invoice_id = $invoiceId;
                $updateInvoiceItems->item_name = $request->item_name[$i];
                $updateInvoiceItems->item_desc = $request->item_desc[$i];
                $updateInvoiceItems->item_quantity = $request->item_quantity[$i];
                $updateInvoiceItems->item_price = $request->item_price[$i];
                $updateInvoiceItems->item_amount = trim(str_replace($request->hiddenCurrencySymbol, "", $request->item_amount[$i]));
                $updateInvoiceItems->item_tax_id = $request->item_tax_id[$i];
                $updateInvoiceItems->save();
            }else{
                InvoiceItemsList :: create([
                    'create_invoice_id' => $invoiceId,
                    'item_name'=> $request->item_name[$i],
                    'item_desc'=> $request->item_desc[$i],
                    'item_quantity' => $request->item_quantity[$i],
                    'item_price'=> $request->item_price[$i],
                    'item_amount'=> trim(str_replace($request->hiddenCurrencySymbol, "", $request->item_amount[$i])),
                    'item_tax_id'=> $request->item_tax_id[$i]
                ]);
            }
        }
        $mes = 'Invoice Updated Successfully';
        session()->flash('status', $mes);
        Mail::to($user->email)->send(new SendInvoiceMailToSender($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total));
        Mail::to($request->bill_to_email)->send(new SendInvoiceMailToBillToAndCC($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total, encrypt($invoiceId),'pay-invoice'));

        if ($request->cc_email != '') {
            Mail::to($request->cc_email)->send(new SendInvoiceMailToBillToAndCC($request->bill_to_email, $request->invoice_number, $invoice_date, $dueDate, $request->invoice_grand_total, encrypt($invoiceId),'pay-invoice'));
        }
        return redirect()->back();
    }

    //create invoice page on modal popup previw
    public function GetInvoicePreview(Request $request) {
        $user = Auth::user();
        $InvoicePreviewData = $request->all();
        if (isset($request->invoice_business_logo)) {
            $InvoicePreviewData['invoice_business_logo'] = base64_decode($request->invoice_business_logo);
        }
        // echo "<pre>";
        // print_r($InvoicePreviewData);exit();
        return view('pages.ajaxmodal.InvoicePreview', ['InvoicePreviewData' => $InvoicePreviewData, 'userid' => $user->id]);
    }

    public function getAllUsersEmail(Request $request) {
        $user = Auth::user();
        $userEmails = User::where('email', 'like', "%$request->userEmail%")->get()->toArray();
        $addressBookUser = AddressBook::where('status',1)->where('user_id', $user->id)->where('email', 'like', "%$request->userEmail%")->get()->toArray();
        $return = '';
        $return .= '<ul>';
        $return .= '<li class="addItemIcon"><i class="fas fa-plus-circle"></i> Add new customer</li>';
        if (count($addressBookUser) > 0) {
            foreach ($addressBookUser as $details) {
                if($details['email'] != $user->email){
                $email = $details['email'];
                $return .= "<li class='emailList'>$email</li>";
            }
        }
        }elseif (count($userEmails) > 0) {
            foreach ($userEmails as $details) {
                if($details['email'] != $user->email){
                $email = $details['email'];
                $return .= "<li class='emailList'>$email</li>";
            }
        }
        }
        $return .= '</ul>';
        echo $return;
    }

    public function viewInvoicePreview(Request $request, $id) {
        $user = Auth::user();
        $data['login_id'] = $user->id;
        $decrypted = Crypt::decrypt($id);
        $data['invoiceData'] = CreateInvoice::where('id', $decrypted)->get()->toArray();
        $invoiceCurrency = $data['invoiceData'][0]['currency'];
        $data['currencyDeails'] = Currencie::where('id', $invoiceCurrency)->get()->toArray();
        $data['invoiceItems'] = \DB::table('invoice_items_lists as invoice')->leftJoin('tax_informations as tax', 'invoice.item_tax_id', '=', 'tax.id')->where('create_invoice_id', $data['invoiceData'][0]['id'])->get();
        $data['invoice_id'] = $id;
        $data['paynow'] = '/confirm-pay-invoice/';
        return view('pages.invoice-preview')->with($data);
    }

    public function sendInvoiceOpt(Request $request, $id) {
        try {
            $decrypted = Crypt::decrypt($id);
            if (Auth::check()) {
                $user = Auth::user();
                $data['user_id'] = $user->id;
                $data['invoice_id'] = $id;
                $invoiceData = CreateInvoice::where('id', $decrypted)->get()->toArray();
                $token = $request->session()->token();
                $otp = rand(10000, 99999);
                $insert = EmailOTPCheck::Create(['email' => $invoiceData[0]['bill_to_email'], 'otp' => $otp, 'token' => $token]);
                Mail::to($invoiceData[0]['bill_to_email'])->send(new SendInvoiceOtp($otp));
                return redirect('/confirm-pay-invoice-otp/' . $id);
            } else {
                $request->session()->put('invoiceId', $decrypted);
                return redirect('/login');
            }
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function viewConfirmInvoicePayment(Request $request, $id) {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['invoice_id'] = $id;
        $data['invoice_otp_check'] = 'check-invoice-otp';
        $data['manage'] = 'individual-recieved-invoice';
        $data['balance'] = 'individual-balance';
        $data['dashboard'] = 'userdashboard';
        $request->session()->forget('invoiceId');        
        return view('pages.invoice-confirm-otp')->with($data);
    }

    public function makeInvoicePayment($invoiceData) {        
        $user = Auth::user();     
        $requestdetails = [
            'currency_requested'=> $invoiceData[0]['currency'],
            'from' => $invoiceData[0]['user_id'],
            'balance' => $invoiceData[0]['invoice_grand_total'],
            'user_id'=>$invoiceData[0]['user_id'],
            'invoiceId' => $invoiceData[0]['id'],
            'email_id' => $invoiceData[0]['email_id'],
            'note' => decrypt($invoiceData[0]['notes_to_recepient']),
            'transaction_id' => decrypt($invoiceData[0]['transaction_id']),
            'login_id' => encrypt($user->id),
        ];
        $responcedata = array();
        $responcedata = $this->invoicePaymentBalance($requestdetails);  
        $responcedata['userId'] = encrypt($user->id);
        echo json_encode($responcedata);
    }

    public function checkInvoiceOtp(Request $request) {
//        try {
            $user = Auth::user();
            $decryptedId = Crypt::decrypt($request->invoiceId);
            $token = $request->session()->token();
            $invoiceData = CreateInvoice::where('id', $decryptedId)->get()->toArray();
            $otpDetails = EmailOTPCheck::where('email', $invoiceData[0]['bill_to_email'])->where('otp', $request->otp)->where('token', $token)->get()->toArray();
            
            if (count($otpDetails) > 0) {
                $this->makeInvoicePayment($invoiceData);                
            } else {
                echo json_encode(array('status' => 'wrongOtp', 'message' => 'Wrong OTP', 'userId' => encrypt($user->id)));
            }
//        } catch (\Exception $e) {
//            echo json_encode(array('status' => 'error', 'message' => 'Something went wrong', 'userId' => encrypt($user->id)));
//        }
    }

}
