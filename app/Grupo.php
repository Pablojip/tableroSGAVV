<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    public function Activo(){
        return  get_label_activo($this->activo);
    }

     //scope Query
     public function scopeGrupo($query,$valor){

        if($valor)
            return $query->where('grupo',$valor);
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
}
