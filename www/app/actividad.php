<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class actividad extends Model{
	protected $table = 'log_actividad';
    protected $fillable = ['id_sesion','id_modulo','id_permiso','created_at','updated_at','id_elemento'];
    protected $primaryKey = 'id_actividad';
}