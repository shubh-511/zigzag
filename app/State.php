<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    public function country(){
       return $this->belongsTo('App\Country');//,'country_id','id');     
    } 
    public function city()
    {
    return $this->hasMany('App\City');
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
