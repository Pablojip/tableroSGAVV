<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use Excel;
use App\User;
use App\Grupo;
use App\Tema;
use App\Turno;
use App\SubTema;
use App\Materia;
use App\Maestro;
use App\Alumno;
use App\Imports\GrupoImport;
use App\Imports\TurnoImport;
use App\Imports\TemaImport;
use App\Imports\SubTemaImport;
use App\Imports\MateriaImport;
use App\Imports\MaestroImport;
use App\Imports\AlumnoImport;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Exports\UsersExport;

class ExcelController extends Controller 
{
    public $respuesta= array("valido" => false, "mensaje" =>"","Errores" => false, "view_Excel" => "" );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $dataHeader = [];
    protected $catologos = [
        1 => "Turnos",
        2 => "Temas",
        3 => "Sub tema",
        4 => "Materias",
        5 => "Maestro",
        6 => "Grupo",
        7 => "Grado",
        8 => "Alumno",
    ];
    public function index()
    {
        return view('excel.index',['catologos' => $this->catologos]);
    }
    
    public function getTemplate($catalogo_id){

        try{
            $docuemnto = $this->getTitulos($catalogo_id);
            return Excel::download(new UsersExport($this->dataHeader), "${docuemnto}.xlsx");

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();
           return view('excel.index',['catologos' => $this->catologos,'errorMsj' => $this->respuesta['mensaje']]);
        }
    }

    function import(Request $request){

        try{

            $validator = Validator::make($request->all(), [
                'archivo' => 'required|mimes:xls,xlsx',
                'id' => 'required'
			],[
                'id.required' => 'Seleccione un catalogo porfavor.',
	        	'archivo.required' => 'El archivo es requerido.',
	            'archivo.mimes' => 'Formato incorrecto, por favor vuelva a subir el archivo.'
            ]);
            if ($validator->fails()){
				$this->respuesta['mensaje'] = $validator->errors()->first();
				return $this->respuesta;
            }
            $catologo=$request->get('id');
            $path1 = $request->file('archivo')->store('temp'); 
            $path=storage_path('app').'/'.$path1; 
            //$data = Excel::import(new GrupoImport,$path);
            switch ($catologo) {
                case 1: //Turnos
                      //$importar = new GrupoImport();
                      $this->ImportarTurno($path);
                      return $this->respuesta;
                    break;
                case 2: //Temas
                    $this->ImportarTema($path);
                    return $this->respuesta;
                    break;
                case 3: //Sub tema
                    $this->ImportarSubTema($path);
                    return $this->respuesta;
                    break;
                case 4: //Materias
                    $this->ImportarMateria($path);
                    return $this->respuesta;
                break;
                case 5: //Maestro
                    $this->ImportarMaestro($path);
                    return $this->respuesta;
                    break;
                case 6: //Grupo
                    //$importar = new GrupoImport();
                    $this->ImportarGrupo($path);
                    return $this->respuesta;
                    break;
                case 7: //Grado
                    return "Grados";
                break;
                case 8: //Alumno
                    $this->ImportarAlumno($path);
                    return $this->respuesta;
                    return "Alumno";
                break;
                default:
                    return "Desconocido";
                break;
            }

        }catch (\Exception $e) {
		    $this->respuesta['mensaje'] = "Ocurrio un error al momento de comprobar los datos, Error: ".$e->getMessage();
            return $this->respuesta;
		}
    }

