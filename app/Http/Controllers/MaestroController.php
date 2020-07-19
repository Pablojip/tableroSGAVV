<?php

namespace App\Http\Controllers;

use App\Maestro;
use Illuminate\Http\Request;

class MaestroController extends Controller
{
    public $respuesta= array("valido" => false, "mensaje" =>"");
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $clave            = $request->get('clave');
            $nombres          = $request->get('nombres');
            $apellido_paterno = $request->get('apellido_paterno');
            $apellido_materno = $request->get('apellido_materno');
            $activo           = $request->get('activo');
    
            $listados = Maestro::orderBy('id','DESC')
                ->clave($clave)
                ->nombres($nombres)
                ->apellidopaterno($apellido_paterno)
                ->apellidomaterno($apellido_materno)
                ->activo($activo)
                ->paginate(5);
            if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('maestro._list')->with('listados', $listados)->render();
                    return response()->json($this->respuesta);
            }
            return view('maestro.index',['listados' => $listados]);
           

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            if($request->ajax()){ 
                return $this->respuesta;
            }
            return view('maestro.index',['listados' => null,'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('maestro.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            if($this->Existclave($request->get('clave'))){
                $this->respuesta['mensaje'] = "La clave ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $Model = new Maestro;
            $Model->clave                    = $request->get('clave');
            $Model->nombres                    = $request->get('nombres');
            $Model->apellido_paterno           = $request->get('apellido_paterno');
            $Model->apellido_materno           = $request->get('apellido_materno');
            $Model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del maestro: ".$Model->nombrecompleto();
            return $this->respuesta;

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $Model = Maestro::find($id);
            return view('maestro.detail',['model' => $Model]);

        }catch(\Exception $e){
            return view('maestro.detail',['model' => mull, 'errorMsj' => $e->getMessage() ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $model = Maestro::find($id);
            return view('maestro.edit',[ 'model' => $model ]);

        }catch(\Exception $e){
            return view('maestro.edit',['model' => mull, 'errorMsj' => $e->getMessage() ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $id = $request->get('id');
            if(!$id){
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar al maestro para la edición.";
                return $this->respuesta;
            }

            if($this->Existclave($request->get('clave'),$id)){
                $this->respuesta['mensaje'] = "La clave ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $model = Maestro::find($id);
            $model->clave                 = $request->get('clave');
            $model->nombres                   = $request->get('nombres');
            $model->apellido_paterno          = $request->get('apellido_paterno');
            $model->apellido_materno          = $request->get('apellido_materno');
            $model->activo                    = $request->get('activo') ?? 0;
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del maestro: ".$model->nombreCompleto();
            return $this->respuesta;

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
        }
    }

     //metodos necesariosw
     public function Existclave($clave,$id=0){
        if($id != 0){
            return Maestro::where('clave', '=', $clave)->where('id','!=',$id)->exists();
        }
        return Maestro::where('clave', '=', $clave)->exists();
    }
}
