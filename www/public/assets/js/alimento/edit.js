$(document).ready(function(){
	$('.img_alimento').on('click', function(){
		$('#archivo').click();
	});
	$('#archivo').on('change',function(evt){
 		$('.img_alimento').attr('src', URL.createObjectURL(evt.target.files[0]));
 	});
});