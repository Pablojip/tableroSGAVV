<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


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
    public function GetRoleSpan(){
        switch ($this->roles->id) {
            case 1:
                    return '<span class="label label-success">'.$this->roles->nombre.'</span>';
                break;
                case 2:
                    return '<span class="label label-info">'.$this->roles->nombre.'</span>';
                break;
                case 3:
                    return '<span class="label label-warning">'.$this->roles->nombre.'</span>';
                break;
            
            default:
                return '<span class="label label-secondary">ninguno</span>';
                break;
        }
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
}


