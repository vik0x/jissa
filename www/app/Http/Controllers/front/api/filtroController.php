<?php

namespace App\Http\Controllers\front\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\front\linea_model as linea;
use App\Models\front\sucursal_model as sucursal;
use SoapClient;

class filtroController extends Controller
{
    private function mes($mes){
        $mes = (int)$mes;
        switch($mes){
            case 1:
                return "Enero";
                break;
            case 2:
                return "Febrero";
                break;
            case 3:
                return "Marzo";
                break;
            case 4:
                return "Abril";
                break;
            case 5:
                return "Mayo";
                break;
            case 6:
                return "Junio";
                break;
            case 7:
                return "Julio";
                break;
            case 8:
                return "Agosto";
                break;
            case 9:
                return "Septiembre";
                break;
            case 10:
                return "Octubre";
                break;
            case 11:
                return "Noviembre";
                break;
            case 12:
                return "Diciembre";
                break;
        }
    }
    public function filtro_maquinas(Request $request)
    {
        
        if($request->ajax()){

            $id_categoria = $request->input('id_categoria');
            $id_categoria == "" ? $id_categoria = null : $id_categoria = $id_categoria;

            $slug_sucursal = $request->input('slug_sucursal'); 
            $slug_sucursal == -1 ? $slug_sucursal = null : $slug_sucursal = $slug_sucursal;            
            
            $ids_maquinas = $request->input('ids_maquinas'); 
            $ids_maquinas == "" ? $ids_maquinas = null : $ids_maquinas = $ids_maquinas;

            $limit = $request->input('limit');
            
            $linea = $request->input('linea');
            $linea == "" ? $linea = null : $linea = $linea;

            if ($slug_sucursal == null) {
                $id_sucursal = null;
            }else{
                $suc = sucursal::get_sucursal($slug_sucursal);                     
                $id_sucursal = $suc[0]->id_sucursal;                       
            }   

            echo json_encode(linea::get_games( [ "linea" => $linea, "id_sucursal" => $id_sucursal, "id_categoria" => $id_categoria, "not_id" => $ids_maquinas, "limit" => $limit ] ) );
        }
        else
            abort(403);
    }

