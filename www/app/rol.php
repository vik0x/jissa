<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rol extends Model{
	protected $table = 'sys_rol';
    protected $fillable = ['nombre','descripcion','estatus','eliminado'];
    protected $primaryKey = 'id_rol';
}