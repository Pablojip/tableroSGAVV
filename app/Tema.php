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
    public $niceNames= [
        'nombre' => 'nombre',
        'descripcion' => 'descripción',
        'activo' => 'activo',
        'materia_id' => 'materia',
        'temas' => 'Tema '//tabla_publico
    ];
    //bitacora
    public static function boot() {

        parent::boot();
        static::created(function($model) {
            //relaciones
            $model->materia_id =  $model->materias->nombre;
            created_model_bitacora($model,null,1,$model->niceNames);
        });
        static::updated(function ($model) {
            $modelOld = $model->getOriginal();
            $change = $model->getChanges();
            //relaciones
            $modelOld['materia_id'] = Materia::find($modelOld['materia_id'])->nombre;
            $model->materia_id =  $model->materias->nombre;
            $modelOld['activo'] =  get_label_activo($modelOld['activo']);
            $model->activo =  get_label_activo($model->activo);
            created_model_bitacora($model,$modelOld,2,$model->niceNames);
        });

    }
}