    public function get_lineas(Request $request){
        if( $request->ajax() ){
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
                    'idSitio'=>1
                ]]);
                $data = [
                    'soapSession'=>$soap,
                    'soapCount'=>1
                ];
                // session($data);
            }

            $soap = new SoapClient('http://10.88.6.9:8080/ApuestaRemotaESB/ebws/Deportes/ListaEventosDeportes?wsdl');
            if( $request->input('oferta') == "E589"){
                $linea = $soap->__soapCall('ListaEventosDeportesOp',[[
                    'sesion'=>session('soapSession')->sesion,
                    'numDeporte' => $request->input('deporte'),
                    'idAgrupador'=> $request->input('oferta'),
                    'numLiga'=> $request->input('liga'),
                    "proposicion" => true
                ]]);
            }
            else{
                $linea = $soap->__soapCall('ListaEventosDeportesOp',[[
                    'sesion'=>session('soapSession')->sesion,
                    'numDeporte' => $request->input('deporte'),
                    'idAgrupador'=> $request->input('oferta'),
                    'numLiga'=> $request->input('liga'),
                ]]);
            }
            // dd($linea);
            $data = [];
            if( isset($linea->evento) ){
                if( is_array($linea->evento) ){
                    foreach($linea->evento as $key => $item ){
                        $data[$key]['fecha'] = date('Y-m-d',strtotime($item->fecha));
                        $data[$key]['hora'] = date('h:iA',strtotime($item->fecha));
                        if( is_array($item->bis->bi) ){
                            foreach($item->bis->bi as $val){
                                if( mb_strtoupper(trim($val->estado)) == "DISPONIBLE" ){
                                    $data[$key]['data'][] = [
                                        'id_apuesta' => $val->numBi,
                                        'nombre' => $val->contendiente->nombre,
                                        'puntos' => trim($item->apuestaPorOmision) == "LINPUNTOS" ? $val->linPuntos->puntos : $val->linDinero->linea,
                                        'linea' => 0
                                    ];
                                    if( $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] > 0 )
                                        $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] = "+" . $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'];
                                    if( trim($item->apuestaPorOmision) == "LINPUNTOS" && isset($val->linDinero->linea) )
                                        $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] .= $val->linDinero->linea > 0 ? "</h2><h2> +" . $val->linDinero->linea : "</h2><h2>" . $val->linDinero->linea;

                                }
                            }
                        }
                        else{
                            $val = $item->bis->bi;
                            if( mb_strtoupper(trim($val->estado)) == "DISPONIBLE" ){
                                $data[$key]['data'][] = [
                                    'id_apuesta' => $val->numBi,
                                    'nombre' => $val->contendiente->nombre,
                                    'puntos' =>  trim($item->apuestaPorOmision) == "LINPUNTOS" ? $val->linPuntos->puntos : $val->linDinero->linea,
                                    'linea' => 0
                                ];
                                if( $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] > 0 )
                                                                        $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] = "+" . $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'];
                                                                    if( trim($item->apuestaPorOmision) == "LINPUNTOS" && isset($val->linDinero->linea) )
                                                                        $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] .= $val->linDinero->linea > 0 ? "</h2><h2> +" . $val->linDinero->linea : "</h2><h2>" . $val->linDinero->linea;
                            }
                        }
                        if( count($data[$key]['data']) <= 2 && trim(mb_strtoupper($item->total->altas->estado)) == "DISPONIBLE"){
                            $data[$key]['overunder'] = [
                                'puntos' => $item->total->altas->puntos,
                                'linea' => $item->total->altas->linea
                            ];
                            if( $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] > 0 )
                                                                    $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] = "" . $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'];
                                                                // if( trim($item->apuestaPorOmision) == "LINPUNTOS" && isset($val->linDinero->linea) )
                                                                //     $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] .= $val->linDinero->linea > 0 ? "</h2><h2> +" . $val->linDinero->linea : "</h2><h2>" . $val->linDinero->linea;
                        }
                    }
                }
                else{
                    $key = 0;
                    $item = $linea->evento;
                    $data[$key]['fecha'] = date('Y-m-d',strtotime($item->fecha));
                    $data[$key]['hora'] = date('h:iA',strtotime($item->fecha));
                    if( is_array($linea->evento->bis->bi) ){
                        foreach($linea->evento->bis->bi as $val){
                            if( mb_strtoupper(trim($val->estado)) == "DISPONIBLE" ){
                                $data[$key]['data'][] = [
                                    'id_apuesta' => $val->numBi,
                                    'nombre' => $val->contendiente->nombre,
                                    'puntos' =>  trim($item->apuestaPorOmision) == "LINPUNTOS" ? $val->linPuntos->puntos : $val->linDinero->linea,
                                    'linea' => 0
                                ];
                                if( $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] > 0 )
                                                                        $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] = "+" . $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'];
                                                                    if( trim($item->apuestaPorOmision) == "LINPUNTOS" && isset($val->linDinero->linea) )
                                                                        $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] .= $val->linDinero->linea > 0 ? "</h2><h2> +" . $val->linDinero->linea : "</h2><h2>" . $val->linDinero->linea;
                            }
                        }
                    }
                    else{
                        $val = $linea->evento->bis->bi;
                        if( mb_strtoupper(trim($val->estado)) == "DISPONIBLE" ){
                            $data[$key]['data'][] = [
                                'id_apuesta' => $val->numBi,
                                'nombre' => $val->contendiente->nombre,
                                'puntos' =>  trim($item->apuestaPorOmision) == "LINPUNTOS" ? $val->linPuntos->puntos : $val->linDinero->linea,
                                'linea' => 0
                            ];
                            if( $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] > 0 )
                                                                    $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] = "+" . $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'];
                                                                if( trim($item->apuestaPorOmision) == "LINPUNTOS" && isset($val->linDinero->linea) )
                                                                    $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] .= $val->linDinero->linea > 0 ? "</h2><h2> +" . $val->linDinero->linea : "</h2><h2>" . $val->linDinero->linea;
                        }
                    }
                    if( isset($data[$key]['data']) && count($data[$key]['data']) <= 2 && trim(mb_strtoupper($item->total->altas->estado)) == "DISPONIBLE"){
                        $data[$key]['overunder'] = [
                            'puntos' => $item->total->altas->puntos,
                            'linea' => $item->total->altas->linea
                        ];
                        if( $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] > 0 )
                                                                $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] = "+" . $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'];
                                                            if( trim($item->apuestaPorOmision) == "LINPUNTOS" && isset($val->linDinero->linea) )
                                                                $data[$key]['data'][count($data[$key]['data']) - 1]['puntos'] .= $val->linDinero->linea > 0 ? "</h2><h2> +" . $val->linDinero->linea : "</h2><h2>" . $val->linDinero->linea;
                    }
                }

                $info = [];
                foreach($data as $key => $val){
                    $info[$val['fecha']][] = $key;
                }

                $data2 = [];
                $c = 0;
                // dd($data);
                foreach($info as $num => $val){
                    $data2[$c]['fecha_data'] = date('m/d/Y',strtotime($num));
                    $data2[$c]['fecha'] = date('d',strtotime($num)) . " " . $this->mes(date('m',strtotime($num))) . " " . date('Y',strtotime($num));
                    foreach($val as $key){
                        unset($data[$key]['fecha']);
                        if( isset($data[$key]['data']) ){
                            // foreach($data[$key]['data'] as )
                            $data2[$c]['data'][] = $data[$key]['data'];
                            $data2[$c]['hora'][] = $data[$key]['hora'];
                            if( isset($data[$key]['overunder']) )
                                $data2[$c]['overunder'][] = $data[$key]['overunder'];
                        }
                    }
                    if( !array_key_exists('data', $data2[$c]) ){
                        unset($data2[$c]);
                    }
                    $c++;
                }
            }


            // $data['fecha'] = date('Y-m-d h:iA',strtotime($linea->fecha));

            echo json_encode($data2);
        }
        else
            abort(403);
    }

    public function get_mesa(Request $request)
    {
        if($request->ajax())
        {
            $id_mesa = $request->input('id_mesa');
            $id_sucursal = $request->input('id_sucursal');

            $id_mesa = (int)$id_mesa > 0 ? $id_mesa : null;
            $id_sucursal = (int)$id_sucursal > 0 ? $id_sucursal : null;

            echo json_encode( linea::get_games_table( [ "id" => $id_mesa, 'id_sucursal'=>$id_sucursal ] ) );

        }
        else
            abort(403);

    }
}