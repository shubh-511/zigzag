<?php

namespace App;
use App\Country;
use App\State;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
   public function user(){
       return $this->belongsTo('App\User','user_id','id');
    }
    
}