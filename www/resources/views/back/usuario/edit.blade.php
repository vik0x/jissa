@extends('layout.admin')
	@section('script')
		<script src="{{asset('/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('/assets/js/usuario/edit.js')}}" type="text/javascript"></script>
		<script>
			$(function(){
				$('#rol').val({{$usuario->id_rol}})
				if({{$usuario->id_rol}} == 3){
					$('#row_desarrollo').show();
			 		$('#id_desarrollo').val('{{$usuario->id_desarrollo}}');
				}
			});
		</script>
	@stop

	@section('contenido')
		@if(session()->has('error'))
			<div class="alert alert-danger">
		        <ul>
	                <li>{{ session('error') }}</li>
		        </ul>
		    </div>
		@endif
		@if (count($errors) > 0)
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		<div class="col-lg-7 col-md-6 col-md-offset-3">
			<!-- START PANEL -->
			<div class="panel panel-transparent">
		  		<div class="panel-body">
				    <form id="form-agregar" role="form" autocomplete="off" method="POST" action="{{url('/administrador/modificar/usuario' . $id . '.html')}}" enctype="multipart/form-data">
				    	{!!csrf_field()!!}
				    	<input type="hidden" name="_method" value="PATCH">
			      		<div class="row clearfix">
				        	<div class="col-sm-6">
				          		<div class="form-group form-group-default" aria-required="true">
				            		<label for="nombre">Nombre</label>
				            		<input type="text" id="nombre" class="form-control required" name="nombre" required="required" aria-required="true" aria-invalid="true" value="{{$usuario->nombre}}">
				          		</div>
				        	</div>
				        	<div class="col-sm-6">
				          		<div class="form-group form-group-default">
				            		<label for="apellido">Apellido</label>
				            		<input type="text" id="apellido" class="form-control required" name="apellido" required="required" aria-required="true" aria-invalid="true" value="{{$usuario->apellido}}">
				          		</div>
			        		</div>
				      	</div>
				      	<div class="row">
				        	<div class="col-sm-12">
				          		<div class="form-group form-group-default">
				            		<label for="email">Correo Electrónico</label>
				            		<input type="text" id="email" class="form-control mail required" name="email" placeholder="ejemplo@correo.com" required="" aria-required="true" aria-invalid="true" value="{{$usuario->email}}">
				          		</div>
				          	</div>
				      	</div>
				      	<div class="row">
				        	<div class="col-sm-12">
				          		<div class="form-group form-group-default">
				            		<label for="password">Contraseña</label>
				            		<input autocomplete="off" type="password" id="password" class="form-control" name="password" placeholder="Si no quiere modificar su contraseña, deje el campo en blanco" aria-required="true" aria-invalid="true">
				          		</div>
				        	</div>
				      	</div>
			      		<div class="row">
			        		<div class="col-sm-12">
				          		<div class="form-group form-group-default">
					            	<label for="telefono">Teléfono</label>
					            	<input type="phone" id="telefono" class="form-control" name="telefono" placeholder="Número celular" aria-required="true" aria-invalid="true" value="{{$usuario->telefono}}">
					          	</div>
					        </div>
				      	</div>
			      		<div class="row">
		        			<div class="col-sm-12">
		        				<div class="form-group form-group-default">
		        					<label for="rol">Rol</label>
					      			<select class="form-control" name="rol" id="rol">
					      				@foreach($roles as $rol)
				                      	<option value="{{$rol->id}}">{{$rol->nombre}}</option>
				                      	@endforeach
		                    		</select>
		                    	</div>
	                    	</div>
	                    </div>
	                    <div class="row">
			        		<div class="col-sm-12">
				          		<div class="form-group form-group-default">
					            	<label for="imagen">Foto</label>
					            	<img src="{{asset($usuario->imagen_perfil)}}" style="Cursor:pointer" class=" col-md-4 img-circle" id="perfil">
					            	<input type="file" id="imagen" class="form-control" name="imagen" placeholder="Número celular" required="" aria-required="true" aria-invalid="true" style="display:none">
					          	</div>
					        </div>
				      	</div>

				      	<!-- <p class="pull-left">
				        	I agree to the <a href="#">Pages Terms</a> and <a href="#">Privacy</a>.
				      	</p> -->
				      	<!-- <p class="pull-right">
				        	<a href="#">Help? Contact Support</a>
				      	</p> -->
				      	<div class="clearfix"></div>
				      	<input class="btn btn-primary" type="submit" value="Modificar Usuario">
				    </form>
			  	</div>
			</div>
			<!-- END PANEL -->
		</div>
	@stop