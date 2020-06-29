<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CicloEscolar extends Model
{
    
    public function nombreCompleto(){
        return $this->inicio. " - ".$this->fin;
    }

    public function Activo(){
        return  get_label_activo($this->activo);
    }

     //scope Query
     public function scopeInicio($query,$valor){

        if($valor)
            return $query->where('inicio',$valor);
    }
    public function scopeFin($query,$valor){

        if($valor)
            return $query->where('fin',$valor);
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
}
