<?php

namespace App\Http\Controllers;

use App\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
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
            $matricula          = $request->get('matricula');
            $nombres          = $request->get('nombres');
            $apellido_paterno = $request->get('apellido_paterno');
            $apellido_materno = $request->get('apellido_materno');
            $activo           = $request->get('activo');
    
            $listados = Alumno::orderBy('id','DESC')
                ->matricula($matricula)
                ->nombres($nombres)
                ->apellidopaterno($apellido_paterno)
                ->apellidomaterno($apellido_materno)
                ->activo($activo)
                ->paginate(5);
            if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('alumno._list')->with('listados', $listados)->render();
                    return response()->json($this->respuesta);
            }
            return view('alumno.index',['listados' => $listados]);
           

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            if($request->ajax()){ 
                return $this->respuesta;
            }
            return view('alumno.index',['listados' => null,'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumno.create');
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
            if($this->ExistMatricula($request->get('matricula'))){
                $this->respuesta['mensaje'] = "La matricula ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $Model = new Alumno;
            $Model->matricula                    = $request->get('matricula');
            $Model->nombres                    = $request->get('nombres');
            $Model->apellido_paterno           = $request->get('apellido_paterno');
            $Model->apellido_materno           = $request->get('apellido_materno');
            $Model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del alumno: ".$Model->nombrecompleto();
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
            $Model = Alumno::find($id);
            return view('alumno.detail',['model' => $Model]);

        }catch(\Exception $e){
            return view('alumno.detail',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
            $model = Alumno::find($id);
            return view('alumno.edit',[ 'model' => $model ]);

        }catch(\Exception $e){
            return view('alumno.edit',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar al alumno para la edición.";
                return $this->respuesta;
            }

            if($this->ExistMatricula($request->get('matricula'),$id)){
                $this->respuesta['mensaje'] = "La matricula ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $model = Alumno::find($id);
            $model->matricula                 = $request->get('matricula');
            $model->nombres                   = $request->get('nombres');
            $model->apellido_paterno          = $request->get('apellido_paterno');
            $model->apellido_materno          = $request->get('apellido_materno');
            $model->activo                    = $request->get('activo') ?? 0;
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del alumno: ".$model->nombreCompleto();
            return $this->respuesta;

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
        }
    }

     //metodos necesariosw
     public function ExistMatricula($matricula,$id=0){
        if($id != 0){
            return Alumno::where('matricula', '=', $matricula)->where('id','!=',$id)->exists();
        }
        return Alumno::where('matricula', '=', $matricula)->exists();
    }
}
