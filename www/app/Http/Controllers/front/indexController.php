<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\front\index_model as index;
use App\Models\front\linea_model as linea;
use App\Models\front\sucursal_model as sucursal;
use App\Models\front\slider_model as slider;
use App\Models\front\promocion_model as promocion;
use App\Models\front\search_model as search;
use App\Models\front\ciudad_model as ciudad;

class indexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        $data = [];

        $data["promociones"]    = promocion::find_all( [ 'limit' => 4 ] );
        $data["slider"]         = slider::find_all();
        $data["lineas"]         = linea::find_all();
        $data["rand_sucursal"]  = sucursal::find_random();
        $data["sucursales"]     = sucursal::find_all();
        $data["ciudades"]       = ciudad::find_all(['lista'=>true]);
        $data["footer_text"]    = \DB::table('text_footer')->where('id',1)->first();

        // dd($data);

        return view('front.index',$data);
    
    }

    /**
     * Guarda mensaje de contacto del usuario.
     *
     * 
     */
    public function contact(Request $request){
        $this->validate($request,[
            "nombre" => "string",
            "email" => "email",
            "mensaje" => "required|string",
            "telefono" => "string"
        ]);
        if($request->ajax()){
            if(! \App\Models\front\contact_model::send_message($request))
                abort(500);

        }
        else
            abort(503);
    }

    /**
     * Almacena correos electrónicos para las noticias.
     *
     * 
     */
    public function newsletter(Request $request){
        $this->validate($request,[
            "email" => "email",
        ]);
        if($request->ajax()){
            if(! \App\Models\newsletter_model::subscribe($request))
                abort(500);
        }
        else
            abort(503);
    }

    /**
    ** Buscar
    ** sucursales, lineas de juego, promociones, comida
    **/
    public function search(Request $request){
        // $this->validate(regexp)
        $q = ($request->input('q'));
        $data = search::all($q);
        return view('front.resultados.index',['result' => $data]);
    }
}
