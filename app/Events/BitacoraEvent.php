<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Bitacora;
use App\BitacoraModificacion;
use Log;
use Illuminate\Support\Facades\Auth;

class BitacoraEvent
{

    public $user_id;
    public $tabla_id;
    public $routDetalle='.detalle';
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }*/
    
    public function bitacoraCreated($data)
    {
        //$nombreTabla,$registro_id,$nombre,$route
       try{
            $Bitacora = new bitacora();

            if($user = Auth::user())
            {
                $this->user_id = $user->id;
            }
            $Bitacora->user_id = $this->user_id;
            $Bitacora->tabla = $data['tabla'];
            $Bitacora->registro_id = $data['registro_id'];
            $Bitacora->tabla_publico = $data['tabla_publico'];
            $Bitacora->nuevo = true;
            $Bitacora->save();
        }catch (Exception $e) {
            $message = $e->getMessage();
            Log::info("Ocurrio un error al momento de capturar la bitacora, [Error]: {$message}");
        }

    }



    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function bitacora($data)

    {

         //$nombreTabla,$registro_id,$nombre,$route,datosUpdate
       try{
            $Bitacora = new bitacora();
            
            if($user = Auth::user())
            {
                $this->user_id = $user->id;
            }
            $Bitacora->user_id = $this->user_id;
            $Bitacora->tabla = $data['tabla'];
            $Bitacora->registro_id = $data['registro_id'];
            $Bitacora->tabla_publico = $data['tabla_publico'];
            if($data['created'] == 1)
                $Bitacora->nuevo = true;
            else
                $Bitacora->editar = true;
            $Bitacora->cambios = json_encode($data['cambios']);
            $Bitacora->save();
            
            /*foreach ($data['datosUpdate'] as $item) {
                $BitacoraUpdate = new BitacoraModificacion();
                $BitacoraUpdate->bitacora_id = $Bitacora->id;
                $BitacoraUpdate->campoAnterior = $item['campoAnterior'];
                $BitacoraUpdate->camporNuevo = $item['camporNuevo'];
                $BitacoraUpdate->nombreCampo = $item['nombreCampo'];
                $BitacoraUpdate->save();
            }*/
            

        }catch (Exception $e) {
            $message = $e->getMessage();
            Log::info("Ocurrio un error al momento de capturar la bitacora, [Error]: {$message}");
        }

    }



    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function bitacoraDisable(Item $item)

    {

        Log::info("Item Deleted Event Fire: ".$item);

    }

    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function bitacoraOtros(Item $item)

    {

        Log::info("Item Deleted Event Fire: ".$item);

    }
}
