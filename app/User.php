<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Event;


class User extends Authenticatable
{
 
    use Notifiable;

    /**
     * The attributaasdasdes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relacion a roles
    public function roles()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    public function nombreCompleto(){
        return $this->nombres. " ".$this->apellido_paterno." ".$this->apellido_materno;
    }
    public function hasRole($role){
        return $this->roles->nombre == $role ? true : false;
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
    public function scopeEmail($query,$valor){

        if($valor)
            return $query->where('email','LIKE',"%$valor%");
    }
    public function scopeRol($query,$valor){

        if($valor)
            return $query->where('role_id',$valor);
    }
    public function scopeActivo($query,$valor){

        if($valor)
            return $query->where('activo',$valor);
    }

    public $niceNames= [
        'email' => 'correo electronico',
        'nombres' => 'nombres',
        'apellido_paterno' => 'Apellido paterno',
        'apellido_materno' => 'apellido materno',
        'password' => 'contraseña',
        'cambioPassword' => 'proceso de cambio de contraseña',
        'codigoConfirmacionEmail' => 'codigo para el proceso de confirmar correo',
        'codigoConfirmacionPassword' => 'codigo para el proceso de cambio de contraseña',
        'activo' => 'activo',
        'role_id' => 'Roles',
        'users' => 'Usuario '//tabla_publico
    ];
    //bitacora
    public static function boot() {

        parent::boot();
        static::created(function($model) {
            //relaciones
            $model->role_id =  $model->roles->GetRoleSpan();
            created_model_bitacora($model,null,1,$model->niceNames);
        });
        static::updated(function ($model) {
            $modelOld = $model->getOriginal();
            $change = $model->getChanges();
            //relaciones
            $modelOld['role_id'] = Role::find($modelOld['role_id'])->GetRoleSpan();
            $model->role_id =  $model->roles->GetRoleSpan();
            $modelOld['activo'] =  get_label_activo($modelOld['activo']);
            $model->activo =  get_label_activo($model->activo);
           

            created_model_bitacora($model,$modelOld,2,$model->niceNames);
        });

    }
}


