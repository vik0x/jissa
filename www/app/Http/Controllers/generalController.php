<?php

namespace App\Http\Controllers;

use App\Events\dotask;
use Event;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\actividad;

class generalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $id = \Input::get('id');
        $modulo = \Input::get('modulo');
        $modulo = \DB::table('sys_modulo')
            ->select('tabla')
            ->where('id_modulo',$modulo)
            ->first();
        $modulo = $modulo->tabla;
        $tbl = \DB::select("SHOW INDEX FROM `" . $modulo . "` WHERE `Key_name` = 'PRIMARY';");
        $key = $tbl[0]->Column_name;
        $elemento = \DB::table($modulo)->where($key,$id)->first();
        echo $id;
        dd( $elemento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request,$modulo,$id){
        $id = (int)$request->id;
        if($id > 0){
            switch($modulo){
                case 'seccion':
                    $modulo = \App\seccion::find($id);
                    $mod = 1;
                break;
                case 'modulo':
                    $modulo = \App\modulo::find($id);
                    $mod = 2;
                break;
                case 'usuario':                    
                    $modulo = \App\User::find($id);
                    $mod = 3;
                break;
                case 'permiso':
                    $modulo = \App\permiso::find($id);
                    $mod = 4;
                break;
                case 'rol':
                    $modulo = \App\rol::find($id);
                    $mod = 5;
                break;
                case 'privilegio':
                    $modulo = \App\privilegio::find($id);
                    $mod = 6;
                break;
                case 'idioma':
                    $modulo = \App\idioma::find($id);
                    $mod = 7;
                break;
                case 'alimento':
                    $modulo = \App\alimento::find($id);
                    break;
                case 'proveedor':
                    $modulo = \App\proveedor::find($id);
                    break;
                case 'newsletter':
                    $modulo = \App\newsletter::find($id);
                    break;
                case 'sucursal':
                    $modulo = \App\sucursal::find($id);
                    break;
                case 'linea':
                    $modulo = \App\linea::find($id);
                    break;
                case 'contacto':
                    $modulo = \App\contacto::find($id);
                    break;
                case 'red':
                    $modulo = \App\red_social::find($id);
                    break;
                case 'pdfcarrera':
                    $modulo = \App\carrerapdf::find($id);
                    break;
                case 'juego':
                    $modulo = \App\juego::find($id);
                    break;
                case 'torneo':
                    $modulo = \App\torneo::find($id);
                    break;
                case 'slider':
                    $modulo = \App\slider::find($id);
                    break;
                case 'promocion':
                    $modulo = \App\promocion::find($id);
                    break;
                case 'calendario':
                    $modulo = \App\calendario::find($id);
                    break;
                case 'pagina_de_contenido':
                    $modulo = \App\pagina_contenido::find($id);
                    $mod = 32;
                    break;
                default:
                    dd($modulo);
                break;
            }
            $modulo->eliminado = 1;
            $evento = Event::fire(new dotask($modulo));
            // dd($evento);
            $evento = $evento[0];
            if(!$evento){
               return redirect()->back()->with('success','Eliminado correctamente');
            }
            else{
                return redirect()->back()->with('error',$evento);
            }
        }
        else{
            abort(503);
        }
    }

    public function estatus(Request $request,$modulo){
        $id = (int)$request->id;
        if(\Request::ajax() && $id > 0){
            switch($modulo){
                case 'seccion':
                    $modulo = \App\seccion::find($id);
                    $mod = 1;
                    break;

                case 'modulo':
                    $modulo = \App\modulo::find($id);
                    $mod = 2;
                    break;

                case 'usuario':                    
                    $modulo = \App\User::find($id);
                    $mod = 3;
                    break;

                case 'permiso':
                    $modulo = \App\permiso::find($id);
                    $mod = 4;
                    break;

                case 'rol':
                    $modulo = \App\rol::find($id);
                    $mod = 5;
                    break;

                case 'privilegio':
                    $modulo = \App\privilegio::find($id);
                    $mod = 6;
                    break;

                case 'idioma':
                    $modulo = \App\idioma::find($id);
                    $mod = 7;
                    break;

                case 'desarrollo':
                    $modulo = \App\desarrollo::find($id);
                    $mod = 14;
                    break;
                
                case 'prototipo':
                    $modulo = \App\prototipo::find($id);
                    $mod = 17;
                    break;
                    
                case 'centro':
                    $modulo = \App\centro::find($id);
                    $mod = 18;
                    break;

                case 'cotizador':
                    $modulo = \App\cotizador::find($id);
                    $mod = 19;
                    break;

                case 'alimento':
                    $modulo = \App\alimento::find($id);
                    break;

                case 'proveedor':
                    $modulo = \App\proveedor::find($id);
                    break;

                case 'sucursal':
                    $modulo = \App\sucursal::find($id);
                    break;
                    
                case 'linea':
                    $modulo = \App\linea::find($id);
                    break;

                case 'red':
                    $modulo = \App\red_social::find($id);
                    break;

                case 'juego':
                    $modulo = \App\juego::find($id);
                    break;

                case 'torneo':
                    $modulo = \App\torneo::find($id);
                    break;

                case 'slider':
                    $modulo = \App\slider::find($id);
                    break;

                case 'promocion':
                    $modulo = \App\promocion::find($id);
                    break;

                case 'proveedor':
                    $modulo = \App\proveedor::find($id);
                    break;

                case 'pagina_de_contenido':
                    $modulo = \App\pagina_contenido::find($id);
                    $mod = 32;
                    break;

                case 'calendario':
                    $modulo = \App\calendario::find($id);
                    break;

                default:
                    dd($modulo);
                    break;

            }
            $modulo->estatus = $modulo->estatus == 1 ? 0 : 1;
            $evento = Event::fire(new dotask($modulo));
        }
        else{
            abort(403,'No está autorizado');
        }
    }

    public function restore(Request $request,$modulo,$id){
        // dd($request->input());
        $tabla = trim($request->input('tabla'));
        $key = trim($request->input('p_k'));
        $id = (int)$id;
        $id_papelera = (int)$request->input('id_papelera');
        if($id > 0 && $id_papelera > 0){
            $tabla = $tabla == "contenido_simple" ? "pagina_contenido" : $tabla;
            $modulo = \App\modulo::where('tabla',$tabla)->first();
            $modulo = $modulo->id_modulo;
            $tabla = $tabla == "pagina_contenido" ? "contenido_simple" : $tabla;

            $data = array(
                'eliminado' => 0,
                'updated_at' => date('Y-m-d'),
            );

            // dd(\DB::table($tabla)->where($key,$id)->get());

            \DB::transaction(function() use ($id_papelera,$modulo,$data,$tabla,$key,$id){
                try{
                    $papelera = \App\papelera::find($id_papelera);
                    $papelera->status = 0;
                    $papelera->fecha_restauracion = date('Y-m-d H:i:s');
                    $actividad = new actividad;
                    $actividad->id_sesion = session('idsesion_log');
                    $actividad->id_modulo = $modulo;
                    $actividad->id_elemento = $papelera->id_elemento;
                    $actividad->id_permiso = 5;
                    $papelera->save();
                    $actividad->save();
                    \DB::table($tabla)->where($key,$id)->update($data);
                }
                catch(\Exception $e){
                   return redirect()->back()->with('error',$e->getMessage());
                }
                
            });
        }
        return redirect()->back()->with('success','El elemento fue restaurado');
    }

    public function listar(Request $request,$modulo){
        $modulo = \DB::table('sys_modulo')
            ->where('eliminado',0)
            ->where('estatus',1)
            ->where('slug',$modulo)
            ->get();
        if(count($modulo) == 1){
            $modulo = $modulo[0]->tabla;
            $lista = \DB::table($modulo)->orderBy('nombre')->select('nombre')->get();
            if(count($lista) > 0)
                echo json_encode($lista);
            else
                echo json_encode(["No hubo resultados"]);
        }
        else
            echo json_encode(['Hay problemas, inténtelo más tarde']);
    }
}
