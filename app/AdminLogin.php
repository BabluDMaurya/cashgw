<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//class AdminLogin extends Model
class AdminLogin extends Authenticatable
{
    
    use Notifiable;
    
    protected $guard = 'admin';
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
}
