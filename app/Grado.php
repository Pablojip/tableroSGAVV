<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    public function Activo(){
        return  get_label_activo($this->activo);
    }

     //scope Query
     public function scopeGrado($query,$valor){

        if($valor)
            return $query->where('grado',$valor);
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
}
