$(document).ready(function(){
	$('.img_slider').on('click', function(){
		$('#imagen').click();
	});
	$('#imagen').on('change',function(evt){
 		$('.img_slider').attr('src', URL.createObjectURL(evt.target.files[0]));
 	});
});