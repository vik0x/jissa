<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class modulo extends Model{
	protected $table = 'sys_modulo';
    protected $fillable = ['id_seccion','nombre','slug','descripcion','tabla'];
    protected $primaryKey = 'id_modulo';
}
