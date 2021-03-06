<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Materia;

class MateriaController extends Controller
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
            $nombre = $request->get('nombre');
            $descripcion = $request->get('descripcion');
            $activo = $request->get('activo');
    
            $listados = Materia::orderBy('id','DESC')
                ->nombre($nombre)
                ->descripcion($descripcion)
                ->activo($activo)
                ->paginate(5);
            if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('materia._list')->with('listados', $listados)->render();
                    return response()->json($this->respuesta);
            }
            return view('materia.index',['listados' => $listados]);
           

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            if($request->ajax()){ 
                return $this->respuesta;
            }
            return view('materia.index',['listados' => null,'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materia.create');
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
            if($this->ExistNombre($request->get('nombre'))){
                $this->respuesta['mensaje'] = "El nombre ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $Model = new Materia;
            $Model->nombre                = $request->get('nombre');
            $Model->descripcion           = $request->get('descripcion');
            $Model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los de la materia: ".$Model->nombre;
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
            $Model = Materia::find($id);
            return view('materia.detail',['model' => $Model]);

        }catch(\Exception $e){
            return view('materia.detail',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
            $model = Materia::find($id);
            return view('materia.edit',[ 'model' => $model ]);

        }catch(\Exception $e){
            return view('materia.edit',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar la materia para la edición.";
                return $this->respuesta;
            }

            if($this->ExistNombre($request->get('nombre'),$id)){
                $this->respuesta['mensaje'] = "El nombre ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $model = Materia::find($id);
            $model->nombre               = $request->get('nombre');
            $model->descripcion          = $request->get('descripcion');
            $model->activo               = $request->get('activo') ?? 0;
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos de la materia: ".$model->nombre;
            return $this->respuesta;

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     //metodos necesariosw
     public function ExistNombre($nombre,$id=0){
        if($id != 0){
            return Materia::where('nombre', '=', $nombre)->where('id','!=',$id)->exists();
        }
        return Materia::where('nombre', '=', $nombre)->exists();
    }
    public function getIdByName($nombre){
        return Materia::where('nombre', '=', $nombre)->first()->id;
    }
}
