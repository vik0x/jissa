<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\front\index_model as index;
use App\Models\front\api_model as api;


class apiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function Ubicaciones(){
		$data['Sstatus']='true';
        $data['code']=200;
        $data['message']='Test';
        $data['data'] =  \DB::table('sucursal')
            ->select(
                "sucursal.id_sucursal as id",
                "sucursal.nombre",
                "sucursal.nombre as ciudad",
                "sucursal.direccion",
                "sucursal.telefono",
                "sucursal.instrucciones as aparcamiento",
                "sucursal.oferta",
                "sucursal.latitud",
                "sucursal.longitud"
            )
            ->join('ciudad', 'sucursal.id_ciudad', '=', 'ciudad.id_ciudad')
            ->where('estatus',1)
            ->where('eliminado',0)
            ->get();
        return ($data);
    }

    public function Promociones($id){
        $data['Sstatus']='true';
        $data['code']=200;
        $data['message']='Test';
        $data['data'] = \DB::table('promocion as p')
            ->select(
                "p.id_promocion",
                "p.nombre as titulo",
                "p.slug",
                "p.resumen",
                "p.imagen",
                "p.thumb",
                "p.descripcion",
                "p.fecha_inicio",
                "p.fecha_fin"
            )
            ->join('juego as j','j.id_juego','=','p.id_juego')
            ->join('juego_sucursal as js','j.id_juego','=','js.id_juego')
            ->join('sucursal as s','s.id_sucursal','=','js.id_sucursal')
            ->where('p.estatus',1)
            ->where('p.eliminado',0)
            ->where('j.estatus',1)
            ->where('j.eliminado',0)
            ->where('s.estatus',1)
            ->where('s.eliminado',0)
            ->where('js.id_sucursal','=',$id)
            ->get();
        return $data;
    }

    public function CalienteClub(){
        $data['Sstatus']='true';
        $data['code']=200;
        $data['message']='Test';
        $data['data'] = \App\pagina_contenido::
            select(
                "titulo",
                "slug",
                "contenido"
            )
            ->where('estatus',1)
            ->where('eliminado',0)
            ->where('menu_inferior',1)
            ->get();
        return \Response::json($data);
    }

    public function JuegoResponsable(){
        $data['Sstatus']='true';
        $data['code']=200;
        $data['message']='Test';
        $data['data'] = \App\pagina_contenido::
            select(
                "titulo",
                "slug",
                "contenido"
            )
            ->where('estatus',1)
            ->where('eliminado',0)
            ->where('id_contenido',4)
            ->get();
        return \Response::json($data);
    }

    public function AvisoPrivacidad(){
        $data['Sstatus']='true';
        $data['code']=200;
        $data['message']='Test';
        $data['data'] = \App\pagina_contenido::
            select(
                "titulo",
                "slug",
                "contenido"
            )
            ->where('estatus',1)
            ->where('eliminado',0)
            ->where('id_contenido',5)
            ->get();
        return \Response::json($data);
    }
	
	  public function QuienesSomos(){
        $data['Sstatus']='true';
        $data['code']=200;
        $data['message']='Test';
        $data['data'] = \App\pagina_contenido::
            select(
                "titulo",
                "slug",
                "contenido"
            )
            ->where('estatus',1)
            ->where('eliminado',0)
            ->where('id_contenido',3)
            ->get();
        return \Response::json($data);
    }

    public function index(){
        abort(403);
        
        $data = [];

        $data["promociones"]    = promocion::find_all( [ 'limit' => 4 ] );
        $data["slider"]         = slider::find_all();
        $data["lineas"]         = linea::find_all();
        $data["rand_sucursal"]  = sucursal::find_random();
        $data["sucursales"]     = sucursal::find_all();
        $data["ciudades"]       = ciudad::find_all(['lista'=>true]);
        $data['data'] = \App\pagina_contenido::
            select(
                "titulo",
                "slug",
                "contenido"
            )
            ->where('estatus',1)
            ->where('eliminado',0)
            ->where('id_contenido',4)
            ->get();
        return \Response::json($data);
    
    }
}
