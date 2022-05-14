<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    public function parent_page() 
    {
      return $this->belongsTo('\App\Page','parent_id' ,'id');
     // return $this->belongsTo('App\Models\Menu','parent_menu_id');
    }
    public function banners()
  	 {
  	 	return $this->hasMany('App\Banner');
  	 }
  	  public function smartblocks()
  	 {
  	 	return $this->hasMany('App\Smartblock');
  	 }
}
