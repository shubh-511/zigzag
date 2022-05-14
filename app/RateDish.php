<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateDish extends Model
{
    protected $table = 'dishes_rating';
    
    public function user()
    {
       return $this->belongsTo('App\User','user_id','id');    
    }
    
    public function dish()
    {
       return $this->belongsTo('App\Product','dish_id','id');    
    }
}
