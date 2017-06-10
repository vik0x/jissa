$(document).ready(function(){
	
	$('#gallery_modal').on('hidden.bs.modal', function(){
		$('#list_gallery').html('');
		$('[name="delete[]"]').remove();
		$('#add_sucursal').val('');
		$('#modal_form_gallery').trigger('reset');
	});

	$('.gallery_images').on('click', function(){
		var context = $(this);
		$('#id_sucursal').val($(this).attr('data-id'));
		$.ajax({
			url: '/administrador/slider/calendario.html',
			type: 'post',
			data: {
				id: context.attr('data-id')
			},
			success: function(data){
				if( data.trim != "" ){
					data = JSON.parse(data);
					$.each(data, function(index,val){
						$('#list_gallery').append('\
							<div class="col-sm-4" id="gallery_item_' + val.id_slider + '">\
								<button type="button" class="close" onClick="delete_image(' + val.id_slider + ')" aria-hidden="true">&times;</button>\
								<div class="thumbnail">\
									<img src="/	' + val.imagen + '">\
								</div>\
								<input type="text" name="titulo_imagen[' + val.id_slider + ']" value="' + val.titulo + '" class="form-control">\
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
});