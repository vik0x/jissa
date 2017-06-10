<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sesion extends Model{
	protected $table = 'log_session';
    protected $fillable = ['id_usuario','token','ip'];
    protected $primaryKey = 'id_sesion';
}