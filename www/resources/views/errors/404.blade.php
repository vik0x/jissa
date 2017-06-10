<?php 
$data = \DB::table('error')->where('id','404')->first();
?>
{!!$data->cuerpo!!}
