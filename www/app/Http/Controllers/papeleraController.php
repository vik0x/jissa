<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class papeleraController extends Controller
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
    public function show($modulo,$id){
        $tabla = \DB::table('sys_modulo')->select('tabla')->where('id_modulo',$id)->get();
        // dd($tabla);
        $tabla = $tabla[0]->tabla;
        $tabla = $tabla == "pagina_contenido" ? 'contenido_simple' : $tabla;
        $tbl = \DB::select("SHOW INDEX FROM `" . $tabla . "` WHERE `Key_name` = 'PRIMARY';");
        $key = $tbl[0]->Column_name;
        $nombre = $tabla == 'red_social' ? 'link' : 'nombre';
        $nombre = $tabla == 'torneo' || $tabla == 'calendario_pago' || $tabla == 'slider' || $tabla == 'contenido_simple'|| $tabla == 'carrerapdf' ? 'titulo' : 'nombre';
        $elemento = \DB::table('sys_papelera as p')
            ->select(
                'p.id_papelera as id_papelera',
                'md.' . $key .' as id',
                'md.' . $nombre .' as nombre',
                \DB::raw('CONCAT(u.nombre," ",u.apellido) as elimino'),
                'p.created_at as eliminado',
                'm.slug as modulo'
            )
            ->join('sys_modulo as m','m.id_modulo','=','p.id_tipo')
            ->join('log_session as s','s.id_sesion','=','p.id_sesion')
            ->join('sys_usuario as u','u.id_usuario','=','s.id_usuario')
            ->join($tabla . ' as md','md.' . $key,'=','p.id_elemento')
            ->where('p.id_tipo',$id)
            ->where('p.status',1)
            ->get();
        // dd($elemento);
        $data = array(
            'tabla' => $tabla,
            'p_k' => $key,
            'elementos' => $elemento,
            'modulo' => $id,
        );
        // dd($data);
        return view('back.papelera.show',$data);
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
    public function destroy($id){}
}
