//intentar regresar una vista return view() desde el controlador.
$(document).ready(function(){
	$('#ab-contenido').append('\
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ab-modal">\
		  	<div class="modal-dialog modal-lg">\
			    <div class="modal-content">\
			    	<div class="modal-header">\
	    	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
		    	        <h4 class="modal-title" id="myModalLabel">Detalle</h4>\
	    	      	</div>\
	    	      	<div class="modal-body">\
	    	      	</div>\
	    	      	<div class="modal-footer">\
	    	      	</div>\
			    </div>\
	  		</div>\
		</div>\
	');
	$('.del_element').on('submit', function(){
		if(!confirm('Eliminar elemento'))
			return false;
	});
	$('.mostrar').on('click', function(){
		context = $(this);
		id = context.attr('data-id');
		modulo = context.attr('data-modulo');
		url = context.attr('data-href');
		$.ajax({
			url:url,
			type:'get',
			data:{
				id:id,
				modulo:modulo,
			},
			success:function(data){
				$('.modal-body').html(data);
				$('#ab-modal').modal('show');
			}
		});
	});
});