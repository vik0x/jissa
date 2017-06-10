<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class idioma extends Model{
	protected $table = 'sys_idioma';
    protected $fillable = ['nombre','estatus','eliminado'];
    protected $primaryKey = 'id_idioma';
}