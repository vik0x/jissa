$(function(){
	//Guarda las cotizaciones
	$('#cotiza').on('click',function(){
		nombre = $('#nombre').val();
		apellido = $('#apellido').val();
		rfc = $('#rfc').val();
		edad = $('#edad').val();
		telefono = $('#telefono').val();
		email = $('#email').val();
		id_desarrollo = $('#id_desarrollo').val().trim();
		mensaje = "";
		$.ajax({
			type:"post",
			url:$('#base_url').val().trim() + '/desarrollo/cotizador/guardar.html',
			data:{
				_token:$('#token').val().trim(),
				_method:"PATCH",
				nombre:nombre,
				apellido:apellido,
				rfc:rfc,
				edad:edad,
				telefono:telefono,
				email:email,
				id_desarrollo:id_desarrollo
			},
			success:function(data){
				if(data == 1){
					nombre = $('#nombre').val('');
					apellido = $('#apellido').val('');
					rfc = $('#rfc').val('');
					edad = $('#edad').val('');
					telefono = $('#telefono').val('');
					email = $('#email').val('');
					mensaje = "Cotización guardada correctamente";
					// location.reload();
				}
				else{
					if (data == 2){
						mensaje = "No se guardo la cotización, vuela a intentarlo";
					}
				}
				$('#contenido_mensaje').html(mensaje);	
				$('#mensaje').show();
				$('#mensaje').delay(3000).hide(200);
			}
		});
	});
});
