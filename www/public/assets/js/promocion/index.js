$(document).ready(function(){
	$('.activo').on('change', function(){
		id=parseInt($(this).attr('data'));
		$.ajax({
			url:'/administrador/estatus/sucursal.html',
			type:'POST',
			data:{
				id:id
			},
			success:function(data){
				console.log(data);
			}
		});
	});

	$('.promocion_btn').on('click', function(){
		var context = $(this);
		var id = parseInt($(this).attr('data-id'));
		$.ajax({
			url:'/administrador/promocion.html',
			type:'post',
			data:{
				_method:'post',
				promocion:id,
			},
			success:function(data){
				data = JSON.parse(data);
				$('#add_promocion').val(context.attr('data-id'));
				$('#nombre_sucursal').text(context.attr('data-promoname'));
				if(data.length > 0){
					$('#promo_list').html('');
					$.each(data, function(index,val){
						$('#add_sucursal>option[value="' + val.id_sucursal + '"]').attr('disabled',true);
						$('#promo_list').append('\
							<li class="list-group-item">' + val.nombre + '\
								<span class="btn btn-default badge" onClick="game_delete(' + val.id_sucursal + ',' + id + ')">\
									<i class="fa fa-trash" aria-hidden="true"></i>\
								</span>\
								<span class="btn btn-default badge" onClick="game_edit(' + val.id_sucursal + ',' + id + ')">\
									<i class="fa fa-pencil" aria-hidden="true"></i>\
								</span>\
							</li>');
					});
					// $('#promo_list').append()
				}
				$('#myModal').modal('show');
			}
		});
	});
	
	game_edit = function(sucursal,promocion){
		$.ajax({
			url:'/administrador/promocion.html',
			type:'post',
			data:{
				_method:'patch',
				promocion:promocion,
				sucursal:sucursal

			},
			success:function(data){
				if(data != ""){
					data = JSON.parse(data);
					data = data[0];
					$('#add_desc').text(data.descripcion);
					$('#add_link').val(data.link);
					$('#add_sucursal>option').attr('disabled',false);
					$('#add_sucursal>option').hide();
					$('#add_sucursal').val(sucursal);

					$('#add_imagen').attr('src',data.archivo);
					$('#add_sucursal').attr('readonly',true);
					$('#modal_form').attr('action','/administrador/modificar/promocion.html');
					$('#promo_list').hide();
					// $('#add_imagen').parent().parent().show();
					$('[type="submit"]').val('Modificar');
				}
			}
		});
	}

	game_delete = function(sucursal,promocion){
		$('#myModal').modal('hide');
		if( confirm('¿Eliminar elemento?') ){
			$.ajax({
				url:'/administrador/promocion.html',
				type:'post',
				data:{
					_method:'delete',
					id_sucursal:sucursal,
					id_promocion:promocion
				},
				success:function(){
					location.reload();
				}
			});
		}
	}

	$('#myModal').on('hidden.bs.modal', function(){
		$('#add_desc').text('');
		$('#add_link').val('');
		$('#add_sucursal>option').attr('disabled',false);
		$('#add_sucursal>option').show();
		$('#add_sucursal').val($('#add_sucursal').children().val());

		$('#add_imagen').attr('src','');
		$('#add_sucursal').attr('readonly',false);
		$('#modal_form').attr('action','/administrador/agregar/promocion.html');
		$('#promo_list').show();
		$('#add_imagen').parent().parent().hide();
		$('[type="submit"]').val('Agregar');
	});

	$('#pay_date1').timepicker({
        template: false,
        showInputs: false,
        minuteStep: 5
    });
	$('#pay_date2').timepicker({
        template: false,
        showInputs: false,
        minuteStep: 5
    });

	$('#pay_date').datepicker();

	$('.pay_btn').on('click', function(){
		var id = $(this).attr('data-id');
		context = $(this);

		$('#pay_id_promocion').val(id);
		$.ajax({
			url:'/promociones/branches',
			type:'post',
			data:{
				'id':id,
				'_method':'PATCH'
			},
			success:function(data){
				if( data.trim() != "" ){
					data = JSON.parse(data);
					console.log(data);
					$.each(data.sucursales, function(index,item){
						$('#pay_sucursal').append('<option value="' + item.id + '">' + item.nombre + '</option>')
					});
					$.each(data.dinamicas, function(index,item){
						$('#pay_list').append('\
							<li class="list-group-item">' + item.titulo + '\
								<span class="btn btn-default badge" onClick="pay_delete(' + item.id + ')">\
									<i class="fa fa-trash" aria-hidden="true"></i>\
								</span>\
								<span class="btn btn-default badge" onClick="pay_edit(' + item.id + ')">\
									<i class="fa fa-pencil" aria-hidden="true"></i>\
								</span>\
							</li>');
					});
					$('#payModal').modal('show');
				}
				else{
					$.notify(
					  "No hay sucursales asignadas a la promoción", 
					  {
					    globalPosition:"top center",
					    className:"warning",
					  }
					);
				}
			}
		});
	});

	pay_edit = function(id){
		$.ajax({
			url:'/administrador/obtener/pago_promocion.html',
			type:'post',
			data:{
				'_method':'PATCH',
				'id':id
			},
			success:function(data){
				if( data.trim() != "" ){
					console.log(data);
					data = JSON.parse(data);
					$('#pay_id_promocion').val(id);
					$('#pay_titulo').val(data.titulo);
					$('#pay_desc').val(data.descripcion);
					$('#pay_sucursal').val(data.sucursal);
					$('#pay_sucursal').attr('disabled',true);
					$('#pay_date').val(data.fecha);
					$('#pay_date1').val(data.inicio);
					$('#pay_date2').val(data.fin);
					$('#modal_pay_form').attr('action','/administrador/modificar/pago_promocion.html');
					$('#modal_pay_form > input:submit').val('Modificar');
				}
			}
		});
	}

	$('#payModal').on('hidden.bs.modal', function(){
		$('#pay_id_promocion').val('');
		$('#pay_titulo').val('');
		$('#pay_desc').val('');
		$('#pay_sucursal').val('');
		$('#pay_date').val('');
		$('#pay_date1').val('');
		$('#pay_date2').val('');
		$('#pay_sucursal').html('');
		$('#pay_list').html('');
		$('#pay_sucursal').attr('disabled',false);
		$('#modal_pay_form').attr('action','/administrador/agregar/pago_promocion.html');
		$('#modal_pay_form > input:submit').val('Guardar');
	});
});