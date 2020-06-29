<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //


    //Relacion a usuarios
   public function users()
    {
        return $this->hasMany('App\User');
    }
}
