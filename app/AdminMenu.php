<?php

namespace App;
use App\AdminMenu;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    //
     public function parent_menu() {
      return $this->belongsTo('\App\AdminMenu','parent_menu_id' ,'id');
     // return $this->belongsTo('App\Models\Menu','parent_menu_id');
  }
}
