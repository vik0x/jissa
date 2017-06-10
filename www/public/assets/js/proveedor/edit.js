$(document).ready(function(){
	$('.img_proveedor').on('click', function(){
		$('#archivo').click();
	});
	$('#archivo').on('change',function(evt){
 		$('.img_proveedor').attr('src', URL.createObjectURL(evt.target.files[0]));
 	});
});