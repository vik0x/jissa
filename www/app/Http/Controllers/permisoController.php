<?php
// módulo número 4
namespace App\Http\Controllers;

use App\Events\dotask;
use Event;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\permiso;
class permisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = array(
            'permisos' => \App\permiso::where('eliminado',0)->get()
        );
        return view('back.permiso.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('back.permiso.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $nombre = trim($request->input('nombre'));
        $accion = trim($request->input('slug'));
        if($nombre != "" && $accion != ""){
            $permiso = new permiso;
            $permiso->nombre = $nombre;
            $permiso->accion = $accion;

            $evento = Event::fire(new dotask($permiso));
            $evento = $evento[0];
            if(!$evento){
                return redirect(url('/administrador/permiso.html'))->with('success','Permiso almacenado correctamente');
            }
            else{
                return redirect(url('/administrador/permiso.html'))->with('error',$evento);
            }
        }
        else{
            return redirect()->back()->with('error','Faltan datos en el formulario');
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
    public function edit($id){
        $data = array(
            'id' => $id,
            'permiso' => \App\permiso::find($id),
        );
        return view('back.permiso.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $id = (int)$id;
        if($id > 0){
            $nombre = trim($request->input('nombre'));
            $accion = trim($request->input('slug'));
            if($nombre != "" ){
                $permiso = \App\permiso::find($id);
                $permiso->nombre = $nombre;
                $permiso->accion = $accion;
                $evento = Event::fire(new dotask($permiso));
                $evento = $evento[0];
                if(!$evento){
                    return redirect(url('/administrador/permiso.html'))->with('success','Permiso modificado correctamente');
                }
                else{
                    return redirect(url('/administrador/permiso.html'))->with('error',$evento);
                }
            }
            else{
                return redirect()->back()->with('error','Faltan datos en el formulario');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){}

    public function estatus(Request $request){
       $id = (int)$request->id;
        if(\Request::ajax() && $id > 0){
            $usuario = \App\permiso::find($id);
            $usuario->estatus = $usuario->estatus == 1 ? 0 : 1;
            $usuario->save();
        }
        else{
            abort(403,'No está autorizado');
        }
    }
}
