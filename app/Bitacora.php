<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{


    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    //scope Query
    public function scopeModulo($query,$valor){

        if($valor)
            return $query->where('tabla_publico','LIKE',"%$valor%");
    }
    public function scopeFechainicio($query,$valor){

        if($valor)
            return $query->where('created_at','>=',$valor." 01:00:00");
    }
    public function scopeFechafin($query,$valor){

        if($valor)
            return $query->where('created_at','<=',$valor." 23:59:59");
    }
    public function accion(){

        if($this->nuevo){
            return '<span class="text-success">Creacion de registro.</span>';
        }
        if($this->editar){
            return '<span class="text-warning">Edición de registro.</span>';
        }
    }
    public function usuarioRealizo(){

        if(isset($this->users)){
            return "<span class='text-danger'>{$this->users->nombreCompleto()}</span>";
        }else{
            return "<span class='text-info'>Sistema.</span>";
        }
    }
    public function fechaFormato(){
        return strftime("%A, %d de %B de %Y <br/>Hora: %I:%M:%S %p", strtotime($this->created_at));
    }
}
