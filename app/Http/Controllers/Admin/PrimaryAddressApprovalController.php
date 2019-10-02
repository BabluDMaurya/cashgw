<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\IndividualKyc;
use App\BusinessKyc;
use App\ChangePrimaryAddressRequest;
use Mail;
use App\Mail\AdminVerifyAprovalMail;
use App\Mail\AdminRequestPaymentApprovalMail;
use App\Mail\PrimaryAddressApprovalMail;
use App\Mail\PrimaryAddressRejectMail;
use App\AdminLogin;

use Illuminate\Notifications\Notifiable;
use App\Notifications\UpdateApproval;
class PrimaryAddressApprovalController extends Controller {
    use Notifiable;  
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }

    public function index() {
        $IndividualPrimaryAddressDetails = DB::table('change_primary_address_requests')
                ->join('individual_kycs', 'change_primary_address_requests.user_id', '=', 'individual_kycs.user_id')
                ->join('users', 'change_primary_address_requests.user_id', '=', 'users.id')
                ->select(
                        'change_primary_address_requests.id',
                        'change_primary_address_requests.user_id',
                        'change_primary_address_requests.role',
                        'change_primary_address_requests.add_line_one',
                        'change_primary_address_requests.add_line_two',
                        'change_primary_address_requests.town_or_city',
                        'change_primary_address_requests.zip',
                        'change_primary_address_requests.state',
                        'change_primary_address_requests.country',
                        'change_primary_address_requests.address_proof',
                        'change_primary_address_requests.admin_status',
                        'change_primary_address_requests.created_at',
                        'change_primary_address_requests.updated_at', 
                        'users.email',
                        'individual_kycs.fname',
                        'individual_kycs.lname'
                        )
                ->where('change_primary_address_requests.role', '=', 1)
                ->orderby('change_primary_address_requests.created_at', 'DESC')
                ->get();
        $BusinessPrimaryAddressDetails = DB::table('change_primary_address_requests')
                ->join('business_kycs', 'change_primary_address_requests.user_id', '=', 'business_kycs.user_id')
                 ->join('users', 'change_primary_address_requests.user_id', '=', 'users.id')
                ->select(
                        'change_primary_address_requests.id',
                        'change_primary_address_requests.user_id',
                        'change_primary_address_requests.role',
                        'change_primary_address_requests.add_line_one',
                        'change_primary_address_requests.add_line_two',
                        'change_primary_address_requests.town_or_city',
                        'change_primary_address_requests.zip',
                        'change_primary_address_requests.state',
                        'change_primary_address_requests.country',
                        'change_primary_address_requests.address_proof',
                        'change_primary_address_requests.admin_status',
                        'change_primary_address_requests.created_at',
                        'change_primary_address_requests.updated_at',                        
                        'users.email',
                        'business_kycs.fname',
                        'business_kycs.lname',
                        'business_kycs.business_name'
                        )
                ->where('change_primary_address_requests.role', '=', 2)
                ->orderby('change_primary_address_requests.created_at', 'DESC')
                ->get();
        $user = AdminLogin::where('email',config('constants.AdminMail'))->first();
        $user->unreadNotifications()->where('notifiable_type','App\AdminLogin')->whereIn('type',['App\Notifications\UpdateApproval'])->update(['read_at' => now()]);
        return view('pages.admin.primary-address-approval', compact('IndividualPrimaryAddressDetails', 'BusinessPrimaryAddressDetails'));
    }

    public function ViewPrimaryAddressApproval(Request $request) {
        $id = decrypt($request->id);
        $ViewUserAddressDetails = DB::table('change_primary_address_requests')
                ->select('change_primary_address_requests.*')
                ->where('change_primary_address_requests.id', '=', $id)
                ->get();
        return view('pages.ajaxmodal.viewuserprimaryaddress', ['ViewUserAddressDetails' => $ViewUserAddressDetails]);
    }

    public function AppOrRejectAddressByAdmin(Request $request) {
        $user_id = decrypt($request->user_id);
        $status_val = $request->status_val;
        $id = decrypt($request->id);

        $addressDetailsRow = ChangePrimaryAddressRequest::where('user_id', $user_id)->orderby('change_primary_address_requests.created_at', 'DESC')->first();
        $users = User::where('id', $user_id)->first();
        $email = $users->email;
        $role = $request->role;

        if ($status_val == 1) {
            if ($role == 1) {
                $updateAddress = IndividualKyc::where('user_id', $user_id)
                                ->update(['add_line_one' => Crypt::encrypt($addressDetailsRow['add_line_one']),
                                'add_line_two' => Crypt::encrypt($addressDetailsRow['add_line_two']),
                                'town_or_city' => Crypt::encrypt($addressDetailsRow['town_or_city']),
                                'zip' => Crypt::encrypt($addressDetailsRow['zip']),
                                'state' => Crypt::encrypt($addressDetailsRow['state']),
                                'country' => Crypt::encrypt($addressDetailsRow['country']),
                                'address_proof' => Crypt::encrypt($addressDetailsRow['address_proof'])]);
                $updateStatus = ChangePrimaryAddressRequest::where('id', $id)
                        ->update(['admin_status' => 1]);

                $username = IndividualKyc::where('user_id', $user_id)->first();
                $fname = $username['fname'];
                Mail::to($email)->send(new PrimaryAddressApprovalMail($fname));
                echo "1";
            } else {
                $updateAddress = BusinessKyc::where('user_id', $user_id)
                                 ->update(['add_line_one' => Crypt::encrypt($addressDetailsRow['add_line_one']),
                                'add_line_two' => Crypt::encrypt($addressDetailsRow['add_line_two']),
                                'town_or_city' => Crypt::encrypt($addressDetailsRow['town_or_city']),
                                'zip' => Crypt::encrypt($addressDetailsRow['zip']),
                                'state' => Crypt::encrypt($addressDetailsRow['state']),
                                'country' => Crypt::encrypt($addressDetailsRow['country']),
                                'address_proof' => Crypt::encrypt($addressDetailsRow['address_proof'])]);
                $updateStatus = ChangePrimaryAddressRequest::where('id', $id)
                        ->update(['admin_status' => 1]);

                $businessname = BusinessKyc::where('user_id', $user_id)->first();
                $bname = $businessname['business_name'];
                Mail::to($email)->send(new PrimaryAddressApprovalMail($bname));
                echo "1";
            }
            
            $notifydata = [
                            'request_status' => 7,
                            'action'=>'Approval',
                            'process'=>2,
                            'type'=>'UpdateApproval',
                            'tab'=> $role,    
                        ];
                $users->notify(new UpdateApproval($notifydata));
                
        } else {
            $updateStatus = ChangePrimaryAddressRequest::where('id', $id)
                    ->update(['admin_status' => 2]);
            if ($role == 1) {
                $username = IndividualKyc::where('user_id', $user_id)->first();
                $fname = $username['fname'];
                Mail::to($email)->send(new PrimaryAddressRejectMail($fname));
            } else {
                $businessname = BusinessKyc::where('user_id', $user_id)->first();
                $bname = $businessname['business_name'];
                Mail::to($email)->send(new PrimaryAddressRejectMail($bname));
            }
            $notifydata = [
                            'request_status' => 7,
                            'action'=>'Approval',
                            'process'=>3,
                            'type'=>'UpdateApproval',
                            'tab'=> $role,    
                        ];
                $users->notify(new UpdateApproval($notifydata));
                
            echo "2";
        }
    }

}
