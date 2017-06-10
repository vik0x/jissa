$(document).on('ready', function(){

	$(".ver-mesa").click(function(e){
		e.preventDefault();
		id_mesa = $(this).attr('data-id');
		id_sucursal = $(this).attr('data-sucursal');

		$.ajax({
			type:'post',
			url:'/get-mesa-juego',
			data:{
				_method:'PATCH',
				id_mesa:id_mesa,
				id_sucursal:id_sucursal
			},
			success: function(data){
				
				if(data.length > 2){					
					data = JSON.parse(data);
					size = data.length;
					mesa = '';
					apuesta = '';
					descripcion = '';
					$(".article-content").remove();

					$.each(data, function(index, val){

						if (val.archivo != null && val.archivo.trim() != "" )
							imagen = val.archivo;
						else
							imagen = val.imagen;

						if (val.apuesta_minima != null) {
							apuesta += '<div class="article-label">'
						 						+'<span> Apuesta Mínima DESDE </span>'
						 						+'<strong> '+val.apuesta_minima+' </strong>'
						 				+'</div>';
						}

						if ($.trim(val.descripcion) != "")
							descripcion = val.descripcion;
						else
							descripcion = val.resumen;

						mesa = '<div class="article-content">'
					 				+'<div class="article-image" style="background-image: url('+imagen+')">'  
					 					+apuesta
					 					+'<div class="article-max-price">'
					 						+'CONSULTA MONTOS MÁXIMOS DE APUESTA EN EL CASINO'
					 					+'</div>'
					 				+'</div>'

					 				+'<div class="article-entry">'
					 					+'<h4 class="article-title">'
					 						+val.nombre
					 						+'<small>'
					 							+val.disponibles+' mesas'
					 						+'</small>'
					 					+'</h4>'

										+'<p>'
											+descripcion
										+'</p>'

										+'<ul class="list-links">'
											+'<li>'
												+'<a href="/aprende_a_jugar/'+val.slug+'" class="btn btn-border">'
													+'Aprende a jugar'
												+'</a>'
											+'</li>'

											+'<li>'
												+'<a href="/reglas/'+val.slug+'" class="btn btn-border btn-border-grey">'
													+'Reglas'
												+'</a>'
											+'</li>'
										+'</ul>'
					 				+'</div>'
						 		+'</div>';
					});
					$("#article-mesa").append(mesa);
				}else{ 
					$(".article-content").remove();
				}
			},
			error: function () {						
				return false
			  }
		});

	});

});