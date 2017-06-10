@extends('layout.admin')

	@section('css')
		<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	@stop
	@section('script')
		<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
		<script>
			$(function(){
				$('.activo').on('change', function(){
					id=parseInt($(this).attr('data'));
					$.ajax({
						url:'/administrador/estatus/rol.html',
						type:'POST',
						data:{
							_token:"{{csrf_token()}}",
							id:id
						},
						success:function(data){
							console.log(data);
						}
					});
				});
			});
		</script>
		<script src="{{asset('/assets/js/index.js')}}"></script>
	@stop

	@section('contenido')
		<div class="row">
			<div class="col-md-12">
			<!-- START PANEL -->
				<div class="panel panel-transparent">
					<div class="panel-heading">
						<div class="panel-title">Privilegios para {{$rol->nombre}}</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<div id="detailedTable_wrapper" class="dataTables_wrapper form-inline no-footer">
								<form action="{{url('/administrador/agregar/privilegio' . $id . '.html')}}" method="POST">
									<input type="hidden" name="_method" value="PUT">
									{{csrf_field()}}
									<table class="table table-hover table-condensed table-detailed dataTable no-footer" id="detailedTable" role="grid">
										<thead>
											<tr role="row">
												<th class="sorting_disabled" rowspan="1" colspan="1">Módulo</th>
												@foreach($permisos as $permiso)
												<th class="sorting_disabled" rowspan="1" colspan="1">{{$permiso->nombre}}</th>
												@endforeach
											</tr>
										</thead>
										<tbody>
											@foreach($modulos as $modulo)
											<tr role="row" class="">
												<td class="v-align-middle">{{$modulo->nombre}}</td>
												@foreach($permisos as $permiso2)
												<td class="v-align-middle"><input type="checkbox" name="privilegio[{{$modulo->id_modulo}}][{{$permiso2->id_permiso}}]" id="" {{isset($privilegio[$modulo->id_modulo][$permiso2->id_permiso]) ? "checked" : ""}} data-toggle="toggle"></td>
												@endforeach
											</tr>
											@endforeach
										</tbody>
									</table>
									<div class="pull-right">
										<div class="col-xs-12">
					                    	<a class="btn btn-danger btn-cons" href="{{\URL::previous()}}"><i class="fa fa-plus"></i> Cancelar</a>
					                    	<button type="submit" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Guardar</button>
						              	</div>
					                </div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- END PANEL -->
			</div>
		</div>
	@stop

