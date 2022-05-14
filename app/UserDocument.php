<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    //
    protected $table = 'driver_documents';
    public function users(){
        return $this->belongsTo('App\User','user_id','id');     
    } 
}
