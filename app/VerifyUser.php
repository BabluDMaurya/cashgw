<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    } 
    public function business()
    {
        return $this->belongsTo('App\Business', 'user_id','user_id');
    }
    public function businesskyc()
    {
        return $this->belongsTo('App\BusinessKyc', 'user_id','user_id');
    }
    public function individual()
    {
        return $this->belongsTo('App\Individual', 'user_id','user_id');
    }
    public function individualkyc()
    {
        return $this->belongsTo('App\IndividualKyc', 'user_id','user_id');
    }
}
