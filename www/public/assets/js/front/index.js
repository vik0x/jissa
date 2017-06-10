 $(document).on('ready', function(){

	// $('.select_linea_de_juegos').dropdown();

	$('.modal_linea').on('click', function(){
		$('.select_linea_de_juegos').val($(this).attr('data-href')).trigger('change');
		$('#establecimiento_go').attr('href',$(this).attr('data-href'));
		$('[name="linea_ciudad"]').html('<option value=""> Selecciona tu ciudad </option>');
		$('[name="linea_sucursal"]').html('<option value=""> Selecciona tu casino </option>');
		$('[name="linea_ciudad"]').parent().dropdown('update');
		$('[name="linea_sucursal"]').parent().dropdown('update');
		$('.modal_establecimiento').fadeIn();
	});

	$('.select_linea_de_juegos').on('change', function(){
		var url_str = $('[name="lineas_de_juego"]>option:contains("' + $(this).parent().children()[1].innerText + '")').val();
		var id_get = $('[name="lineas_de_juego"]>option:contains("' + $(this).parent().children()[1].innerText + '")').attr('data-id');
		option_data(id_get,'/ciudades_sucursal',$('[name="linea_ciudad"]'));
		$('#establecimiento_go').attr('href',url_str);
	});

	$('.select_ciudad').on('change', function(){
		var id_get = $('[name="linea_ciudad"]>option:contains("' + $(this).parent().children()[1].innerText + '")').val();
		option_data(id_get,'/sucursales',$('[name="linea_sucursal"]'));
	});

	$('.select_linea_sucursal').on('change', function(){
		var url_str = $('[name="linea_sucursal"]>option:contains("' + $(this).parent().children()[1].innerText + '")').val();
		console.log($(this).parent().children()[1].innerText);
		$('#establecimiento_go').attr('data-sucursal',url_str);
	});

	$('#establecimiento_go').on('click', function(){
		$(this).attr('href',$(this).attr('href') + "/" + $(this).attr('data-sucursal'));
	});

	$('.modal_establecimiento_btn_cancelar').on('click', function(){
		$('.modal_establecimiento').fadeOut();
	});

	option_data = function(id,url,element){
		console.log(url);
		var optionselect = "selecciona tu diversión";
		switch( url ){
			case '/ciudades_sucursal':
				optionselect = "selecciona tu ciudad";
			break;
			case '/sucursales':
				optionselect = "selecciona tu casino";
			break;
		}
		$.ajax({
			type:'post',
			url:url,
			data:{
				_method:'PATCH',
				id:id
			},
			success: function(data){
				element.html('<option value="">' + optionselect + '</option>');
				if(data != ""){
					data = JSON.parse(data);
					$.each(data, function(index, val){
						element.append('<option value="' + val.id + '">' + val.nombre + '</option>')
					});
					// element.append('\
					// 	<option value="apuesta-deportiva">Apuesta Deportes</option>\
					// 	<option value="apuesta-de-carreras">Apuesta de Carreras</option>\
					// ');
				}
				element.parent().dropdown("update")
			}
		});
	}

	$('.select_ciudad_mapa').on('change touchstart', function(){
		var ciudad = $('[name="ciudad_mapa"]>option:contains("' + $(this).parent().children()[1].innerText + '")').attr('data-ciudad');
		$('#message').text('');
		$('.select_ciudad_modal2').val(ciudad).trigger('change');
		$('[name="sucursal_modal2"]').html('<option value=""> Seleccione sucursal</option>');
		$('[name="linea_modal2"]').html('<option value=""> Selecciona tu diversión</option>');
		$('[name="sucursal_modal2"]').parent().dropdown('update');
		$('[name="linea_modal2"]').parent().dropdown('update');
		$('.modal_ciudades').fadeIn();
		$('.fs-dropdown').removeClass('fs-dropdown-open');
	});

	$('.select_ciudad_modal2').on('change', function(){
		var id_get = $('[name="ciudad_modal2"]>option:contains("' + $(this).parent().children()[1].innerText + '")').attr('data-id');
		option_data(id_get,'/sucursales',$('[name="sucursal_modal2"]'));
		$('.fs-dropdown').removeClass('fs-dropdown-open');
	});

	$('.select_sucursal_modal2').on('change', function(){
		var id_get = $('[name="sucursal_modal2"]>option:contains("' + $(this).parent().children()[1].innerText + '")').val();
		option_data(id_get,'/lineas_ciudades',$('[name="linea_modal2"]'));
		$('#establecimiento_go2').attr('data-sucursal',id_get);
		$('#establecimiento_go2').attr('href','/sucursal');
		$('.fs-dropdown').removeClass('fs-dropdown-open');
	});

	$('.select_linea_modal2').on('change', function(){
		var id_get = $('[name="linea_modal2"]>option:contains("' + $(this).parent().children()[1].innerText + '")').val();
		$('#establecimiento_go2').attr('href','');
		$('.fs-dropdown').removeClass('fs-dropdown-open');
		if (id_get == "")
			$('#establecimiento_go2').attr('href','/sucursal');
		else
			$('#establecimiento_go2').attr('href','/lineas-de-juego/'+id_get);
	});

	$('#establecimiento_go2').on('click', function(){
		if($(this).attr('href') == undefined)
			$('#message').text('Seleccione la sucursal y la línea de juego');
		else
		{
			$('#message').text('');
			$(this).attr('href',$(this).attr('href') + "/" + $(this).attr('data-sucursal'));
		}
	});

	$('.modal_ciudad_btn_cancelar').on('click', function(){
		$('.modal_ciudades').fadeOut();
	});

	$(".branch-filter").change( function(){

		var $value = $( this ).val();
		var $url   = "/lineas-de-juego/maquinas-de-juego";

		if( $value != -1 ){

			$url = "/lineas-de-juego/maquinas-de-juego/" + $value;

		}

		$( location ).attr("href", $url);

	} );

});
