<?php

namespace App;
use App\Country;
use App\State;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
   public function user(){
       return $this->belongsTo('App\User','user_id','id');
    }
    
    public function dishes(){
       return $this->belongsTo('App\Product','dish_id','id');    
    }
    
    public function provider(){
       return $this->belongsTo('App\User','provider_id','id');    
    }
}