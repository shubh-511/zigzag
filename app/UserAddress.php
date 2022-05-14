<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //
    protected $table = 'user_addresses';
    public function state(){
        return $this->belongsTo('App\State','state_id','id');     
    }
    public function city(){
        return $this->belongsTo('App\City','city_id','id');     
    }
    public function users(){
        return $this->belongsTo('App\User','user_id','id');     
    }
}
