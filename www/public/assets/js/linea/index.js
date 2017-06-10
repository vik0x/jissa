$(document).ready(function(){

	$('#gallery_modal').on('hidden.bs.modal', function(){
		$('#list_gallery').html('');
		$('[name="delete[]"]').remove();
		$('#add_sucursal').val('');
		$('#modal_form_gallery').trigger('reset');
	});

	$('.gallery_images').on('click', function(){
		var context = $(this);
		$('#add_linea_gallery').val($(this).attr('data-id'));
		$.ajax({
			url: '/administrador/linea.html',
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
});