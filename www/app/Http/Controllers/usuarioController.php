<?php
// módulo número 3

namespace App\Http\Controllers;

use App\Events\dotask;
use Event;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = array(
            'usuarios' => \App\User::select('id_usuario as id',
                    \DB::raw('CONCAT(sys_usuario.nombre," ",apellido) as nombre'),
                    'r.nombre as rol',
                    'telefono as tel',
                    'sys_usuario.imagen_perfil as foto',
                    'sys_usuario.estatus as activo',
                    \DB::raw('3 as modulo')
                )
                ->join('sys_rol as r','r.id_rol','=','sys_usuario.id_rol')
                ->where('sys_usuario.eliminado',0)
                ->orderBy('activo','DESC')
                ->orderBy('nombre')
                ->get(),
        );
        // dd($data);
        return view('back.usuario.index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $data = array(
            'roles' => \DB::table('sys_rol')->
                select('id_rol as id','nombre')
                ->where('estatus',1)
                ->where('eliminado',0)
                ->get(),
        );
        if(count($data['roles']) < 1)
            return redirect()->back()->with('error','No hay roles de usuario');
        return view('back.usuario.create',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // $this->validate($request, [
        //     'nombre' => 'required|min:13'
        // ]);

        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $email = $request->input('email');
        $password = $request->input('password');
        $telefono = $request->input('telefono');
        $rol = $request->input('rol');
        $password = \Hash::make($password);
        $usuario = \App\User::where('email','=',$email)->get();
        if(count($usuario) > 0)
            return redirect()->back()->with('error','El correo ya existe');
        $usuario = new User;
        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;
        $usuario->email = $email;
        $usuario->password = $password;
        $usuario->telefono = $telefono;
        $usuario->id_rol = $rol;
        $evento = Event::fire(new dotask($usuario));
        $evento = $evento[0];
        if(!$evento){
            if($request->hasFile('imagen')){
                $archivo = $request->file('imagen');
                $ext = strtolower($archivo->getClientOriginalExtension());
                $extValidas = ['jpg','jpeg','png'];
                if(in_array($ext, $extValidas)){
                    $carpeta = 'assets/img/profiles/';
                    if(!file_exists(public_path() . '/' . $carpeta))
                        mkdir(public_path() . '/' . $carpeta,0777,true);
                    $nombre = $usuario->id_usuario . "." .$ext;
                    if($archivo->move(public_path() . '/' . $carpeta , $nombre)){
                        $usuario->imagen_perfil = $carpeta.$nombre;
                        $evento = Event::fire(new dotask($usuario));
                        $evento = $evento[0];
                        if($evento)
                            return redirect(url('/administrador/usuario.html'))->with('error',$evento);

                    }
                    else{
                        return redirect(url('/administrador/usuario.html'))->with('error','No se pudo guardar la imagen de perfil');
                    }
                }
                else{
                    return redirect(url('/administrador/usuario.html'))->with('error','Tipo de imagen de perfil no válida');
                }
            }
            return redirect(url('/administrador/usuario.html'))->with('success','El usuario fue modificado exitosamente');
        }
        else{
            return redirect(url('/administrador/usuario.html'))->with('error',$evento);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $usuario = \DB::table('sys_usuario as u')
            ->join('sys_rol as r','r.id_rol','=','u.id_rol')
            ->select(\DB::raw('u.*'),'r.nombre as rol')
            ->where('u.id_usuario',$id)
            ->first(); 
        // return view('back.usuario.index');
            ?>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="card card-user">
                        <div class="image">
                            <img src="<?php echo asset('/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg'); ?>" alt="...">
                        </div>
                        <div class="content">
                            <div class="author">
                                 <a href="#">
                                <img class="avatar border-gray" src="<?php echo asset($usuario->imagen_perfil); ?>" alt="...">

                                  <h4 class="title"><?php echo $usuario->nombre . " " . $usuario->apellido ; ?><br>
                                     <small><?php echo $usuario->rol; ?></small>
                                  </h4>
                                </a>
                            </div>
                            <p class="description text-center">
                                <h5 class="text-center">Correo: <small><?php echo $usuario->email; ?></small></h5>
                                <h5 class="text-center">Teléfono: <small><?php echo $usuario->telefono; ?></small></h5>
                                <h5 class="text-center"><?php echo $usuario->estatus == 1 ? "Activo" : "Inactivo"; ?></h5>
                                <?php echo $usuario->eliminado == 1 ? '<h5 class="text-center alert-danger">Eliminado</h5>' : ''; ?>
                            </p>
                        </div>
                        <hr>
                        <div class="text-center">
                            <br>

                        </div>
                    </div>
                </div>
            </div>
            <?php
        // "id_rol" => 1
        // "nombre" => "Abargon"
        // "apellido" => "Administrador"
        // "email" => "administrador@abargon.com"
        // "telefono" => "3399023"
        // "imagen_perfil" => "assets/img/profiles/2.jpg"
        // "estatus" => 1
        // "eliminado" => 0
        // dd($usuario);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = array(
            'id' => $id,
            'usuario' => \App\User::find($id),
            'roles' => \DB::table('sys_rol')->
                select('id_rol as id','nombre')
                ->where('estatus',1)
                ->where('eliminado',0)
                ->get(),
        );
        return view('back.usuario.edit',$data);
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
        $apellido = trim($request->input('apellido'));
        $email = trim($request->input('email'));
        $password = trim($request->input('password'));
        $telefono = trim($request->input('telefono'));
        $rol = (int)$request->input('rol');
        $usuario = \App\User::where('email','=',$email)->get();
        $usuario = \App\User::find($id);
        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;
        $usuario->email = $email;
        if($password != ""){
            $password = \Hash::make($password);
            $usuario->password = $password;
        }
        $usuario->telefono = $telefono;
        $usuario->id_rol = $rol;

        $evento = Event::fire(new dotask($usuario));
        $evento = $evento[0];
        if(!$evento){
            if($request->hasFile('imagen')){
                $archivo = $request->file('imagen');
                $ext = strtolower($archivo->getClientOriginalExtension());
                $extValidas = ['jpg','jpeg','png'];
                if(in_array($ext, $extValidas)){
                    $carpeta = 'assets/img/profiles/';
                    if(!file_exists(public_path() . '/' . $carpeta))
                        mkdir(public_path() . '/' . $carpeta,0777,true);
                    $nombre = $usuario->id_usuario . "." .$ext;
                    if($archivo->move(public_path() . '/' . $carpeta , $nombre)){
                        $usuario->imagen_perfil = $carpeta.$nombre;
                        $evento = Event::fire(new dotask($usuario));
                        $evento = $evento[0];
                        if($evento)
                            return redirect(url('/administrador/usuario.html'))->with('error',$evento);

                    }
                    else{
                        return redirect(url('/administrador/usuario.html'))->with('error','No se pudo guardar la imagen de perfil');
                    }
                }
                else{
                    return redirect(url('/administrador/usuario.html'))->with('error','Tipo de imagen de perfil no válida');
                }
            }
            return redirect(url('/administrador/usuario.html'))->with('success','El usuario fue modificado exitosamente');
        }
        else{
            return redirect(url('/administrador/usuario.html'))->with('error',$evento);
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
            $usuario = \App\User::find($id);
            $usuario->estatus = $usuario->estatus == 1 ? 0 : 1;
            $usuario->save();
        }
        else{
            abort(403,'No está autorizado');
        }
    }
}