      //Maestros
      private function ImportarAlumno($path){
        try{
            $totalSave=0;
            $totalColumnas=4;
            $headers= ['matricula','Nombres','Apellido paterno','Apellido materno'];
            $collection = Excel::toCollection(new AlumnoImport, $path);
            $rows = $this->getCollection($collection);
            //dd(count($rows));
            $Errores = false;
            if(count($rows) > 0){
                //validamos
                foreach($rows as &$row){
                    $contarColumnas = 0;
                    foreach($row['Datos'] as &$columnas){
                        $OnlyErrorPerColum = false;
                        if($totalColumnas == $contarColumnas){
                             break;
                        }
                        $contarColumnas++;
                        $Controlador = new AlumnoController;
                        //Clave
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 1) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "La clave es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if(($Controlador->ExistMatricula($columnas['columna']) && $contarColumnas == 1) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "La clave ".$columnas['columna']." ya existe por favor de remplazar o remover.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Nombre
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 2) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "El nombre es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if ((!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $columnas['columna'])  && $contarColumnas == 2) && !$OnlyErrorPerColum) {
                            $columnas['errores_msg'] = "El nombre no es valido, solo letras con espacios.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Apellido paterno
                        if ((!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $columnas['columna'])  && $contarColumnas == 3) && !$OnlyErrorPerColum) {
                            $columnas['errores_msg'] = "El apellido paterno no es valido, solo letras con espacios.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Apellido materno
                        if ((!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $columnas['columna'])  && $contarColumnas == 4) && !$OnlyErrorPerColum) {
                            $columnas['errores_msg'] = "El apellido materno no es valido, solo letras con espacios.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                       
                    }
                }
                if($Errores){
                    $this->respuesta['Errores'] = true;
                    $this->respuesta['view_Excel']  = view('excel._list')->with('listados', $rows)->with('headers',$headers)->render();
                }else{
                    foreach($rows as &$row){
                        $contarColumnas = 0;
                        $model = new Alumno();
                        foreach($row['Datos'] as &$columnas){
                            $OnlyErrorPerColum = false;
                            if($totalColumnas == $contarColumnas){
                                 break;
                            }
                            $contarColumnas++;

                            if($contarColumnas == 1){
                                $model->matricula = $columnas['columna'];
                            }
                            if($contarColumnas == 2){
                                $model->nombres = $columnas['columna'];
                            }
                            if($contarColumnas == 3){
                                $model->apellido_paterno = $columnas['columna'];
                            }
                            if($contarColumnas == 4){
                                $model->apellido_materno = $columnas['columna'];
                            }
                        }
                        $model->save();
                        $totalSave++;
                    }
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje'] = "Se guardaron ${totalSave} registo(s) en maestros";
                }
            }else{
                $this->respuesta['mensaje'] = "no hay valores en el documento, por favor revisar";
            }

        }catch (\Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();
            return $this->respuesta;
		}
        
    }

     //Maestros
     private function ImportarMaestro($path){
        try{
            $totalSave=0;
            $totalColumnas=4;
            $headers= ['Clave','Nombres','Apellido paterno','Apellido materno'];
            $collection = Excel::toCollection(new MaestroImport, $path);
            $rows = $this->getCollection($collection);
            //dd(count($rows));
            $Errores = false;
            if(count($rows) > 0){
                //validamos
                foreach($rows as &$row){
                    $contarColumnas = 0;
                    foreach($row['Datos'] as &$columnas){
                        $OnlyErrorPerColum = false;
                        if($totalColumnas == $contarColumnas){
                             break;
                        }
                        $contarColumnas++;
                        $Controlador = new MaestroController;
                        //Clave
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 1) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "La clave es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if(($Controlador->Existclave($columnas['columna']) && $contarColumnas == 1) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "La clave ".$columnas['columna']." ya existe por favor de remplazar o remover.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Nombre
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 2) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "El nombre es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if ((!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $columnas['columna'])  && $contarColumnas == 2) && !$OnlyErrorPerColum) {
                            $columnas['errores_msg'] = "El nombre no es valido, solo letras con espacios.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Apellido paterno
                        if ((!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $columnas['columna'])  && $contarColumnas == 3) && !$OnlyErrorPerColum) {
                            $columnas['errores_msg'] = "El apellido paterno no es valido, solo letras con espacios.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Apellido materno
                        if ((!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $columnas['columna'])  && $contarColumnas == 4) && !$OnlyErrorPerColum) {
                            $columnas['errores_msg'] = "El apellido materno no es valido, solo letras con espacios.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                       
                    }
                }
                if($Errores){
                    $this->respuesta['Errores'] = true;
                    $this->respuesta['view_Excel']  = view('excel._list')->with('listados', $rows)->with('headers',$headers)->render();
                }else{
                    foreach($rows as &$row){
                        $contarColumnas = 0;
                        $model = new Maestro();
                        foreach($row['Datos'] as &$columnas){
                            $OnlyErrorPerColum = false;
                            if($totalColumnas == $contarColumnas){
                                 break;
                            }
                            $contarColumnas++;

                            if($contarColumnas == 1){
                                $model->clave = $columnas['columna'];
                            }
                            if($contarColumnas == 2){
                                $model->nombres = $columnas['columna'];
                            }
                            if($contarColumnas == 3){
                                $model->apellido_paterno = $columnas['columna'];
                            }
                            if($contarColumnas == 4){
                                $model->apellido_materno = $columnas['columna'];
                            }
                        }
                        $model->save();
                        $totalSave++;
                    }
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje'] = "Se guardaron ${totalSave} registo(s) en maestros";
                }
            }else{
                $this->respuesta['mensaje'] = "no hay valores en el documento, por favor revisar";
            }

        }catch (\Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();
            return $this->respuesta;
		}
        
    }
        //Materias
        private function ImportarMateria($path){
            try{
                $totalSave=0;
                $totalColumnas=3;
                $headers= ['Tema','Descripción'];
                $collection = Excel::toCollection(new MateriaImport, $path);
                $rows = $this->getCollection($collection);
                //dd(count($rows));
                $Errores = false;
                if(count($rows) > 0){
                    //validamos
                    foreach($rows as &$row){
                        $contarColumnas = 0;
                        foreach($row['Datos'] as &$columnas){
                            $OnlyErrorPerColum = false;
                            if($totalColumnas == $contarColumnas){
                                 break;
                            }
                            $contarColumnas++;
                            $Controlador = new MateriaController;
                            //nombre
                            if((strlen($columnas['columna']) <= 0  && $contarColumnas == 1) && !$OnlyErrorPerColum ){
                                $columnas['errores_msg'] = "El nombre es requerido.";
                                $Errores=true;
                                $OnlyErrorPerColum = true;
                            }
                            if(($Controlador->ExistNombre($columnas['columna']) && $contarColumnas == 1) && !$OnlyErrorPerColum){
                                $columnas['errores_msg'] = "El nombre ".$columnas['columna']." ya existe por favor de remplazar o remover.";
                                $Errores=true;
                                $OnlyErrorPerColum = true;
                            }
                            //Descripcion
                        }
                    }
                    if($Errores){
                        $this->respuesta['Errores'] = true;
                        $this->respuesta['view_Excel']  = view('excel._list')->with('listados', $rows)->with('headers',$headers)->render();
                    }else{
                        foreach($rows as &$row){
                            $contarColumnas = 0;
                            $model = new Materia();
                            foreach($row['Datos'] as &$columnas){
                                $OnlyErrorPerColum = false;
                                if($totalColumnas == $contarColumnas){
                                     break;
                                }
                                $contarColumnas++;
                                if($contarColumnas == 1){
                                    $model->nombre = $columnas['columna'];
                                }
                                if($contarColumnas == 2){
                                    $model->descripcion = $columnas['columna'];
                                }
                            }
                            $model->save();
                            $totalSave++;
                        }
                        $this->respuesta['valido']    = true;
                        $this->respuesta['mensaje'] = "Se guardaron ${totalSave} registo(s) en sub temas";
                    }
                }else{
                    $this->respuesta['mensaje'] = "no hay valores en el documento, por favor revisar";
                }
    
            }catch (\Exception $e) {
                $this->respuesta['mensaje'] = $e->getMessage();
                return $this->respuesta;
            }
            
        }
    //Sub Tema
    private function ImportarSubTema($path){
        try{
            $totalSave=0;
            $totalColumnas=3;
            $headers= ['Tema','Descripción','Tema'];
            $collection = Excel::toCollection(new SubTemaImport, $path);
            $rows = $this->getCollection($collection);
            //dd(count($rows));
            $Errores = false;
            if(count($rows) > 0){
                //validamos
                foreach($rows as &$row){
                    $contarColumnas = 0;
                    foreach($row['Datos'] as &$columnas){
                        $OnlyErrorPerColum = false;
                        if($totalColumnas == $contarColumnas){
                             break;
                        }
                        $contarColumnas++;
                        $Controlador = new SubTemaController;
                        //Tema
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 1) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "El sub tema es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if(($Controlador->ExistNombre($columnas['columna']) && $contarColumnas == 1) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "El sub tema ".$columnas['columna']." ya existe por favor de remplazar o remover.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Descripcion
                        //Materia
                        //Tema
                        $ControladorSecundario = new TemaController;
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 3) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "El subtema es requerida.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if((!$ControladorSecundario->ExistNombre($columnas['columna']) && $contarColumnas == 3) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "El sub tema ".$columnas['columna']." no existe por favor, escribe una que exista en el sistema.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                       
                    }
                }
                if($Errores){
                    $this->respuesta['Errores'] = true;
                    $this->respuesta['view_Excel']  = view('excel._list')->with('listados', $rows)->with('headers',$headers)->render();
                }else{
                    foreach($rows as &$row){
                        $contarColumnas = 0;
                        $model = new SubTema();
                        foreach($row['Datos'] as &$columnas){
                            $OnlyErrorPerColum = false;
                            if($totalColumnas == $contarColumnas){
                                 break;
                            }
                            $contarColumnas++;

                            if($contarColumnas == 1){
                                $model->nombre = $columnas['columna'];
                            }
                            if($contarColumnas == 2){
                                $model->descripcion = $columnas['columna'];
                            }
                            if($contarColumnas == 3){
                                $Controller = new TemaController;
                                $id = $Controller->getIdByName($columnas['columna']);
                                $model->tema_id = $id ;
                            }
                            
                            
                        }
                        $model->save();
                        $totalSave++;
                    }
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje'] = "Se guardaron ${totalSave} registo(s) en sub temas";
                }
            }else{
                $this->respuesta['mensaje'] = "no hay valores en el documento, por favor revisar";
            }

        }catch (\Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();
            return $this->respuesta;
		}
        
    }
    //Temas
    private function ImportarTema($path){
        try{
            $totalSave=0;
            $totalColumnas=3;
            $headers= ['Tema','Descripción','Materia'];
            $collection = Excel::toCollection(new TemaImport, $path);
            $rows = $this->getCollection($collection);
            //dd(count($rows));
            $Errores = false;
            if(count($rows) > 0){
                //validamos
                foreach($rows as &$row){
                    $contarColumnas = 0;
                    foreach($row['Datos'] as &$columnas){
                        $OnlyErrorPerColum = false;
                        if($totalColumnas == $contarColumnas){
                             break;
                        }
                        $contarColumnas++;
                        $Controlador = new TemaController;
                        //Tema
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 1) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "El tema es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if(($Controlador->ExistNombre($columnas['columna']) && $contarColumnas == 1) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "El tema ".$columnas['columna']." ya existe por favor de remplazar o remover.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        //Descripcion
                        //Materia
                        //Tema
                        $ControladorSecundario = new MateriaController;
                        if((strlen($columnas['columna']) <= 0  && $contarColumnas == 3) && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "La matria es requerida.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if((!$ControladorSecundario->ExistNombre($columnas['columna']) && $contarColumnas == 3) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "La materia ".$columnas['columna']." no existe por favor, escribe una que exista en el sistema.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                       
                    }
                }
                if($Errores){
                    $this->respuesta['Errores'] = true;
                    $this->respuesta['view_Excel']  = view('excel._list')->with('listados', $rows)->with('headers',$headers)->render();
                }else{
                    foreach($rows as &$row){
                        $contarColumnas = 0;
                        $model = new Tema();
                        foreach($row['Datos'] as &$columnas){
                            $OnlyErrorPerColum = false;
                            if($totalColumnas == $contarColumnas){
                                 break;
                            }
                            $contarColumnas++;

                            if($contarColumnas == 1){
                                $model->nombre = $columnas['columna'];
                            }
                            if($contarColumnas == 2){
                                $model->descripcion = $columnas['columna'];
                            }
                            if($contarColumnas == 3){
                                $Controller = new MateriaController;
                                $id = $Controller->getIdByName($columnas['columna']);
                                $model->materia_id = $id ;
                            }
                            
                            
                        }
                        $model->save();
                        $totalSave++;
                    }
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje'] = "Se guardaron ${totalSave} registo(s) en Temas";
                }
            }else{
                $this->respuesta['mensaje'] = "no hay valores en el documento, por favor revisar";
            }

        }catch (\Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();
            return $this->respuesta;
		}
        
    }

    //Turno
    private function ImportarTurno($path){
        try{
            $totalSave=0;
            $totalColumnas=1;
            $headers= ['Turno'];
            $collection = Excel::toCollection(new TurnoImport, $path);
            $rows = $this->getCollection($collection);
            //dd(count($rows));
            $Errores = false;
            if(count($rows) > 0){
                //validamos
                foreach($rows as &$row){
                    $contarColumnas = 0;
                    foreach($row['Datos'] as &$columnas){
                        $OnlyErrorPerColum = false;
                        if($totalColumnas == $contarColumnas){
                             break;
                        }
                        $Controlador = new TurnoController;
                        if(strlen($columnas['columna']) <= 0 && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "El turno es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        if($Controlador->ExistNombre($columnas['columna']) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "El turno ".$columnas['columna']." ya existe por favor de remplazar o remover.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        $contarColumnas++;
                    }
                }
                if($Errores){
                    $this->respuesta['Errores'] = true;
                    $this->respuesta['view_Excel']  = view('excel._list')->with('listados', $rows)->with('headers',$headers)->render();
                }else{
                    foreach($rows as &$row){
                        $contarColumnas = 0;
                        foreach($row['Datos'] as &$columnas){
                            $OnlyErrorPerColum = false;
                            if($totalColumnas == $contarColumnas){
                                 break;
                            }
                            
                            $model =  new Turno();
                            $model->turno = $columnas['columna'];
                            $model->save();
                            $contarColumnas++;
                            $totalSave++;
                        }
                    }
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje'] = "Se guardaron ${totalSave} registo(s) en Turnos";
                }
            }else{
                $this->respuesta['mensaje'] = "no hay valores en el documento, por favor revisar";
            }

        }catch (\Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();
            return $this->respuesta;
		}
        
    }

    //Grupos
    private function ImportarGrupo($path){  

        try{
            $totalSave=0;
            $totalColumnas=1;
            $headers= ['Grupo'];
            $collection = Excel::toCollection(new GrupoImport, $path);
            $rows = $this->getCollection($collection);
            //dd(count($rows));
            $Errores = false;
            if(count($rows) > 0){
                //validamos
                foreach($rows as &$row){
                    $contarColumnas = 0;
                    foreach($row['Datos'] as &$columnas){
                        $OnlyErrorPerColum = false;
                        if($totalColumnas == $contarColumnas){
                             break;
                        }
                        $grupoController = new GrupoController;
                        if(strlen($columnas['columna']) <= 0 && !$OnlyErrorPerColum ){
                            $columnas['errores_msg'] = "El grupo es requerido.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;

                        }
                        if($grupoController->ExistNombre($columnas['columna']) && !$OnlyErrorPerColum){
                            $columnas['errores_msg'] = "El grupo ".$columnas['columna']." ya existe por favor de remplazar o remover.";
                            $Errores=true;
                            $OnlyErrorPerColum = true;
                        }
                        $contarColumnas++;
                    }
                }
                if($Errores){
                    $this->respuesta['Errores'] = true;
                    $this->respuesta['view_Excel']  = view('excel._list')->with('listados', $rows)->with('headers',$headers)->render();
                }else{
                    foreach($rows as &$row){
                        $contarColumnas = 0;
                        foreach($row['Datos'] as &$columnas){
                            $OnlyErrorPerColum = false;
                            if($totalColumnas == $contarColumnas){
                                 break;
                            }
                            $model =  new Grupo();
                            $model->grupo = $columnas['columna'];
                            $model->save();
                            $contarColumnas++;
                            $totalSave++;
                        }
                    }
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje'] = "Se guardaron ${totalSave} registo(s) en Grupos";
                }
            }else{
                $this->respuesta['mensaje'] = "no hay valores en el documento, por favor revisar";
            }

        }catch (Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();
            return $this->respuesta;
		}
        
    }

    public function getCollection($collection){
        try{

            $cRows = [];
            $primera=0;
            if(!empty($collection))
            {
                foreach($collection as $key => $value)
                {
                    foreach($value as $row)
                    {
                        $cCells = []; 
                        if($primera > 0){
                            foreach ($row as $item) {
                                array_push($cCells,[
                                    'columna' => $item,
                                    'errores_msg' => ""
                                ]);
                            }
                            array_push($cRows,[
                                "Linea" => $primera,
                                "Datos" => $cCells]);
                        }
                        $primera++;
                        
                    }
                }
            }
            return $cRows;

        }catch(\Exception $e){
            return [];
        }
    }
    public function getTitulos($model){
          switch ($model) {
            case 1: //Turnos
                array_push($this->dataHeader, "Turno");
                return "Turnos";
                break;
            case 2: //Temas
                array_push($this->dataHeader, "Nombre");
                array_push($this->dataHeader, "Descripción");
                array_push($this->dataHeader, "Materia");
                return "Temas";
                break;
            case 3: //Sub tema
                array_push($this->dataHeader, "Nombre");
                array_push($this->dataHeader, "Descripción");
                array_push($this->dataHeader, "Tema");
                return "Sub tema";
                break;
            case 4: //Materias
                    array_push($this->dataHeader, "Nombre");
                    array_push($this->dataHeader, "Descripción");
                    return "Materias";
            break;
            case 5: //Maestro
                array_push($this->dataHeader, "Clave");
                array_push($this->dataHeader, "nombres");
                array_push($this->dataHeader, "Apellido Paterno");
                array_push($this->dataHeader, "Apellido Materno");
                return "Maestro";
                break;
            case 6: //Grupo
                    array_push($this->dataHeader, "Grupo");
                    return "Grupos";
                break;
            case 7: //Grado
                array_push($this->dataHeader, "Grado");
                return "Grados";
            break;
            case 8: //Alumno
                array_push($this->dataHeader, "Matricula");
                array_push($this->dataHeader, "Nombres");
                array_push($this->dataHeader, "Apellido Paterno");
                array_push($this->dataHeader, "Apellido Materno");
                return "Alumno";
            break;
            default:
                return "Desconocido";
            break;
        }
    }

    //registro por metodos



 
}
