<?php

namespace App;
use App\Country;
use App\State;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
       return $this->belongsTo('App\User','user_id','id');
    }
    
    public function provider()
    {
       return $this->belongsTo('App\User','provider_id','id');
    }
    
    public function order_detail()
    {
       return $this->hasMany('App\OrderDetail','order_id','id');
    }
    
    public function driver()
    {
       return $this->belongsTo('App\User','assign_driver_id','id');
    }
    
    
    
}