 $(document).on('ready', function(){

	$('#categorias').on('change', function(){
		slug_sucursal = $('#sucursales').val(); 
		id_categoria = $(this).val();
		linea = $('#linea').val();
		option_data(id_categoria, slug_sucursal,null,linea);
	});

	option_data = function(id_categoria, slug_sucursal, ids_maquinas = null, linea = null){

		ids_maquinas != null ? limit = 2 : limit = 4;

		$.ajax({
			type:'post',
			url:'/filtro-maquinas',
			data:{
				_method:'PATCH',
				id_categoria:id_categoria,
				slug_sucursal:slug_sucursal,
				ids_maquinas:ids_maquinas,
				limit:limit,
				linea:linea
			},
			success: function(data){
				
				if(data.length > 2){					
					data = JSON.parse(data);
					size = data.length;
					maquinas = '';
					if (ids_maquinas == null)
						$("#games").empty();	

					var imagen = "";
					$.each(data, function(index, val){
						imagen = val.thumb != null ? val.thumb : val.imagen;

						maquinas += '<li class="game posts-data" data-id="'+val.id+'">'
										+'<a href="/maquinas-de-juego/detalle/'+val.slug+'" style="background-image: url('+imagen+')">' 
											// +'<span class="jackpot">'
											// 	+'<small>JACKPOT</small>'
											// 	+'<strong>'
											// 		+"$"+val.acumulado
											// 	+'</strong>'
											+'</span>'
											+'<span class="game-title">'
												+'<strong>'
													+val.nombre
												+'</strong>'
												+'<span>'
													+val.resumen
												+'</span>'
											+'</span>'
										+'</a>'
									+'</li>';
					});
					$("#games").append(maquinas);
					$('#mas').show();
				}else{ 
					$('#mas').hide();					
					if (ids_maquinas == null)
						$("#games").empty();
				}
			},
			error: function () {									
				$('#mas').hide();					
				return false
			  }
		});
	}

	// $(".view_more").click(function(e){
	// 	e.preventDefault();
	// 	getposts();
	// });
    //
	// getposts = function(){
    //
	// 	slug_sucursal = $('#sucursales').val();
	// 	id_categoria = $('#categorias').val();
	// 	linea = $('#linea').val();
	// 	var ids_maquinas = [];
    //
	// 	var num_posts = $('.posts-data').size();
	// 	$(".posts-data").each(function(){
	// 		ids_maquinas.push($(this).data('id'));
	// 	});
    //
	// 	alert(slug_sucursal);
    //
	// 	option_data(id_categoria, slug_sucursal, ids_maquinas, linea);
	// }

	 var acumuladoslimit=4;
     $("#seeMoreAcumulados").click(function(e){

         e.preventDefault();
         $.ajax({
             type:'get',
             url:'/getAllDataAcumulados/null/'+acumuladoslimit,
			 dataType:'json',
             success: function(data){

				 console.log(data['acumulado']);
                   $.each(data['acumulado'], function(k , v) {
                  		var html='';
                 		html+='<div class="col col-1of2">';
                          html+='<article class="article-jackpot">';
                          	html+='<div class="article-content">';
                          		html+='<h6>';
									html+=data['acumulado'][k].titulo;
								html+='</h6>';

                          		html+='<div class="fake-div">';
                          				html+='<div id="counter">';
                          					html+='<div class="counter-value" ><p>$'+data['acumulado'][k].cantidad.toLocaleString('ja-JP')+'<em> MN</em></p></div>';
                      			html+='</div>';

                      			html+='<div class="fake-div">';

                      			html+='</div>';
                      		html+='</div>';
						 	// </div><!-- /.article-content -->
					      html+='</article>';
					    html+='</div>';

             		$("#seeMoreDataAcumulados").append(html);
                  });
                 acumuladoslimit=acumuladoslimit+4;

				 if(data['acumulado'].length < 4){
                     $("#seeMoreAcumulados").css('display','none');
				 }
             },
             error: function () {
                 $('#mas').hide();
                 return false
             }
         });
	 });


     var pagadoslimit=4;
     $("#seeMorePagados").click(function(e){

         e.preventDefault();
         $.ajax({
             type:'get',
             url:'/getAllDataPagados/null/'+pagadoslimit,
             dataType:'json',
             success: function(data){

                 console.log(data['pagados']);
                 $.each(data['pagados'], function(k , v) {
                     var html='';
                     html+='<div class="col col-1of2">';
                     html+='<article class="article-jackpot">';
                     html+='<div class="article-content">';
                     html+='<h6>';
                     html+=data['pagados'][k].titulo;
                     html+='</h6>';

                     html+='<div class="fake-div">';
                     html+='<div id="counter">';
                     html+='<div class="counter-value" ><p>$'+data['pagados'][k].cantidad.toLocaleString('ja-JP')+'<em> MN</em></p></div>';
                     html+='</div>';

                     html+='<div class="fake-div">';

                     html+='</div>';
                     html+='</div>';
                     // </div><!-- /.article-content -->
                     html+='</article>';
                     html+='</div>';

                     $("#seeMoreDataPagados").append(html);
                 });

                 pagadoslimit=pagadoslimit+4;

                 if(data['pagados'].length < 4){
                     $("#seeMorePagados").css('display','none');
                 }
             },
             error: function () {
                 $('#mas').hide();
                 return false
             }
         });
     });



	$(".branch-filter").change( function(){

		var $value = $( this ).val();
		var $url   = "/lineas-de-juego/maquinas-de-juego";

		if( $value != -1 ){

			$url = "/lineas-de-juego/maquinas-de-juego/" + $value;

		}

		$( location ).attr("href", $url);

	} );

	$(".branch-filter2").change( function(){

		var $value = $( this ).val();
		var $url   = "/sucursal";

		if( $value != -1 ){

			$url = "/sucursal/" + $value;

		}

		$( location ).attr("href", $url);

	} );

});