<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    public function Activo(){
        return  get_label_activo($this->activo);
    }

     //scope Query
     public function scopeTurno($query,$valor){

        if($valor)
            return $query->where('turno',"LIKE","%$valor%");
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
}
