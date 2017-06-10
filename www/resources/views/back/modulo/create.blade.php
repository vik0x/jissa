@extends('layout.admin')
	@section('script')
		<script src="{{asset('/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
		<script>
		$(function(){
			$('#form-agregar').validate();
		});
		</script>
	@stop

	@section('contenido')
		<div class="col-lg-7 col-md-6 col-md-offset-3">
		<!-- START PANEL -->
		<div class="panel panel-transparent">
	  		<div class="panel-body">
			    <form id="form-agregar" role="form" autocomplete="off" method="POST" action="{{url('/administrador/agregar/modulo.html')}}">
			    	{!!csrf_field()!!}
			    	<input type="hidden" name="_method" value="PUT">
		      		<div class="row clearfix">
			        	<div class="col-sm-12">
			          		<div class="form-group form-group-default" aria-required="true">
			            		<label for="nombre">Nombre</label>
			            		<input type="text" id="nombre" class="form-control required" name="nombre" required="required" aria-required="true" aria-invalid="true">
			          		</div>
			        	</div>
			      	</div>
			      	<div class="row">
			        	<div class="col-sm-12">
			          		<div class="form-group form-group-default">
			            		<label for="seccion">Sección</label>
			            		<select id="seccion" class="form-control" name="seccion" aria-required="true" aria-invalid="true">
			            			<option value="0">Seleccione una</option>
			            			@foreach($secciones as $seccion)
			            			<option value="{{$seccion->id}}">{{$seccion->nombre}}</option>
			            			@endforeach
			            		</select>
			          		</div>
			          	</div>
			      	</div>
			      	<div class="row">
			        	<div class="col-sm-12">
			          		<div class="form-group form-group-default">
			            		<label for="tabla">Tabla</label>
			            		<select name="tabla" id="tabla" class="form-control">
			            			@foreach($tablas as $tabla)
			            			<option value="{{current($tabla)}}">{{current($tabla)}}</option>
			            			@endforeach
			            		</select>
			          		</div>
			          	</div>
			      	</div>
			      	<div class="row">
			        	<div class="col-sm-12">
			          		<div class="form-group form-group-default">
			            		<label for="slug">Slug</label>
			            		<input type="text" id="slug" class="form-control required" name="slug" aria-required="true" aria-invalid="true" >
			          		</div>
			          	</div>
			      	</div>
			      	<div class="row">
			        	<div class="col-sm-12">
			          		<div class="form-group form-group-default">
			            		<label for="descripcion">Descripción</label>
			            		<textarea id="descripcion" class="form-control" name="descripcion" aria-required="true" aria-invalid="true"></textarea>
			          		</div>
			          	</div>
			      	</div>
			      	<div class="clearfix"></div>
			      	<input class="btn btn-primary" type="submit" value="Agregar Módulo">
			    </form>
		  	</div>
		</div>
		<!-- END PANEL -->
	</div>
	@stop