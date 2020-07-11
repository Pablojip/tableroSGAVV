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
    public $niceNames= [
        'nombre' => 'nombre',
        'descripcion' => 'descripción',
        'activo' => 'activo',
        'tema_id' => 'tema',
        'sub_temas' => 'Sub tema '//tabla_publico
    ];
    //bitacora
    public static function boot() {

        parent::boot();
        static::created(function($model) {
            //relaciones
            $model->tema_id =  $model->temas->nombre;
            created_model_bitacora($model,null,1,$model->niceNames);
        });
        static::updated(function ($model) {
            $modelOld = $model->getOriginal();
            $change = $model->getChanges();
            //relaciones
            $modelOld['tema_id'] = Tema::find($modelOld['tema_id'])->nombre;
            $model->tema_id =  $model->temas->nombre;
            $modelOld['activo'] =  get_label_activo($modelOld['activo']);
            $model->activo =  get_label_activo($model->activo);
            created_model_bitacora($model,$modelOld,2,$model->niceNames);
        });

    }
}
