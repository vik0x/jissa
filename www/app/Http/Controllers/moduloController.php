<?php
//modulo número 2
namespace App\Http\Controllers;

use App\Events\dotask;
use Event;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\modulo;

class moduloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = array(
            'modulos' => \App\modulo::select(
                    'sys_modulo.id_modulo',
                    'ss.nombre as seccion',
                    'sys_modulo.nombre',
                    'sys_modulo.slug',
                    'sys_modulo.descripcion',
                    'sys_modulo.estatus',
                    \DB::raw('2 as modulo')
                )
                ->join('sys_seccion as ss','ss.id_seccion','=','sys_modulo.id_seccion')
                ->where('sys_modulo.eliminado',0)
                ->orderBy('sys_modulo.nombre')
                ->paginate(10),
        );
        return view('back.modulo.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data = array(
            'secciones' => \App\seccion::select('id_seccion as id','nombre')->get(),
            'tablas' => \DB::select('show tables'),
        );
        return view('back.modulo.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $nombre = trim($request->input('nombre'));
        $seccion = (int)$request->input('seccion');
        $slug = trim($request->input('slug'));
        $descripcion = trim($request->input('descripcion'));
        $tabla = trim($request->input('tabla'));
        if($nombre != "" && $slug != "" && $tabla != "" && $seccion > 0){
            $modulo = new modulo;
            $modulo->id_seccion = $seccion;
            $modulo->nombre = $nombre;
            $modulo->slug = $slug;
            $modulo->descripcion = $descripcion;
            $modulo->tabla = $tabla;
            $evento = Event::fire(new dotask($modulo));
            $evento = $evento[0];
            if(!$evento){
                return redirect(url('/administrador/modulo.html'))->with('success','Módulo agregado correctamente');
            }
            else{
                return redirect(url('/administrador/modulo.html'))->with('error',$evento);
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
    public function show($id){
        $id = \Input::get('id');
        $modulo = \Input::get('modulo');
        $modulo = \DB::table('sys_modulo as m')
            ->select('m.*','s.nombre as seccion')
            ->join('sys_seccion as s','s.id_seccion','=','m.id_seccion')
            ->where('id_modulo',$id)
            ->first();
        ?>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h5>Nombre: <small><?php echo $modulo->nombre; ?></small></h5>
                <h5>Tabla (DB) <small><?php echo $modulo->tabla; ?></small></h5>
                <h5>Parte de URL <small><?php echo $modulo->slug; ?></small></h5>
                <h5><?php echo $modulo->estatus == 1 ? "Activo" : "Inactivo"; ?></h5>
                <?php echo $modulo->eliminado == 1 ? '<h5 class="text-center alert-danger">Eliminado</h5>' : ''; ?>
                <h5>Descripción</h5>
                <?php echo $modulo->descripcion; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = array(
            'secciones' => \App\seccion::select('id_seccion as id','nombre')->get(),
            'tablas' => \DB::select('show tables'),
            'modulo' => \App\modulo::find($id),
            'id'=>$id,
        );
        return view('back.modulo.edit',$data);
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
            $seccion = (int)$request->input('seccion');
            $slug = trim($request->input('slug'));
            $descripcion = trim($request->input('descripcion'));
            $tabla = trim($request->input('tabla'));
            if($nombre != "" || $slug = "" || $seccion > 0){
                $modulo = \App\modulo::find($id);
                $modulo->id_seccion = $seccion;
                $modulo->nombre = $nombre;
                $modulo->slug = $slug;
                $modulo->tabla = $tabla;
                $modulo->descripcion = $descripcion;
                $evento = Event::fire(new dotask($modulo));
                $evento = $evento[0];
                if(!$evento){
                    return redirect(url('/administrador/modulo.html'))->with('success','Modulo modificado correctamente');
                }
                else{
                    return redirect(url('/administrador/modulo.html'))->with('error',$evento);
                }
            }
            else{
                return redirect()->back()->with('error','Faltan datos en el formulario');
            }            
        }
        return redirect(url('/administrador/modulo.html'))->with('error','Error');
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
            $usuario = \App\modulo::find($id);
            $usuario->estatus = $usuario->estatus == 1 ? 0 : 1;
            $usuario->save();
        }
        else{
            abort(403,'No está autorizado');
        }
    }
}
