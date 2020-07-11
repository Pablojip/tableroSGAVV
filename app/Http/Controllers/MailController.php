<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Exception;

class MailController extends Controller
{
	public $respuesta= array("valido" => false, "mensaje" =>"");

	public function __construct(){
		$this->middleware('auth',['only' =>'store']);
		$this->middleware('guest',['only' =>'recuperarPassword']);
	}
    public function store(){

    	Mail::send('layout.partial.bienvenidaEmail',['nombreCompleto' =>Auth()->User()->getNombreCompleto()],function($msj){
    		$msj->subject('SGAVYV | Información');
    		//email, username
    		$msj->to(['pablo12_jip3@hotmail.com','pablo12jip3@gmail.com'],'Pablo perez');
    		//$msj->attach(asset('assets/img/logo.png'));
    	});

    	return redirect()->route('dashboard');
    }
    function sendMail($correo,$nombre,$data,$subject,$layout){
    	$datosEmail = array( 'correo' => $correo, 'nombre' => $nombre, 'subject' => $subject, 'layout' => $layout );
    	Mail::send($layout,$data,function($msj) use ($datosEmail){
    		$msj->subject('SGAVYV |'. $datosEmail['subject']);
    		//email, username
    		$msj->to($datosEmail['correo'],$datosEmail['nombre']);
    		//$msj->attach(asset('assets/img/logo.png'));
    	});
    }
    public function recuperarPassword(Request $request){

    	try {

			$validator = Validator::make($request->all(), [
				'correoSend' => 'required|email|string'
			],[
	        	'correoSend.required' => 'El correo es requerido.',
	            'correoSend.email' => 'Por favor escriba un correo real.',
	            'correoSend.string' => 'El correo debe de ser texto',
			]);
			if ($validator->fails()){
				$this->respuesta['mensaje'] = $validator->errors()->first();
				return $this->respuesta;
			}

			$email = $request->get('correoSend');
            if(!$email){
                $this->respuesta['mensaje'] = "Ocurrio un error al momento de encontrar el correo.".$email;
                return $this->respuesta;
            }
			$user = User::Where('email',$email)->first();
			if($user){
				$clave = str_random(40);
				$user->codigoConfirmacionPassword = $clave;
				if($user->save()){
					$data= [
						'clave' => $clave,
						'nombreCompleto' => $user->nombreCompleto(),
						'url' => route('cambiarPassword',$clave),
						'urlCancelacion' => route('home')
					];

					$this->sendMail($user->email,$user->nombreCompleto(),$data,' Recuperación de contraseña','layouts.partials.recuperarPassword');
					$this->respuesta['valido']    = true;
					$this->respuesta['mensaje']   = "Se envio intrucciones al correo '{$user->email}', para que pueda recuperar la contraseña.";
					return $this->respuesta;
				}else{
					$this->respuesta['mensaje']   = "lo sentimos, no pudimos enviar los datos al correo seleccionado.";
					return $this->respuesta;
				}
			}else{
				$this->respuesta['mensaje']   = "lo sentimos, los datos proporcionados no son correctos, por favor de verificar.";
				return $this->respuesta;
			}

		}
		catch (Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
		}
		
	}
	public function recuperarPasswordIn(){

    	try {

			$user = Auth::user();
			if($user){
				$clave = str_random(40);
				$user->codigoConfirmacionPassword = $clave;
				if($user->save()){
					$data= [
						'clave' => $clave,
						'nombreCompleto' => $user->nombreCompleto(),
						'url' => route('cambiarPassword',$clave),
						'urlCancelacion' => route('home')
					];

					$this->sendMail($user->email,$user->nombreCompleto(),$data,' Recuperación de contraseña','layouts.partials.recuperarPassword');
					$this->respuesta['valido']    = true;
					$this->respuesta['mensaje']   = "Se envio intrucciones al correo '{$user->email}', para que pueda recuperar la contraseña.";
					return $this->respuesta;
				}else{
					$this->respuesta['mensaje']   = "lo sentimos,no se pudo generar el codigo para cambio de contraseña, por favor contacte al administrador.";
					return $this->respuesta;
				}
			}else{
				$this->respuesta['mensaje']   = "lo sentimos, no encontramos la información del usuario para  procesar la solicitud, por favor contacte al administrador.";
				return $this->respuesta;
			}

		}
		catch (Exception $e) {
		    $this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
		}
		
    }

    //recuperarPassowrd
    public function changePassword($clave){
    	if($clave){
			$user = User::where('codigoConfirmacionPassword',$clave)->first();
			if($user){
				$model= [
					'clave' => $clave,
		        	'nombreCompleto' => $user->nombreCompleto(),
		        	'email' => $user->email,
		        	'imgPerfil' => '',
		        	'tipo' => ''
		        ];
		    	return view('login.cambiar_password',compact('model'));
			}

    	}

    	return view('layouts.paginaExpirada');

    	
    }
    public function putChangePassword(){
    	try{
			$validator = Validator::make(Request()->all(),[
			    'password' => 'required|min:6',
			    'repeat_password' => 'required|min:6|same:password',
			],[
				'password.required' => "La contraseña es obligatorio.",
				'password.min' => "La contraseña debe de tener alemnos 6 caracteres.",
				'repeat_password.required' => "El campo de comfirmar contraseña es obligatorio.",
				'repeat_password.min' => "El campo de comfirmar contraseña debe de tener alemnos 6 caracteres.",
				'repeat_password.same' => "El campo 'contraseña' y el campo 'confirmar contraseña' deben de coincidir.",  
			]);
		    if (!$validator->fails()){
		        $user =  User::where('codigoConfirmacionPassword',Request()->input('clave'))->first();
		        if($user){
		        	$user->password = Hash::make(Request()->input('password'));
		        	$user->codigoConfirmacionPassword = null;
		        	if($user->save()){
		        		Auth::login($user);
		        		$this->respuesta['valido'] = true;
                        return $this->respuesta;
	        		}else{
						$this->respuesta['mensaje']   = "Lo sentimos, no pudimos cambiar la contraseña, por favor vuelvalo a intentar.";
						return $this->respuesta;
	        		}
		        }else
		        	return view('layout.partial.paginaExpirada');
		    }
		    else{
				$this->respuesta['mensaje']   = $validator->errors()->first();
				return $this->respuesta;
		    }
    	}catch (Exception $e) {
			$this->respuesta['mensaje'] = $e->getMessage();;
            return $this->respuesta;
		}
	}
	
	


}
