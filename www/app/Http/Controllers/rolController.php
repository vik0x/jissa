<?php
// módulo número 5
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\dotask;
use Event;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\rol;
class rolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('back.rol.index',['roles'=>\App\rol::where('eliminado',0)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('back.rol.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $descripcion = trim($request->descripcion);
        $nombre = trim($request->nombre);
        if($nombre == "")
            return redirect()->back()->with('error','Faltan datos en el formulario');
        $rol = new rol;
        $rol->nombre = mb_strtoupper($nombre);
        if($descripcion != "")
            $rol->descripcion = $descripcion;
        $evento = Event::fire(new dotask($rol));
        $evento = $evento[0];
        if(!$evento){
            return redirect(url('/administrador/rol.html'))->with('success','Rol agregado correctamente');
        }
        else{
            return redirect(url('/administrador/rol.html'))->with('error',$evento);
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
        $id = (int)$id;
        if($id > 0){
            $data = array(
                'rol' => \App\rol::find($id),
                'id' => $id,
            );
            return view('back.rol.edit',$data);
        }
        else{
            return redirect(url('/administrador/rol.html'))->wit('error','Error Inesperado');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        // dd($request->input());
        $descripcion = trim($request->input('descripcion'));
        $nombre = trim($request->input('nombre'));
        if($nombre == "" || $id < 1)
            return redirect()->back()->with('error','Faltan datos en el formulario');
        $rol = \App\rol::find($id);
        $rol->nombre = mb_strtoupper($nombre);
        if($descripcion == "")
            $rol->descripcion = NULL;
        else
            $rol->descripcion = $descripcion;
        $evento = Event::fire(new dotask($rol));
        $evento = $evento[0];
        if(!$evento){
            return redirect(url('/administrador/rol.html'))->with('success','Rol modificado correctamente');
        }
        else{
            return redirect(url('/administrador/rol.html'))->with('error',$evento);
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
            $usuario = \App\rol::find($id);
            $usuario->estatus = $usuario->estatus == 1 ? 0 : 1;
            $usuario->save();
        }
        else{
            abort(403,'No está autorizado');
        }
    }
}
