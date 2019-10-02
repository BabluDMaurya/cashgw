<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\User;
use App\AddressBook;
use Validator;

class AddressBookController extends Controller {

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

        if (isset($request->email)) {
            $addressbookEmails = AddressBook::where('user_id', $user->id)->get();
            $emailList =[];
            foreach ($addressbookEmails as $email) {
                $emailList[] = $email['email'];
            }
        }
        if (isset($request->fname)) {
            $this->validate($request, [
                'fname' => 'required|alpha',
                'lname' => 'required|alpha',
                'email' => 'required|email|emailformate|string',
                'phone' => 'required|max:10'
                    ], [
                'fname.required' => 'FirstName Required',
                'fname.alpha' => 'Only Alphabate allow',
                'lname.required' => 'FirstName Required',
                'lname.alpha' => 'Only Alphabate allow',
                'email.required' => 'Email Required',
                'email.email' => 'Please Enter Valid Email',
                'phone.required' => 'Phone Number Required',
                'phone.max' => 'Phone Number Should be 10 digits',
            ]);
            
            if (in_array($request->email, $emailList)) {
                $mes = 'Email Id Already Exist.';
            } else {
                AddressBook::create([
                    'user_id' => $user->id,
                    'email' => $request->email,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                ]);
                $mes = 'Address Book Updated Successfully';
            }
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
            $addressbookDetails = '';
            $addressbookDetails = AddressBook::where('status', 1)->where('user_id',$user->id)->orderBy('id', 'DESC')->get();
        } catch (DecryptException $e) {
            $errormes = config('constants.DecryptException');
        } catch (QueryException $qe) {
            $errormes = config('constants.QueryException');
        } catch (Exception $ee) {
            $errormes = config('constants.Exception');
        } finally {
            if (empty($errormes)) {
                return view('pages.user.address-book', ['user_id' => $id, 'addressbookDetails' => $addressbookDetails]);
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
        $validator = Validator::make($request->all(), [
                    'email' => 'required', 'email','emailformate',
                    'business_name' => 'required',
                    'fname' => 'required',
                    'lname' => 'required',
                    'country' => 'required',
                    'billing_add_country' => 'required',
                    'billing_address_line_one' => 'required',
                    'billing_address_town_city' => 'required',
                    'billing_address_state' => 'required',
                        ], [
                    'email.required' => 'Email Required',
                    'email.email' => 'Email should be valid',
                    'business_name.required' => 'Business Name Required',
                    'fname.required' => 'First Name Required',
                    'lname.required' => 'Last Name Required',
                    'country.required' => 'Country Required',
                    'billing_add_country.required' => 'Billing Country Required',
                    'billing_address_line_one.required' => 'Billing Address Line 1 Required',
                    'billing_address_town_city.required' => 'Billing Address Town Required',
                    'billing_address_state' => 'Billing Address State Required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $abupdated = AddressBook::find(decrypt($request->id));
        $abupdated->email = $request->email;
        $abupdated->business_name = $request->business_name;
        $abupdated->fname = $request->fname;
        $abupdated->lname = $request->lname;
        $abupdated->country = $request->country;
        $abupdated->phone = $request->phone;
        $abupdated->additional_information = $request->additional_information;
        $abupdated->billing_add_country = $request->billing_add_country;
        $abupdated->billing_address_line_one = $request->billing_address_line_one;
        $abupdated->billing_address_line_two = $request->billing_address_line_two;
        $abupdated->billing_address_town_city = $request->billing_address_town_city;
        $abupdated->billing_address_state = $request->billing_address_state;
        $abupdated->billing_address_zipcode = $request->billing_address_zipcode;
        $abupdated->shipping_address_fname = $request->shipping_address_fname;
        $abupdated->shipping_address_lname = $request->shipping_address_lname;
        $abupdated->shipping_address_business_name = $request->shipping_address_business_name;
        $abupdated->shipping_address_country = $request->shipping_address_country;
        $abupdated->shipping_address_line_one = $request->shipping_address_line_one;
        $abupdated->shipping_address_line_two = $request->shipping_address_line_two;
        $abupdated->shipping_address_town_city = $request->shipping_address_town_city;
        $abupdated->shipping_address_state = $request->shipping_address_state;
        $abupdated->shipping_address_zipcode = $request->shipping_address_zipcode;
        $abupdated->customer_memo = $request->customer_memo;
        $abupdated->save();

        $mes = 'Updated Successfully.';

        if (!empty($mes)) {
            session()->flash('status', $mes);
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

    public function GetSingleContactDetails(Request $request) {
        $id = $request->id;
        $singleDetails = AddressBook::where('id', $id)->first();
        return view('pages.ajaxmodal.GetSingleDetailsOfAddressBook', ['singleDetails' => $singleDetails]);
    }

    public function DeleteAddressBookContact(Request $request) {
        $id = $request->id;
        $deleteupdated = AddressBook::find(decrypt($request->id));
        $deleteupdated->delete();
    }

    public function checkAddressBookEmail(Request $request) {
        $user = Auth::user();
        $addressbookEmails = AddressBook::where('user_id', $user->id)->get();
        $emailList =[];
        foreach ($addressbookEmails as $email) {
            $emailList[] = $email['email'];
        } 
        if (in_array($request->email, $emailList)) {
            echo "false";
        } else {
           echo "true"; 
        }

    }

}
