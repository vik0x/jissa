<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seccion extends Model{
	protected $table = 'sys_seccion';
    protected $fillable = ['nombre','descripcion','slug','orden','estatus','eliminado'];
    protected $primaryKey = 'id_seccion';
}