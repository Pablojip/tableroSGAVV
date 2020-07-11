<?php // Code within app\Helpers\Helper.php

use Illuminate\Support\Arr;

if (!function_exists('get_label_activo')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function get_label_activo($activo)
    {
        return $activo ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
    }
}
if (!function_exists('get_label_role')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function get_label_role($role_id,$nombre)
    {
        switch ($role_id) {
            case 1:
                return '<span class="label label-success">'.$nombre.'</span>';
            break;
            case 2:
                return '<span class="label label-info">'.$nombre.'</span>';
            break;
            case 3:
                return '<span class="label label-warning">'.$nombre.'</span>';
            break;
            default:
                return '<span class="label label-secondary">ninguno</span>';
            break;
        }
    }
}

if (!function_exists('str_random')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function str_random($length = 16)
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
		return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
	}
}
if (!function_exists('get_atribute')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function get_atribute($array,$atribute)
	{
        return Arr::get($array, $atribute);
	}
}

if (!function_exists('created_model_bitacora')) {

    function created_model_bitacora($modelNew,$modelOld,$created,$niceNames)
	{
        $data = [
            'tabla' => $modelNew->getTable(),
            'tabla_publico' => Arr::get($niceNames,$modelNew->getTable()),
            'registro_id' => $modelNew->id,
            'created' => $created,
            'cambios' => []
        ];
        $data['cambios'] = get_array_create($modelNew->attributesToArray(),$modelOld,$niceNames);
        Event::dispatch('bitacora',array($data));
           

	}
}
if (!function_exists('get_array_cambios')) {

    function get_array_create($modelNew,$modelOld,$niceNames)
	{
        $datos=[];
        foreach($modelNew  as $attribute => $value){
            if($attribute != 'updated_at' && $attribute != 'remember_token'
            && $attribute != 'id' && $attribute != 'created_at'){

                $campo = get_atribute($niceNames,$attribute);
                $valueOld=null;
                $valueNew=null;
                if(isset($modelOld[$attribute])){
                    $valueOld = $modelOld[$attribute];
                }
               if(isset($modelNew[$attribute])){
                    $valueNew = $modelNew[$attribute];
                }
                $updated=[
                    'campo_anterior'=> $valueOld, //->getOriginal($attribute),
                    'campo_nuevo'=> $valueNew,
                    'nombre_campo'=> $campo,
                    'es_modificado' => $valueOld != $valueNew ? true : false
                ];
                array_push($datos, $updated);
            }
        }
        return $datos;
	}
}





