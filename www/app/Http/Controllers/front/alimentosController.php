<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\front\sucursal_model as sucursal;
use App\Models\front\alimento_model as alimento;

class alimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index( $sucursal = null ){
        
        $data = [];

        $data["sucursal"] = $sucursal;

        //-----> Obtenemos detalle de sucursal seleccionada
        $data["sucursal_info"] = sucursal::find_by_slug( $sucursal );
        $id_sucursal = ( $data["sucursal_info"] ) ? $data["sucursal_info"]->id_sucursal : null;
        
        //-----> Obtenemos todas las sucursales
        $data["sucursales"] = sucursal::find_all();

        //-----> Obtenemos los alimentos
        $data["alimentos"] = alimento::find_all( [ 'id_sucursal' => $id_sucursal ] );

        //-----> Obtenemos los tipos de alimentos
        $data["tipos_alimentos"] = alimento::find_all_types();

        //dd($data);

        return view('front.alimentos.index',$data);
    
    }

   
}
