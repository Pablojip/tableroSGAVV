<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{





    public function Activo(){
        return  get_label_activo($this->activo);
    }
    
     //scope Query
    public function scopeNombre($query,$valor){

        if($valor)
            return $query->where('nombre','LIKE',"%$valor%");
    }
    public function scopeDescripcion($query,$valor){

        if($valor)
            return $query->where('desscripcion','LIKE',"%$valor%");
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
}
