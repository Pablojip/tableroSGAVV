<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
//use Request;
use Illuminate\Http\Request;
use App\User;
use App\Role;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $respuesta= array("valido" => false, "mensaje" =>"");

    private function getRoles(){
        
        $roles = Role::all()->pluck('nombre', 'id')->toArray();
        return $roles;

    }
    public function index(Request $request)
    {
        
            try{
                $nombres = $request->get('nombres');
                $apellido_paterno = $request->get('apellido_paterno');
                $apellido_matero = $request->get('apellido_materno');
                $email = $request->get('email');
                $rol_id = $request->get('role_id');
        
                $users = User::orderBy('id','DESC')
                    ->nombres($nombres)
                    ->apellidopaterno($apellido_paterno)
                    ->apellidomaterno($apellido_matero)
                    ->email($email)
                    ->rol($rol_id)
                    ->paginate(5);
                if($request->ajax()){ 
                    $this->respuesta['valido']    = true;
                    $this->respuesta['mensaje']  = view('user._list')->with('users', $users)->render();
                    return response()->json($this->respuesta);
                }
                return view('user.index',['roles' => $this->getRoles(),'users' => $users]);
               
    
            }catch(\Exception $e){
                $this->respuesta['mensaje'] = $e->getMessage();;
                if($request->ajax()){ 
                    return $this->respuesta;
                }
                return view('user.index',['roles' => $this->getRoles(),'users' => null,'errorMsj' => $this->respuesta['mensaje']]);
            }
        
            
        
       

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createProfile($id)
    {
        try{
            $model = User::find($id);
            return view('user.create_profile',['model' => $model]);

        }catch(\Exception $e){
            return view('user.create_profile',['model' => null]);
        }
    }
    public function createProfileStore(Request $request)
    {
        try{
            $id = $request->get('id');
            if(!$id){
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar tu perfil para la edición.";
                return $this->respuesta;

            }

            if($this->ExistEmail($request->get('email'),$id)){
                $this->respuesta['mensaje'] = "El correo eléctronico ya existe por  favor seleccione otro.";
                return $this->respuesta;

            }

            $model = User::find($id);
            $model->nombres                = $request->get('nombres');
            $model->apellido_paterno       = $request->get('apellido_paterno');
            $model->apellido_materno       = $request->get('apellido_materno');
            $model->email                  = $request->get('email');
            $model->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje']   = "Se guardo los  datos de tu perfil: ".$model->nombreCompleto();
            return $this->respuesta;

        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
        }
    }
    public function create()
    {
        
        return view('user.create',['roles' => $this->getRoles()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$rules = array(
            'nombres'       => 'required',
            'apellido_paterno'       => 'required',
            'apellido_materno'       => 'required',
            'email'      => 'required|email',
            'password' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);*/

        try{
            if($this->ExistEmail($request->get('email'))){
                $this->respuesta['mensaje'] = "El correo eléctronico ya existe por  favor seleccione otro.";
                return $this->respuesta;

            }
            $user = new User;
            $user->nombres                = $request->get('nombres');
            $user->apellido_paterno       = $request->get('apellido_paterno');
            $user->apellido_materno       = $request->get('apellido_materno');
            $user->email                  = $request->get('email');
            $user->password               = Hash::make($request->get('password'));
            $user->role_id                = $request->get('role_id');
            $user->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los  datos del usuario: ".$user->nombreCompleto();
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
            $user = User::find($id);
            return view('user.detail',['roles' => $this->getRoles(),'user' => $user]);

        }catch(\Exception $e){
            return view('user.detail',['roles' => $this->getRoles(),'user' => mull, 'errorMsj' => $e->getMessage() ]);
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
            $user = User::find($id);
            return view('user.edit',['roles' => $this->getRoles(),'user' => $user]);

        }catch(\Exception $e){
            return view('user.edit',['roles' => $this->getRoles(),'user' => mull, 'errorMsj' => $e->getMessage() ]);
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
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de seleccionar al usuario para la edición.";
                return $this->respuesta;

            }

            if($this->ExistEmail($request->get('email'),$id)){
                $this->respuesta['mensaje'] = "El correo eléctronico ya existe por  favor seleccione otro.";
                return $this->respuesta;

            }

            $user = User::find($id);
            $user->nombres                = $request->get('nombres');
            $user->apellido_paterno       = $request->get('apellido_paterno');
            $user->apellido_materno       = $request->get('apellido_materno');
            $user->email                  = $request->get('email');
            $user->role_id                = $request->get('role_id');
            $user->activo                 = $request->get('activo') ?? 0;
            $user->save();
            $this->respuesta['valido']    = true;
            $this->respuesta['mensaje'] = "Se guardo los  datos del usuario: ".$user->nombreCompleto();
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
    private function ExistEmail($email,$id=0){
        if($id != 0){
            return User::where('email', '=', $email)->where('id','!=',$id)->exists();
        }
        return User::where('email', '=', $email)->exists();
    }
}
