<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    public function nombreCompleto(){
        return $this->nombres. " ".$this->apellido_paterno." ".$this->apellido_materno;
    }

    public function Activo(){
        return  get_label_activo($this->activo);
    }

     //scope Query
    public function scopeNombres($query,$valor){

        if($valor)
            return $query->where('nombres','LIKE',"%$valor%");
    }
    public function scopeApellidopaterno($query,$valor){

        if($valor)
            return $query->where('apellido_paterno','LIKE',"%$valor%");
    }

    public function scopeApellidomaterno($query,$valor){

        if($valor)
            return $query->where('apellido_materno','LIKE',"%$valor%");
    }
    public function scopeMatricula($query,$valor){

        if($valor)
            return $query->where('matricula','LIKE',"%$valor%");
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }
    public $niceNames= [
        'nombre' => 'nombre',
        'nombres' => 'nombres',
        'apellido_paterno' => 'Apellido paterno',
        'apellido_materno' => 'apellido materno',
        'matricula' => 'matricula',
        'activo' => 'activo',
        'alumnos' => 'Alumno' //tabla_publico
    ];
    //bitacora
    public static function boot() {

        parent::boot();
        static::created(function($model) {
            //relaciones
            created_model_bitacora($model,null,1,$model->niceNames);
        });
        static::updated(function ($model) {
            $modelOld = $model->getOriginal();
            $change = $model->getChanges();
            //relaciones
            $modelOld['activo'] =  get_label_activo($modelOld['activo']);
            $model->activo =  get_label_activo($model->activo);
            created_model_bitacora($model,$modelOld,2,$model->niceNames);
        });

    }
}
