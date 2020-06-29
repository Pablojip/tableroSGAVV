<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $respuesta= array("valido" => false, "mensaje" =>"");
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        /*$usernew = new User();
        $usernew->email = "pablo12_jip3@hotmail.com";
        $usernew->password = Hash::make('secret');
        $usernew->persona_id = 1;
        $usernew->save();*/
        return view('login.login');

        
    }

    public function verificaLogin(Request $request){
        $this->respuesta['mensaje'] = "los datos no concuerdan con nuestras creedenciales, por favor vuelva a intentar.";
        try{

            $usuario = User::where('email',$request->correoElectronico)->first();
            if($usuario !== null){
                //checamos la contraseña para ver si le falta otra configuración
                $passwordValido = Hash::check($request->password, $usuario->getAuthPassword());
                if($passwordValido){
                    //validamos si el  usuario tiene alguna restincion
                    $usuarioValidado = $this->validarUsuario($usuario);
                    if(strlen($usuarioValidado) > 0){
                        $this->respuesta['mensaje'] = $usuarioValidado;
                        return $this->respuesta;
                    }
                    $arrRequest = array(
                        "email" => $request->correoElectronico,
                        "password" => $request->password,
                    );
                    //logiamos al usuario.
                    if(Auth::attempt($arrRequest)){
                        $this->respuesta['valido'] = true;
                        return $this->respuesta;
                    }
                }
            }
            
            
            return $this->respuesta;
                    
        }catch(\Exception $e){
            $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
        }
    }


    public function logout(){
        Auth::logout();
        return redirect('/IniciarSesion');
    }
    private function validarUsuario(User $user){
        
        if(!$user->activo){
            return 'El usuario esta temporalmente desactivado, por favor contacte al administrador de la página.';
        }
        /*if($user->cambioPassword){
            return 'El cambio de contraseña esta en proceso, por favor de revisar su bandeja de entrada del correo especificado.';
        }*/
        if($user->confirmacionEmail){
            return 'Confirmacion de email en espera, Por favor de confirmar el email asociado a esta cuenta, para hacerlo dirigase a la bandeja de entrada del correo especificado.';
        }
    }
}
