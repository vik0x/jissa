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
use App\Models\front\juego_model as juego;
use SoapClient;

class lineasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function maquinas( $sucursal = null ){
        $data = [];
        $data["sucursal"] = $sucursal;

        //-----> Obtenemos detalle de sucursal seleccionada
        $data["sucursal_info"] = sucursal::find_by_slug( $sucursal );
        $id_sucursal = ( $data["sucursal_info"] ) ? $data["sucursal_info"]->id_sucursal : null;

        //-----> Obtenemos los sliders
        //$data["slider"] = linea::find_gallery( 1 );
        $data["slider"] = slider::find_all(6);


        //-----> Obtenemos promociones
        $data["promociones"] = promocion::find_all( [ "linea" => 1, "id_sucursal" => $id_sucursal ] );

        //-----> Obtenemos maquinas de juego
        $data["maquinas"] = linea::get_games_table( [ "linea" => 1, "id_sucursal" => $id_sucursal, "limit" => 4,"id_categoria"=>2 ] );

        //-----> Obtenemos maquinas y sus acumulados
        $data["maquinas_acumulado"] = linea::get_games( [ "linea" => 1, "id_sucursal" => $id_sucursal] );

        //-----> Obtenemos las categorías de los juegos
        $data["categorias"] = linea::get_categories(['list'=>true]);
        //

        //-----> Obtenemos los proveedores
        $data["proveedores"] = linea::find_all_providers();

        //-----> Obtenemos otras opciones de diversión
        $data["otras"] = linea::find_all( [ "not_in" => [ 1 ] ] );

        //-----> Obtenemos todas las sucursales
        $data["sucursales"] = sucursal::find_all(['linea_id_linea' => 1]);

        $data['pagados'] = sucursal::get_paid(['id_sucursal' => $id_sucursal]);
        $data['acumulado'] = sucursal::get_accumulated(['id_sucursal' => $id_sucursal]);

