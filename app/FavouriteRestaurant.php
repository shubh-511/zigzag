<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class FavouriteRestaurant extends Model
{
   //protected $table = 'providers_menus';
    public function providers()
    {
        return $this->belongsTo('App\User','provider_id','id');     
    }
    
}