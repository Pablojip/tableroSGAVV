<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Materia;

class Tema extends Model
{
    
    public function materias()
    {
        return $this->belongsTo(Materia::class,'materia_id');
    }

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
            return $query->where('descripcion','LIKE',"%$valor%");
    }
    public function scopeMateria($query,$valor){

        if($valor)
            return $query->where('materia_id',$valor);
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
}
