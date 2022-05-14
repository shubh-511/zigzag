<?php

namespace App;
use App\Country;
use App\State;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    
    public function user()
    {
       return $this->belongsTo('App\User','user_id','id');
    }
    
    public function order_customisations()
    {
       return $this->hasMany('App\OrderCustomisation','order_detail_id','id');
    }
    
}