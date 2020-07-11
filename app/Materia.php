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

    public $niceNames= [
        'nombre' => 'nombre',
        'descripcion' => 'descripción',
        'activo' => 'activo',
        'materias' => 'Materia '//tabla_publico
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
