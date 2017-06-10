<?php

namespace App\Listeners;

use App\Events\dotask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\papelera;
use DB;

class registertask
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  dotask  $event
     * @return void
     */
    public function handle(dotask $event)
    {
        $error = array();

        $url = \Request::path();
        $url = explode("/",$url);

        $permiso = \DB::table('sys_permiso')->where('estatus',1)->where('eliminado',0)->where('accion',$url[1])->get();
        if(count($permiso) != 1){
            $error[] ="No tiene los permisos para realizar esta acción";
        }
        else{
            $permiso = $permiso[0];
            $permiso = $permiso->id_permiso;
        }

        $slug = explode(".",end($url));
        $slug = preg_replace('/[^a-zA-Z_]/i', "", current($slug));

        $mod = \DB::table('sys_modulo')->where('estatus',1)->where('eliminado',0)->where('slug',$slug)->get();
        if(count($mod) != 1){
            $error[] ="Módulo no disponible por el momento";
        }
        else{
            $mod = $mod[0];
            $mod = $mod->id_modulo;
        }

        // $mod = $event->mod;
        // $permiso = $event->permiso;
        $actividad = $event->actividad;
        $consulta = $event->consulta;

        if(!session()->has('idsesion_log'))
            $error[] = "No ha iniciado sesión";
        if($mod < 1 )
            $error[] = "Módulo no válido";

        if($permiso < 1 )
            $error[] = "Permiso no válido";

        if(count($error) < 1){
            $actividad->id_sesion = session('idsesion_log');
            $actividad->id_modulo = $mod;
            $actividad->id_permiso = $permiso;


            DB::transaction(function () use ($actividad,$consulta){
                try{
                    $consulta->save();
                    $key = $consulta->getKeyName();
                    $actividad->id_elemento = $consulta->$key;
                    $actividad->save();
                    if($actividad->id_permiso == 3){
                        $papelera = new papelera;
                        $papelera->id_sesion = session('idsesion_log');
                        $papelera->id_tipo = $actividad->id_modulo;
                        $papelera->id_elemento = $actividad->id_elemento;
                        $papelera->save();
                    }
                    return false;
                }
                catch(\Exception $e){
                    // dd($e->getMEssage());
                    return array("error"=>$e->getMEssage());
                }
                
            });
            
        }
        if(count($error) > 0)
            return $error;

    }
}
