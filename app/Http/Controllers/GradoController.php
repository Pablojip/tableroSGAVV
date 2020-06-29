<?php

namespace App\Http\Controllers;

use App\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
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
            $grado = $request->get('grado');
            $activo = $request->get('activo');
    
            $listados = Grado::orderBy('id','DESC')
                ->grado($grado)
                ->activo($activo)
                ->paginate(5);
            if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('grado._list')->with('listados', $listados)->render();
                    return response()->json($this->respuesta);
            }
            return view('grado.index',['listados' => $listados]);
           

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            if($request->ajax()){ 
                return $this->respuesta;
            }
            return view('grado.index',['listados' => null,'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('grado.create');
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
            if($this->ExistNombre($request->get('grado'))){
                $this->respuesta['mensaje'] = "El grado ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $Model = new Grado;
            $Model->grado                = $request->get('grado');
            $Model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos  del grado: ".$Model->grado;
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
            $Model = Grado::find($id);
            return view('grado.detail',['model' => $Model]);

        }catch(\Exception $e){
            return view('grado.detail',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
            $model = Grado::find($id);
            return view('grado.edit',[ 'model' => $model ]);

        }catch(\Exception $e){
            return view('grado.edit',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar el grado para la edición.";
                return $this->respuesta;
            }

            if($this->ExistNombre($request->get('grado'),$id)){
                $this->respuesta['mensaje'] = "El nombre ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $model = Grado::find($id);
            $model->grado               = $request->get('grado');
            $model->activo               = $request->get('activo') ?? 0;
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del grado: ".$model->grado;
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
     private function ExistNombre($nombre,$id=0){
        if($id != 0){
            return Grado::where('grado', '=', $nombre)->where('id','!=',$id)->exists();
        }
        return Grado::where('grado', '=', $nombre)->exists();
    }
}
