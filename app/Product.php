<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    public function product_category(){
        return $this->belongsTo('App\ProvidersMenus','product_cat_id','id');     
    }
    
    public function unit(){
        return $this->belongsTo('App\Unit','unit_id','id');     
    }
    // getting provider detail
    public function addedby(){
        return $this->belongsTo('App\User','added_by','id');     
    }
     
}
