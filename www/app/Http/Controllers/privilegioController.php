<?php
// módulo número 6
namespace App\Http\Controllers;

use App\Events\dotask;
use Event;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\privilegio;

class privilegioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id){
        $id = (int)$id;
        if($id > 0){
            $matriz = \App\privilegio::where('id_rol',$id)
                // ->where('activo',1)
                ->where('eliminado',0)
                ->get();

            if(count($matriz) > 0 ){
                foreach($matriz as $val){
                    $privilegio[$val->id_modulo][$val->id_permiso]=1;
                }
            }
            else{
                $privilegio = array();
            }
            $data = array(
                'id' => $id,
                'rol' => \App\rol::find($id),
                'permisos' => \App\permiso::where('estatus',1)->where('eliminado',0)->get(),
                'modulos' => \App\modulo::where('eliminado',0)->where('estatus',1)->get(),
                'privilegio' => $privilegio,
            );
            return view('back.privilegio.index',$data);
        }
        else{
            abort(503);
        }
    }

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
    public function store(Request $request,$id){
        $id = (int)$id;
        if($id > 0){
            $privilegios = $request->input('privilegio');
            if(is_array($privilegios)){
                foreach($privilegios as $key => $val){
                    foreach($val as $k => $v){
                        $data[] = array(
                            'id_rol' => $id,
                            'id_modulo' => $key,
                            'id_permiso' => $k
                        );
                    }
                }
                \App\privilegio::where('id_rol',$id)->delete();
                if(\DB::table('sys_privilegios')->insert($data)){
                    return redirect(url('/administrador/rol.html'))->with('success','Guardado correctamente');
                }
                else{
                    return redirect()->back()->with('error','Hubo un error en la base de datos');
                }
            }
            else{
                \App\privilegio::where('id_rol',$id)->delete();
                return redirect('administrador/rol.html')->with('danger','Se han quitado todos los permisos para este rol');
            }
        }
        else{
            return redirect()->back()->with('error','Hubo un error, inténtelo de nuevo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){}

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
    public function destroy($id){}
}
