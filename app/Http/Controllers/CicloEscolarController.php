<?php

namespace App\Http\Controllers;

use App\CicloEscolar;
use Illuminate\Http\Request;

class CicloEscolarController extends Controller
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
            $inicio = $request->get('inicio');
            $fin = $request->get('fin');
            $activo = $request->get('activo');
    
            $listados = CicloEscolar::orderBy('id','DESC')
                ->inicio($inicio)
                ->fin($fin)
                ->activo($activo)
                ->paginate(5);
            if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('ciclo_escolar._list')->with('listados', $listados)->render();
                    return response()->json($this->respuesta);
            }
            return view('ciclo_escolar.index',['listados' => $listados]);
           

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            if($request->ajax()){ 
                return $this->respuesta;
            }
            return view('ciclo_escolar.index',['listados' => null,'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ciclo_escolar.create');
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
            
            if($this->ExistNombre($request->get('inicio'),$request->get('fin'))){
                $this->respuesta['mensaje'] = "El ciclo escolar ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $Model = new CicloEscolar;
            $Model->inicio                = $request->get('inicio');
            $Model->fin           = $request->get('fin');
            $Model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos de l ciclo  escolar: ".$Model->nombreCompleto();
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
            $Model = CicloEscolar::find($id);
            return view('ciclo_escolar.detail',['model' => $Model]);

        }catch(\Exception $e){
            return view('ciclo_escolar.detail',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
            $model = CicloEscolar::find($id);
            return view('ciclo_escolar.edit',[ 'model' => $model ]);

        }catch(\Exception $e){
            return view('ciclo_escolar.edit',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar el ciclo  escolar para la edición.";
                return $this->respuesta;
            }

            if($this->ExistNombre($request->get('inicio'),$request->get('fin'),$id)){
                $this->respuesta['mensaje'] = "El ciclo escolar ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $model = CicloEscolar::find($id);
            $model->inicio               = $request->get('inicio');
            $model->fin          = $request->get('fin');
            $model->activo               = $request->get('activo') ?? 0;
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del  ciclo escolar: ".$model->nombreCompleto();
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
     private function ExistNombre($inicio,$fin,$id=0){
        if($id != 0){
            return CicloEscolar::where('inicio', '=', $inicio)->where('fin', '=', $fin)->where('id','!=',$id)->exists();
        }
        return CicloEscolar::where('inicio', '=', $inicio)->where('fin', '=', $fin)->exists();
    }
}
