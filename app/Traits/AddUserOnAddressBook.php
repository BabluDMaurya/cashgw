<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use App\AddressBook;
trait AddUserOnAddressBook{
    public function AddUserOnMyAddressbook($email){
    $user = Auth::user();
    $addbookdata = AddressBook::where('user_id',$user->id)->where('email','LIKE','%'.$email.'%')->get();
        if(count($addbookdata) < 1){
            AddressBook::create([
                'user_id'=>$user->id,
                'email'=>$email,
            ]);
            return True;
        }else{
            return False;
        }
    }
}                  