        return view('front.lineas.maquinas',$data);
    }

    public function getAllDataDetailAcumulados($sucursal = null , $limit){

        $data["sucursal_info"] = sucursal::find_by_slug( $sucursal );
        $id_sucursal = ( $data["sucursal_info"] ) ? $data["sucursal_info"]->id_sucursal : null;

        $data['acumulado'] = sucursal::get_all_accumulated(['id_sucursal' => $id_sucursal , 'limit' => $limit]);
        $data = json_encode($data);
        print_r( $data);
    }


    public function getAllDataDetailPagados($sucursal = null , $limit){

        $data["sucursal_info"] = sucursal::find_by_slug( $sucursal );
        $id_sucursal = ( $data["sucursal_info"] ) ? $data["sucursal_info"]->id_sucursal : null;

        $data['pagados'] = sucursal::get_all_paid(['id_sucursal' => $id_sucursal , 'limit' => $limit]);
        $data = json_encode($data);
        print_r( $data);
    }



    public function detalle_juego($slug_maquina,$slug){
        $juego = juego::find(['slug' => $slug]);

        $data = [
            'juego' => $juego
        ];

        return view('front.juegos.show',$data);
    }

    public function learn_to_play($slug){
        $data = [
            'juego'=>juego::find(['slug'=>$slug])
        ];
        return view('front.juegos.aprender',$data);
    }

    public function rules_for_game($slug){
        $data = [
            'juego'=>juego::find(['slug'=>$slug])
        ];
        return view('front.juegos.reglas',$data);
    }

    public function mesas( $sucursal = null ){

        $data = [];

        $data["sucursal"] = $sucursal;

        //-----> Obtenemos detalle de sucursal seleccionada
        $data["sucursal_info"] = sucursal::find_by_slug( $sucursal );
        $id_sucursal = ( $data["sucursal_info"] ) ? $data["sucursal_info"]->id_sucursal : null;

        //-----> Obtenemos los sliders
        //$data["slider"] = linea::find_gallery( 2 );
        $data["slider"] = slider::find_all( 7 );

        //-----> Obtenemos promociones
        $data["promociones"] = promocion::find_all( [ "linea" => 2, "id_sucursal" => $id_sucursal ] );

        //-----> Obtenemos mesas de juego
        $data["mesas"] = linea::get_games_table( [ "linea" => 2, "id_sucursal" => $id_sucursal] );

        //-----> Obtenemos los proveedores
        $data["torneos"] = linea::find_all_tournaments( [ "id_sucursal" => $id_sucursal ] );

        //dd( $data["torneos"] );

        //-----> Obtenemos otras opciones de diversión
        $data["otras"] = linea::find_all( [ "not_in" => [ 2 ] ] );

        //-----> Obtenemos todas las sucursales
        $data["sucursales"] = sucursal::find_all(['linea_id_linea' => 2]);

        // -----> Por Pagar
        $data['porpagar'] = sucursal::to_pay(['id_sucursal' => $id_sucursal]);
        // dd($data);

        return view('front.lineas.mesas',$data);
    }

    public function carreras( $sucursal = null ){

        $request = \Request::all();
        $id_juego = ( isset($request['game']) ) ? juego::id_by_slug($request['game']) : null;

        $data["sucursal"] = $sucursal;

        //-----> Obtenemos detalle de sucursal seleccionada
        $data["sucursal_info"] = sucursal::find_by_slug( $sucursal );
        $id_sucursal = ( $data["sucursal_info"] ) ? $data["sucursal_info"]->id_sucursal : null;

        //-----> Obtenemos los sliders
        $data["slider"] = slider::find_all( 9 );

        //-----> Obtenemos mesas de juego
        $data["carreras"] = linea::get_races();

        //-----> Obtenemos documentos
        $data["programas"] = linea::get_programs( [ "id_sucursal" => $id_sucursal, 'id_juego' => $id_juego ] );
        // dd($data['programas']);

        //-----> Obtenemos los proveedores
        $data["torneos"] = linea::find_all_event( [ "id_sucursal" => $id_sucursal, 'id_juego' => $id_juego ] );

        //dd( $data["torneos"] );

        //-----> Obtenemos otras opciones de diversión
        $data["otras"] = linea::find_all( [ "not_in" => [ 4 ] ] );

        //-----> Obtenemos todas las sucursales
        $data["sucursales"] = sucursal::find_all();

        // -----> Acumulado
        $data['acumulado'] = linea::accumulated(['id_sucursal' => $id_sucursal,'linea' => 4]);

        $data['game'] = ( isset($request['game']) ) ? $request['game'] : null;
        // dd($data);

        return view('front.lineas.carreras',$data);
    }

    private function soapLoggin(){
        // -----> Soap
        // Hacer dowhile para la sesión
        // --> Iniciar Sesión
        if( session()->has('soapSession') && session()->has('soapCount') ){
            $soapCount = session('soapCount');
            $soapCount++;
            session()->forget('soapCount');
            session(['soapCount'=>$soapCount]);
        }
        else{
            $soap = new SoapClient('http://10.88.6.9:8080/ApuestaRemotaESB/ebws/SignOn/SignOnSitio?wsdl');
            $soap = $soap->__soapCall('SignOnSitioOp',[[
                'ip'=>'10.100.240.2',
                'idSitio'=>1,
                'usuario'=>'portal_casino',
                'password'=>'p0rt4l2047!'
            ]]);
            $data = [
                'soapSession'=>$soap,
                'soapCount'=>1
            ];
            session($data);
        }
    }

    public function deportivas( $sucursal = null){
        $this->soapLoggin();
        $data["sucursal"] = $sucursal;

        //-----> Obtenemos detalle de sucursal seleccionada
        $data["sucursal_info"] = sucursal::find_by_slug( $sucursal );
        $id_sucursal = ( $data["sucursal_info"] ) ? $data["sucursal_info"]->id_sucursal : null;

        $data['slider'] = slider::find_all( 8 ); //Obtener Sliders
        $data['promociones'] = promocion::find_all( [ "linea" => 3, "id_sucursal" => $id_sucursal ] ); //Obtener promociones
        $data["otras"] = linea::find_all( [ "not_in" => [ 3 ] ] ); // Obtenemos otras opciones de diversión
        $data['quinielas'] = slider::football_pools();// Obtenemos las quinielas


        // si no existe una solicitud para deporte, por defecto srá 5
        $dep = (\Request::input('dep') !== null) ? \Request::input('dep') : 5;
        $data['dep'] = $dep;

        if($dep == 5){

        }

        // Lista de deportes
        $soap = new SoapClient('http://10.88.6.9:8080/ApuestaRemotaESB/ebws/Deportes/ListaDeportes?wsdl&amp');
        $res = $soap->__soapCall('ListaDeportesOp',[[
            'sesion' => session('soapSession')->sesion,
            'serieMensaje' => session('soapCount')
        ]]);

        if( isset($res->descripcionError) && $res->descripcionError == "Sesion Invalida" ){
            session()->forget('soapSession');
            session()->forget('soapCount');
            $this->soapLoggin();
        }


        $data['deportes'] = $res->deporte;

        //Lista de ligas y ofertas
        $soap = new SoapClient('http://10.88.6.9:8080/ApuestaRemotaESB/ebws/Deportes/ListaAgrupadoresDeportes?wsdl');
        $res = $soap->__soapCall('ListaAgrupadoresDeportesOp',[[
            'sesion' => session('soapSession')->sesion,
            'serieMensaje' => session('soapCount'),
            'numDeporte' => $dep
        ]]);

        $ofertas = [];
        if( isset($res->deporte->ligas->liga) ){
            // dd( $res->deporte->ligas->liga );
            if( is_array($res->deporte->ligas->liga) ){
                foreach($res->deporte->ligas->liga as $key => $item){
                    $ofertas[$key]['id'] = $item->numLiga;
                    $ofertas[$key]['nombre'] = $item->nombre;
                    if( is_array($item->agrupadores->agrupador) ){
                        foreach($item->agrupadores->agrupador as $agrupador){
                            $props = [];
                            if($agrupador->proposicion){
                                if( is_array($agrupador->proposiciones->proposicion) ){
                                    foreach($agrupador->proposiciones->proposicion as $kp => $vp){
                                        $ofertas[$key]['data'][] = [
                                            'id' =>$vp->idProposicion,
                                            'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                        ];
                                    }
                                }
                                else{
                                    $vp = $agrupador->proposiciones->proposicion;
                                    $ofertas[$key]['data'][] = [
                                        'id' =>$vp->idProposicion,
                                        'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                    ];
                                }
                            }
                            else{
                                $ofertas[$key]['data'][] = [
                                    'id' => $agrupador->idAgrupador,
                                    'nombre' => $agrupador->nombre
                                ];
                            }
                        }
                    }
                    else{
                        $agrupador = $item->agrupadores->agrupador;
                        $props = [];
                        if($agrupador->proposicion){
                            if( is_array($agrupador->proposiciones->proposicion) ){
                                foreach($agrupador->proposiciones->proposicion as $kp => $vp){
                                    $ofertas[$key]['data'][] = [
                                        'id' =>$vp->idProposicion,
                                        'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                    ];
                                }
                            }
                            else{
                                $vp = $agrupador->proposiciones->proposicion;
                                $ofertas[$key]['data'][] = [
                                    'id' =>$vp->idProposicion,
                                    'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                ];
                            }
                        }
                        else{
                            $ofertas[$key]['data'][] = [
                                'id' => $agrupador->idAgrupador,
                                'nombre' => $agrupador->nombre
                            ];
                        }
                    }
                }
            }
            else{
                $key = 0;
                $item = $res->deporte->ligas->liga;
                $ofertas[$key]['id'] = $item->numLiga;
                    $ofertas[$key]['nombre'] = $item->nombre;
                    if( is_array($item->agrupadores->agrupador) ){
                        foreach($item->agrupadores->agrupador as $agrupador){
                            $props = [];
                            if($agrupador->proposicion){
                                if( is_array($agrupador->proposiciones->proposicion) ){
                                    foreach($agrupador->proposiciones->proposicion as $kp => $vp){
                                        $ofertas[$key]['data'][] = [
                                            'id' =>$vp->idProposicion,
                                            'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                        ];
                                    }
                                }
                                else{
                                    $vp = $agrupador->proposiciones->proposicion;
                                    $ofertas[$key]['data'][] = [
                                        'id' =>$vp->idProposicion,
                                        'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                    ];
                                }
                            }
                            else{
                                $ofertas[$key]['data'][] = [
                                    'id' => $agrupador->idAgrupador,
                                    'nombre' => $agrupador->nombre
                                ];
                            }
                        }
                    }
                    else{
                        $agrupador = $item->agrupadores->agrupador;
                        $props = [];
                        if($agrupador->proposicion){
                            if( is_array($agrupador->proposiciones->proposicion) ){
                                foreach($agrupador->proposiciones->proposicion as $kp => $vp){
                                    $ofertas[$key]['data'][] = [
                                        'id' =>$vp->idProposicion,
                                        'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                    ];
                                }
                            }
                            else{
                                $vp = $agrupador->proposiciones->proposicion;
                                $ofertas[$key]['data'][] = [
                                    'id' =>$vp->idProposicion,
                                    'nombre' => $agrupador->nombre . ' -> ' . $vp->nombre
                                ];
                            }
                        }
                        else{
                            $ofertas[$key]['data'][] = [
                                'id' => $agrupador->idAgrupador,
                                'nombre' => $agrupador->nombre
                            ];
                        }
                    }
            }
        }
        // dd($data);
        $data['ofertas'] = $ofertas;

         return view('front.lineas.deportiva',$data);
    }
}
