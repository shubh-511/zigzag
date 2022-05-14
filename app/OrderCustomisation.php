<?php

namespace App;
use App\Country;
use App\State;
use Illuminate\Database\Eloquent\Model;

class OrderCustomisation extends Model
{
    protected $table = 'order_customizations';
    public function user()
    {
       return $this->belongsTo('App\User','user_id','id');
    }
    
    public function dishes(){
       return $this->belongsTo('App\Product','dish_id','id');    
    }
}