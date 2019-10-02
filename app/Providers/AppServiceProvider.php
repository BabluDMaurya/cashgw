<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;
use App\Traits\UniqueEmailTrait;
use App\User;
use Hash;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    use UniqueEmailTrait;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(256);
        //check unique Email 
         Validator::extend('uniqueemail', function ($attribute, $value, $parameters, $validator) {
            if(!in_array($value, $this->checkUniqueEmail())){
                     return true;
                }else{
                    return false;
                }
        });        
        Validator::replacer('uniqueemail', function($message, $attribute, $rule, $parameters) {
            return str_replace($message, "Email already exists", $message);
        });
        
        // check current password        
        Validator::extend('currentpassword', function ($attribute, $value, $parameters, $validator) {
            $current_password = Auth::User()->password;           
                if(Hash::check($value, $current_password)){
                   return true; 
                }else{
                    return false;
                }
            
        });        
        Validator::replacer('currentpassword', function($message, $attribute, $rule, $parameters) {
            return str_replace($message, "Please enter correct current password", $message);
        });
        
        // check password        
        Validator::extend('passwordcheck', function ($attribute, $value, $parameters, $validator) {
            $regex = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$^";      
                if(preg_match($regex, $value)) {
                      return true; 
                }else{
                    return false;
                }
            
        });        
        Validator::replacer('passwordcheck', function($message, $attribute, $rule, $parameters) {
            return str_replace($message, "Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number and one special character", $message);
        });
        
        // check email domain        
        Validator::extend('emaildomain', function ($attribute, $value, $parameters, $validator) {
            $regex = "/^[A-Za-z0-9\.]*@(wdipl|yopmail|gmail)[.](com)$/";      
                if(preg_match($regex, $value)) {
                      return true; 
                }else{
                    return false;
                }
            
        });        
        Validator::replacer('emaildomain', function($message, $attribute, $rule, $parameters) {
            return str_replace($message, "We appreciate your interest on using our System. However at the moment we offer this service only to wdipl.com or gmail.com or yopmail.com!", $message);
        });
        
        // check email domain        
        Validator::extend('emailformate', function ($attribute, $value, $parameters, $validator) {
            $regex = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/";      
                if(preg_match($regex, $value)) {
                      return true; 
                }else{
                    return false;
                }
            
        });        
        Validator::replacer('emailformate', function($message, $attribute, $rule, $parameters) {
            return str_replace($message, "Please enter Correct Email formate Like: example@domain.com", $message);
        });
        // check login email 
        Validator::extend('itselfloginemail', function ($attribute, $value, $parameters, $validator) {            
            $user = Auth::user();        
                if($user->email == $value) {
                      return false; 
                }else{
                    return true;
                }            
        });        
        Validator::replacer('itselfloginemail', function($message, $attribute, $rule, $parameters) {
            return str_replace($message, "Could not perform action itself", $message);
        });
    }
}
