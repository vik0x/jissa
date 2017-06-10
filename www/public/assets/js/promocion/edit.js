$(document).ready(function(){
	$('.img_promocion').on('click', function(){
		$('#imagen').click();
	});
	$('#imagen').on('change',function(evt){
 		$('.img_promocion').attr('src', URL.createObjectURL(evt.target.files[0]));
 	});

 	$('.img_thumb').on('click', function(){
		$('#thumb').click();
	});
	$('#thumb').on('change',function(evt){
 		$('.img_thumb').attr('src', URL.createObjectURL(evt.target.files[0]));
 	});

 	$('#elimina_imagen').on('click', function(){
 		$('#imagen_del').remove();
 		$('#imagen').show();
 		$('#form-agregar').append('<input type="hidden" name="borrar_imagen" value="1">');
 		return false;
 	});
 	$('#elimina_thumb').on('click', function(){
 		$('#thumb_del').remove();
 		$('#thumb').show();
 		$('#form-agregar').append('<input type="hidden" name="borrar_thumb" value="1">');
 		return false;
 	});
});