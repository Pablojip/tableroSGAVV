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

    public $niceNames= [
        'inicio' => 'inicio',
        'fin' => 'fin',
        'activo' => 'activo',
        'ciclo_escolars' => 'Ciclo escolar '//tabla_publico
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
