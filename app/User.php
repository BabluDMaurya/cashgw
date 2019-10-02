<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function individualcreadit(){
        return $this->hasMany(IndividualCreadit::class);
    }    
    public function individualdebit(){
        return $this->hasMany(IndividualDebit::class);
    }
    public function individualtotaltran(){
        return $this->hasMany(IndividualTotalTransaction::class);
    }
    
    public function businesscreadit(){
        return $this->hasMany(BusinessCreadit::class);
    }    
    public function businessdebit(){
        return $this->hasMany(BusinessDebit::class);
    }
    public function businesstotaltran(){
        return $this->hasMany(BusinessTotalTransaction::class);
    }
    public function cCTransaction(){
        return $this->hasMany(CurrencyConvertionTransaction::class);
    }
    
    public function requestMoneyFromUser(){
        return $this->hasMany(RequestForMoneyToUser::class);
    }
    public function balance(){
        return $this->hasMany(AmountBalanceMaster::class);
    }
    public function master(){
        return $this->hasOne(Master::class);
    }
    public function business(){
        return $this->hasOne(Business::class);
    } 
    public function businesskyc(){
        return $this->hasOne(BusinessKyc::class);
    }
    public function individual() {
        return $this->hasOne(Individual::class);
    }
    public function individualkyc() {
        return $this->hasOne(IndividualKyc::class);
    }
    public function changeprimaryaddressrequest() {
        return $this->hasOne(ChangePrimaryAddressRequest::class);
    }    
    public function verifyUser(){
        return $this->hasOne('App\VerifyUser');
    }    
    public function getAuthPassword(){
        return $this->password;
    }  
    
    public function addressbook(){
        return $this->hasMany(AddressBook::class);
    }
}
