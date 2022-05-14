<?php

namespace App;
use App\Country;
use App\State;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //

    public function country(){
       return $this->belongsTo('App\Country','country_id');//,'country_id','id');     
    } 
    public function state(){
       return $this->belongsTo('App\State','state_id','id');//,'state_id','id');     
    }
    public function users()
    {
    return $this->hasMany('App\User');
    } 
    public function address()
    {
    return $this->hasMany('App\UserAddress');
    }
    

}
