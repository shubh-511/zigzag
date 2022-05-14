<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DishCustomisation extends Model
{
    protected $table = 'dish_customization';
    
    public function dish()
    {
        return $this->belongsTo('App\Product','product_id','id');     
    }
    
    public function customization()
    {
        return $this->belongsTo('App\Customization','cutomisation','id');     
    }
    
     
}
