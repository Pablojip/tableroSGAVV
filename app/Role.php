<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    public function getRoleSpan(){
        return  get_label_role($this->id,$this->nombre);
    }
    //Relacion a usuarios
   public function users()
    {
        return $this->hasMany('App\User');
    }
}
