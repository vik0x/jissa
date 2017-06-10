<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Models\front\sucursal_model as sucursal;
use \App\Models\front\promocion_model as promocion;
use \App\Models\front\linea_model as linea;

class sucursalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null){
        $sucursal = sucursal::find_by_slug($slug);
        if($slug !== null){
            $data = [
                'sucursal' => $sucursal,
                'slug_sucursal' => $slug,
                'sucursales' => sucursal::find_all(),
                'galeria' => sucursal::get_gallery($sucursal->id_sucursal),
                'promociones' => promocion::find_all(['id_sucursal' => $sucursal->id_sucursal]),
                'maquinas' => linea::get_games([ 'linea' => 1, 'id_sucursal' => $sucursal->id_sucursal, 'limit' => 4]),
                'torneos' => linea::find_all_tournaments(['id_sucursal' => $sucursal->id_sucursal]),
                'maquinas_acumulado' => linea::get_games( [ "linea" => 1, "id_sucursal" => $sucursal->id_sucursal] ),
                // 'mesas' => linea::get_games([ 'linea' => 2, 'id_sucursal' => $sucursal->id_sucursal ])
                "mesas" => linea::get_games_table( [ "linea" => 2, "id_sucursal" => $sucursal->id_sucursal] )
            ];
            $data['acumulado'] = sucursal::get_accumulated(['id_sucursal' => $sucursal->id_sucursal]);
        }
        else{
            $data = [
                'slug_sucursal' => $slug,
                'sucursales' => sucursal::find_all(),
                'promociones' => promocion::find_all(),
                'maquinas' => linea::get_games(['linea' => 1,'limit' => 4]),
                'torneos' => linea::find_all_tournaments(),
                'maquinas_acumulado' => linea::get_games( [ "linea" => 1 ] ),
                // 'mesas' => linea::get_games([ 'linea' => 2 ])                
                "mesas" => linea::get_games_table( [ "linea" => 2 ] )
            ];
        }
        
        //-----> Obtenemos las categorías de los juegos
        $data["categorias"] = linea::get_categories(['list'=>true]);
        //$data['slider'] = sucursal::get_gallery($sucursal->id_sucursal,2);
        $data['slider'] = \App\Models\front\slider_model::find_all(3);

        // dd($data);
        return view('front.sucursales.index',$data);
    }

    /**
     * Show the general view.
     *
     * @return \Illuminate\Http\Response
     */
    public function general(){
        $id_ciudad = \Request::all();
        $id_ciudad = isset( $id_ciudad['city'] ) ? $id_ciudad['city'] : null;
        $data = [
            'id_ciudad' => $id_ciudad,
            'ciudades' => \App\Models\front\ciudad_model::find_all(['lista'=>true]),
            'sucursales' => sucursal::find_all(['id_ciudad'=>$id_ciudad]),
            'slider' => \App\Models\front\slider_model::find_all(3)
        ];
        // dd($data);
        return view('front.sucursales.general',$data);
    }
}
