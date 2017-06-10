$(document).ready(function(){

  //En editar
    $( "#elimina_imagen" ).on('click', function(){
  		$('#imagen_principal').remove();
      $('#img_principal').show();
  		$('#eliminada').val('1');
  	}); 

  	//En agregar
  	$( "#elimina_img" ).click(function( e ) {
  		e.preventDefault();
  		$('#img_principal').val('');
  		return false;
  	});  	

});