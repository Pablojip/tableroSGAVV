<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SubTema;
use App\Tema;

class SubTemaController extends Controller
{
    public $respuesta= array("valido" => false, "mensaje" =>"");
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getTemas(){
        
        $model = Tema::Where('activo',true)->pluck('nombre', 'id')->toArray();
        return $model;

    }

    public function index(Request $request)
    {
        try{
            $nombre = $request->get('nombre');
            $descripcion = $request->get('descripcion');
            $tema_id = $request->get('tema_id');
            $activo = $request->get('activo');
    
            $listados = SubTema::orderBy('id','DESC')
                ->nombre($nombre)
                ->descripcion($descripcion)
                ->tema($tema_id)
                ->activo($activo)
                ->paginate(5);
            if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('sub_tema._list')->with('listados', $listados)->render();
                    return response()->json($this->respuesta);
            }
            return view('sub_tema.index',['temas' => $this->getTemas(),'listados' => $listados]);
           

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            if($request->ajax()){ 
                return $this->respuesta;
            }
            return view('sub_tema.index',['listados' => null,'temas' => $this->getTemas(),'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sub_tema.create',['temas' => $this->getTemas()]);
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
            $model = new SubTema;
            $model->nombre                = $request->get('nombre');
            $model->descripcion           = $request->get('descripcion');
            $model->tema_id               = $request->get('tema_id');
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del sub tema: ".$model->nombre;
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
            $model = SubTema::find($id);
            return view('sub_tema.detail',['temas' => $this->getTemas(),'model' => $model]);

        }catch(\Exception $e){
            return view('sub_tema.detail',['temas' => $this->getTemas(),'model' => mull, 'errorMsj' => $e->getMessage() ]);
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
            $model = SubTema::find($id);
            return view('sub_tema.edit',['temas' => $this->getTemas(),'model' => $model]);

        }catch(\Exception $e){
            return view('sub_tema.edit',['temas' => $this->getTemas(),'model' => mull, 'errorMsj' => $e->getMessage() ]);
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
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar el sub tema para la edición.";
                return $this->respuesta;

            }

            if($this->ExistNombre($request->get('nombre'),$id)){
                $this->respuesta['mensaje'] = "El nombre ya existe por favor seleccione otro.";
                return $this->respuesta;

            }

            $model = SubTema::find($id);
            $model->nombre           = $request->get('nombre');
            $model->descripcion       = $request->get('descripcion');
            $model->tema_id        = $request->get('tema_id');
            $model->activo            = $request->get('activo') ?? 0;
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los datos del tema: ".$model->nombre;
            return $this->respuesta;

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();
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

    //meotodos
    public function ExistNombre($nombre,$id=0){
        if($id != 0){
            return SubTema::where('nombre', '=', $nombre)->where('id','!=',$id)->exists();
        }
        return SubTema::where('nombre', '=', $nombre)->exists();
    }

    
}
