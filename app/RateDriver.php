<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateDriver extends Model
{
    protected $table = 'driver_rating';
    
    public function user()
    {
       return $this->belongsTo('App\User','user_id','id');    
    }
    
    public function driver()
    {
       return $this->belongsTo('App\User','driver_id','id');    
    }
}