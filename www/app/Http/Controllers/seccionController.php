<?php
// módulo número 1
namespace App\Http\Controllers;

use App\Events\dotask;
use Event;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\seccion;
// use App\Models\seccion_model as seccion;

class seccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = array(
            // 'secciones' => \App\seccion::where('eliminado',0)
            //     ->get(),
            'secciones' => \App\Models\seccion_model::all()
        );
        return view('back.seccion.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('back.seccion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $nombre = trim($request->nombre);
        $slug = trim($request->slug);
        $descripcion = trim($request->descripcion);
        $orden = trim($request->orden);

        if($nombre != "" && $slug != ""){
            $seccion = new seccion;
            $seccion->nombre = $nombre;
            $seccion->slug = $slug;
            $seccion->descripcion = $descripcion;
            $seccion->orden = $orden;
            $evento = Event::fire(new dotask($seccion));
            $evento = $evento[0];
            if(!$evento){
                return redirect(url('/administrador/seccion.html'))->with('success','Sección agregada correctamente');
            }
            else{
                return redirect(url('/administrador/seccion.html'))->with('error',$evento);
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
            'seccion' => seccion::find($id),
        );
        return view('back.seccion.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $nombre = trim($request->nombre);
        $slug = trim($request->slug);
        $descripcion = trim($request->descripcion);
        $orden = trim($request->orden);

        if($nombre != "" || $slug != ""){
            $seccion = seccion::find($id);
            $seccion->nombre = $nombre;
            $seccion->slug = $slug;
            $seccion->descripcion = $descripcion;
            $seccion->orden = $orden;
            $evento = Event::fire(new dotask($seccion));
            $evento = $evento[0];
            if(!$evento){
                return redirect(url('/administrador/seccion.html'))->with('success','Sección modificada correctamente');
            }
            else{
                return redirect(url('/administrador/seccion.html'))->with('error',$evento);
            }
        }
        else{
            return redirect()->back()->with('error','Faltan datos en el formulario');
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
            $usuario = \App\seccion::find($id);
            $usuario->estatus = $usuario->estatus == 1 ? 0 : 1;
            $usuario->save();
        }
        else{
            abort(404,'No está autorizado');
        }
    }
}
