<?php
namespace App\Models;
use App\seccion;
class seccion_model{
	static function all(){
		$seccion = \DB::table('sys_seccion as s')->where('eliminado',0)->get();
		return $seccion;
	}

	static function find($id){
		return seccion::find($id);
	}
};
