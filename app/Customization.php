<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    protected $table = 'customization';
    
    public function provider(){
        return $this->belongsTo('App\User','provider_id','id');     
    }
    
    public function customise(){
        return $this->belongsTo('App\DishCustomisation','cutomisation','id');     
    }
    
    
     
}
