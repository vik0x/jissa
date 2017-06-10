$(document).ready(function(){
	$('.img_torneo').on('click', function(){
		$('#archivo').click();
	});
	$('#archivo').on('change',function(evt){
 		$('.img_torneo').attr('src', URL.createObjectURL(evt.target.files[0]));
 	});
});