@extends('layout.admin')

	@section('css')
		<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
		<link rel="stylesheet" href="plugins/bootstrap-timepicker/bootstrap-timepicker.min.css">
	@stop
	@section('script')
		<script src="plugins/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
		<script>
			$(function(){
				$('.activo').on('change', function(){
					id=parseInt($(this).attr('data'));
					$.ajax({
						url:'/administrador/estatus/eventos.html',
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
						<div class="panel-title"><Eventos></Eventos>
						</div>
						<div class="pull-right">
							<div class="col-xs-12">
		                    	<a href="{{url('/administrador/agregar/eventos.html')}}" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Agregar</a>
			              	</div>
		                </div>
					</div>
					</br>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						@foreach($torneos as $val => $sucursal)
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="panel{{$val}}">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#interno{{$val}}" aria-expanded="true" aria-controls="interno{{$val}}">
											{{current($sucursal)->sucursal}}
										</a>
									</h4>
								</div>
								<div id="interno{{$val}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel{{$val}}">
									<div class="panel-body">
										<div class="table-responsive">
											<div id="detailedTable_wrapper" class="dataTables_wrapper form-inline no-footer">
												<table class="table table-hover table-condensed table-detailed dataTable no-footer" id="detailedTable" role="grid">
													<thead>
														<tr role="row">
															<th class="sorting_disabled" rowspan="1" colspan="1">Nombre</th>
															<th class="sorting_disabled" rowspan="1" colspan="1">Sucursal</th>
															<th class="sorting_disabled" rowspan="1" colspan="1">Tipo</th>
															<th class="sorting_disabled" rowspan="1" colspan="1">Inicio</th>
															<th class="sorting_disabled" rowspan="1" colspan="1">Fin</th>
															<th class="sorting_disabled" rowspan="1" colspan="1">Estatus</th>
															<th class="sorting_disabled" rowspan="1" colspan="1">Opciones</th>
														</tr>
													</thead>
													<tbody>
														@foreach($sucursal as $carrera)
														<tr role="row" class="">
															<td class="v-align-middle">{{$carrera->nombre}}</td>
															<td class="v-align-middle">{{$carrera->sucursal}}</td>
															<td class="v-align-middle">{{$carrera->tipo}}</td>
															<td class="v-align middle">{{$carrera->fecha_inicio}}</td>
															<td class="v-align middle">{{$carrera->fecha_fin}}</td>
															<td class="v-align-middle">
																<div class="btn-group btn-group-justified">
																	
										                            <div class="btn-group">
										                              	<form action="{{url('/administrador/modificar/eventos' . $carrera->id . '.html')}}" method="post">
																			{!!csrf_field()!!}
																			<button type="submit" class="btn btn-default">
											                              		<span class="p-t-5 p-b-5">
											                              			<i class="fa fa-paste fs-15"></i>
											                              		</span>
											                              		<br>
											                              		<span class="fs-11 font-montserrat text-uppercase">Modificar</span>
											                              	</button>
																		</form>
										                            </div>
										                            <div class="btn-group">
										                            	<form action="{{url('/administrador/eliminar/eventos' . $carrera->id . '.html')}}" method="post" class="del_element">
																			{!!csrf_field()!!}
																			<input type="hidden" name="_method" value="DELETE">
											                              	<button type="submit" class="btn btn-default">
											                              		<span class="p-t-5 p-b-5">
											                              			<i class="fa fa-trash-o fs-15"></i>
											                              		</span>
											                              		<br>
											                              		<span class="fs-11 font-montserrat text-uppercase">Eliminar</span>
											                              	</button>
											                            </form>
									                              	</div>
										                        </div>
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<!-- END PANEL -->
			</div>
		</div>
	@stop