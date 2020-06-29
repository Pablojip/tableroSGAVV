<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tema;

class SubTema extends Model
{
    public function temas()
    {
        return $this->belongsTo(Tema::class,'tema_id');
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
    public function scopeTema($query,$valor){

        if($valor)
            return $query->where('tema_id',$valor);
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
}
