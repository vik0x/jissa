<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class privilegio extends Model{
	protected $table = 'sys_privilegios';
    protected $fillable = ['id_modulo','id_permiso','id_rol','estatus','eliminado'];
}
