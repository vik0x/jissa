<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class papelera extends Model{
	protected $table = 'sys_papelera';
    protected $fillable = ['id_sesion','id_tipo','id_elemento','status','fecha_restauracion'];
    protected $primaryKey = 'id_papelera';
}