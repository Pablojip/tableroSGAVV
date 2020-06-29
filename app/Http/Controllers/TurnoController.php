<?php

namespace App\Http\Controllers;

use App\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
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
            $turno = $request->get('turno');
            $activo = $request->get('activo');
    
            $listados = Turno::orderBy('id','DESC')
                ->turno($turno)
                ->activo($activo)
                ->paginate(5);
            if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('turno._list')->with('listados', $listados)->render();
                    return response()->json($this->respuesta);
            }
            return view('turno.index',['listados' => $listados]);
           

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            if($request->ajax()){ 
                return $this->respuesta;
            }
            return view('turno.index',['listados' => null,'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('turno.create');
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
            if($this->ExistNombre($request->get('turno'))){
                $this->respuesta['mensaje'] = "El turno ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $Model = new Turno;
            $Model->turno                = $request->get('turno');
            $Model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos  del turno: ".$Model->turno;
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
            $Model = Turno::find($id);
            return view('turno.detail',['model' => $Model]);

        }catch(\Exception $e){
            return view('turno.detail',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
            $model = turno::find($id);
            return view('turno.edit',[ 'model' => $model ]);

        }catch(\Exception $e){
            return view('turno.edit',['model' => mull, 'errorMsj' => $e->getMessage() ]);
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
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar el turno para la edición.";
                return $this->respuesta;
            }

            if($this->ExistNombre($request->get('turno'),$id)){
                $this->respuesta['mensaje'] = "El nombre ya existe por favor seleccione otro.";
                return $this->respuesta;
            }

            $model = Turno::find($id);
            $model->turno               = $request->get('turno');
            $model->activo               = $request->get('activo') ?? 0;
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del turno: ".$model->turno;
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
            return Turno::where('turno', '=', $nombre)->where('id','!=',$id)->exists();
        }
        return Turno::where('turno', '=', $nombre)->exists();
    }
}
