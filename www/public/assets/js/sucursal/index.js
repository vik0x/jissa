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

	$('.game_btn').on('click', function(){
		var context = $(this);
		var id = parseInt($(this).attr('data-id'));
		$.ajax({
			url:'/administrador/juego.html',
			type:'post',
			data:{
				_method:'post',
				sucursal:id,
			},
			success:function(data){
				console.log(data);
				data = JSON.parse(data);
				$('#add_sucursal').val(context.attr('data-id'));
				$('#nombre_sucursal').text(context.attr('data-sucname'));
				if(data.length > 0){
					$('#game_list').html('');
					$.each(data, function(index,val){
						$('#game_list').append('\
							<li class="list-group-item">' + val.juego + '\
								<span class="btn btn-default badge" onClick="game_delete(' + val.id_juego + ',' + id + ')">\
									<i class="fa fa-trash" aria-hidden="true"></i>\
								</span>\
								<span class="btn btn-default badge" onClick="game_edit(' + val.id_juego + ',' + id + ')">\
									<i class="fa fa-pencil" aria-hidden="true"></i>\
								</span>\
							</li>');
					});
					// $('#game_list').append()
				}
				$('#myModal').modal('show');
			}
		});
	});
	
	game_edit = function(id,sucursal){
		$.ajax({
			url:'/administrador/juego.html',
			type:'post',
			data:{
				_method:'patch',
				sucursal:sucursal,
				id:id

			},
			success:function(data){
				if(data != ""){
					data = JSON.parse(data);
					$('#add_desc').text(data.descripcion);
					$('#add_link').val(data.link);
					$('#add_juego').val(id);
					$('#add_disp').val(data.disponibles);
					$('#add_apuesta').val(data.apuesta_minima);
					$('#add_acumulado').val(data.acumulado);
					$('#add_pagado').val(data.pagado);

					$('#add_imagen').attr('src',data.archivo);
					$('#add_juego').attr('readonly',true);
					$('#modal_form').attr('action','/administrador/modificar/juego.html');
					$('#game_list').hide();
					$('#add_imagen').parent().parent().show();
					$('[type="submit"]').val('Modificar');
				}
			}
		});
	}

	game_delete = function(id,sucursal){
		$('#myModal').modal('hide');
		if( confirm('¿Eliminar elemento?') ){
			$.ajax({
				url:'/administrador/juego.html',
				type:'post',
				data:{
					_method:'delete',
					id_sucursal:sucursal,
					id_juego:id
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
		$('#add_juego').val($('#add_juego').children().val());
		$('#add_disp').val('');
		$('#add_apuesta').val('');
		$('#add_acumulado').val('');
		$('#add_pagado').val('');

		$('#add_imagen').attr('src','');
		$('#add_juego').attr('readonly',false);
		$('#modal_form').attr('action','/administrador/agregar/juego.html');
		$('#game_list').show();
		$('#add_imagen').parent().parent().hide();
		$('[type="submit"]').val('Agregar');
	});

	$('#gallery_modal').on('hidden.bs.modal', function(){
		$('#list_gallery').html('');
		$('[name="delete[]"]').remove();
		$('#add_sucursal').val('');
		$('#modal_form_gallery').trigger('reset');
	});

	$('.gallery_images').on('click', function(){
		var context = $(this);
		$('#add_sucursal_gallery').val($(this).attr('data-id'));
		$.ajax({
			url: '/administrador/sucursal.html',
			type: 'post',
			data: {
				id: context.attr('data-id')
			},
			success: function(data){
				if( data.trim != "" ){
					data = JSON.parse(data);
					$.each(data, function(index,val){
						$('#list_gallery').append('\
							<div class="col-sm-4" id="gallery_item_' + val.id + '">\
								<button type="button" class="close" onClick="delete_image(' + val.id + ')" aria-hidden="true">&times;</button>\
								<div class="thumbnail">\
									<img src="' + val.imagen + '">\
								</div>\
							</div>')
					});
				}
			}
		});
		$('#gallery_modal').modal('show');
	});

	delete_image = function(id){
		$('#gallery_item_' + id).remove();
		$('#modal_form_gallery').append('<input type="hidden" name="delete[]" value="' + id + '">')
	}

	$('.pay_btn').on('click', function(){
		var context = $(this);
		var id = parseInt($(this).attr('data-id'));
		$.ajax({
			url:'/administrador/ver/pago.html',
			type:'post',
			data:{
				_method:'post',
				sucursal:id,
			},
			success:function(data){
				console.log(data);
				data = JSON.parse(data);
				$('#pay_sucursal').val(context.attr('data-id'));
				$('#nombre_pay').text(context.attr('data-sucname'));
				if(data.length > 0){
					$('#pay_list1').html('');
					$('#pay_list2').html('');
					$('#pay_list3').html('');
					$.each(data, function(index,val){
						$('#pay_list' + val.id_tipo).append('\
							<li class="list-group-item pay_item" data-id="' + val.id_pago + '">' + val.titulo + '\
								<span class="btn btn-default badge" onClick="pay_delete(' + val.id_pago + ')">\
									<i class="fa fa-trash" aria-hidden="true"></i>\
								</span>\
								<span class="badge">\
									' + val.cantidad + '\
								</span>\
							</li>');
					});
				}
				$('#payModal').modal('show');
			}
		});
	});

	pay_delete = function(id){
		if( confirm('¿Eliminar?') ){
			$.ajax({
				url:'/administrador/borrar/pago.html',
				type:'post',
				data:{
					_method:'delete',
					pago:id,
				},
				success:function(data){
					if(data == 1)
						$('.pay_item[data-id="' + id + '"]').remove();
				}
			});
		}
	}

	$('#payModal').on('hide.bs.modal', function(){
		$('#pay_list1').html('');
		$('#pay_list2').html('');
		$('#pay_sucursal').val('');
		$('#nombre_pay').text('');
	});
});