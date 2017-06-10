<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class permiso extends Model{
	protected $table = 'sys_permiso';
    protected $fillable = ['nombre','estatus','accion'];
    protected $primaryKey = 'id_permiso';
}
