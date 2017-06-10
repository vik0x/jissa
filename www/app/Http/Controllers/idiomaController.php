<?php
// módulo número 7
namespace App\Http\Controllers;

use App\Events\dotask;
use Event;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\idioma;

class idiomaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // dd(session()->all());
        $data=array(
            'idiomas' => \App\idioma::orderBy('estatus','DESC')->orderBy('nombre')->where('eliminado',0)->get(),
        );
        return view('back.idioma.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('back.idioma.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $nombre = trim($request->input('nombre'));
        if($nombre != ""){
            $idioma = new idioma;
            $idioma->nombre = $nombre;
            $evento = Event::fire(new dotask($idioma));
            $evento = $evento[0];
            if(!$evento){
                return redirect(url('/administrador/idioma.html'))->with('success','Idioma agregado correctamente');
            }
            else{
                return redirect(url('/administrador/idioma.html'))->with('error',$evento);
            }
        }
        else return redirect()->back()->with('error','Faltan datos en el formulario');
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
                'idioma' => \App\idioma::find($id),
                'id' => $id,
            );
            if(count($data['idioma']) < 1)
                return redirect()->back()->with('danger','No existe el registro');
            return view('back.idioma.edit',$data);
        }
        else{
            return redirect()->back()->with('error','Datos no esperados');
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
        $nombre = trim($request->input('nombre'));
        $id = (int)$id;
        if($nombre != "" && $id > 0){
            $idioma = \App\idioma::find($id);
            $idioma->nombre = $nombre;
            $evento = Event::fire(new dotask($idioma));
            $evento = $evento[0];
            if(!$evento){
                return redirect(url('/administrador/idioma.html'))->with('success','Modificado correctamente');
            }
            else{
                return redirect(url('/administrador/idioma.html'))->with('error',$evento);
            }
        }
        else return redirect()->back()->with('error','Faltan datos en el formulario');
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
            $usuario = \App\idioma::find($id);
            $usuario->estatus = $usuario->estatus == 1 ? 0 : 1;
            $usuario->save();
        }
        else{
            abort(403,'No está autorizado');
        }
    }
}
